<?php

namespace App\Support\Console\Commands;

use App\Support\Client\Concerns\InternalSettings;
use App\Support\Concerns\ClassHelper;
use App\Support\Console\Application;
use App\Support\Console\Concerns\ExecutionWrap;
use App\Support\Console\Sheller;
use App\Support\Exceptions\ShellException;
use App\Support\Facades\App;
use App\Support\Facades\Artisan;
use App\Support\Facades\Shell;
use Closure;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method Application getApplication()
 */
abstract class Command extends BaseCommand
{
    use ClassHelper, ExecutionWrap, InternalSettings;

    public const OPTION_DEBUG = 'x-debug';
    public const PARAMETER_DEBUG = '--' . self::OPTION_DEBUG;
    public const OPTION_OFF_SHOUT_OUT = 'off-shout-out';
    public const PARAMETER_OFF_SHOUT_OUT = '--' . self::OPTION_OFF_SHOUT_OUT;
    public const OPTION_CLIENT = 'x-client';
    public const PARAMETER_CLIENT = '--' . self::OPTION_CLIENT;

    protected bool $queuedOnRequest = false;

    public function __construct()
    {
        if (isset($this->signature)) {
            if (trim($this->signature)[0] === '{') {
                $this->signature = $this->generateName() . ' ' . $this->signature;
            }
        }
        elseif (!isset($this->name)) {
            $this->name = $this->generateName();
        }

        parent::__construct();
    }

    protected function generateName(): string
    {
        return implode(
            ':',
            array_map(
                static function ($name) {
                    return Str::snake($name, '-');
                },
                (static function (array $names) {
                    if (($count = count($names)) === 1 && $names[0] === '') {
                        return ['command'];
                    }
                    if ($count >= 2) {
                        $l1 = array_pop($names);
                        while (($l2 = array_pop($names)) && $l2 === $l1) {
                        }
                        array_push($names, ...array_filter([$l2, $l1]));
                    }
                    return $names;
                })(explode('\\', rtrim(preg_replace('/^App(\\\\\w+)*\\\\Commands\\\\|Command$/', '', $this->className()), '\\')))
            )
        );
    }

    protected function configure(): void
    {
        parent::configure();
        $this->specifyDefaultParameters();
    }

    protected function specifyDefaultParameters(): void
    {
        foreach ($this->getDefaultArguments() as $arguments) {
            if ($arguments instanceof InputArgument) {
                $this->getDefinition()->addArgument($arguments);
            }
            else {
                $this->addArgument(...array_values($arguments));
            }
        }

        foreach ($this->getDefaultOptions() as $options) {
            if ($options instanceof InputOption) {
                $this->getDefinition()->addOption($options);
            }
            else {
                $this->addOption(...array_values($options));
            }
        }
    }

    protected function getDefaultArguments(): array
    {
        return [];
    }

    protected function getDefaultOptions(): array
    {
        return [];
    }

    protected function runCommand($command, array $arguments, OutputInterface $output): int
    {
        $arguments[self::PARAMETER_OFF_SHOUT_OUT] = true;
        foreach ($this->getFinalInternalSettings() as $name => $value) {
            $arguments["--x-$name"] = $value;
        }

        return $this->wrapRunning(
            $this->laravel,
            $this->getApplication(),
            $this->resolveCommand($command),
            $this->createInputFromArguments(['command' => $command] + $arguments),
            $output,
            function ($command, $input, $output) {
                return $command->run($input, $output);
            }
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->withInternalSettings(function () use ($input, $output) {
            return parent::execute($input, $output);
        });
    }

    public function text($string, $style = null, $verbosity = null): void
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->write($styled, false, $this->parseVerbosity($verbosity));
    }

    public function textInfo($string, $verbosity = null): void
    {
        $this->text($string, 'info', $verbosity);
    }

    public function textError($string, $verbosity = null): void
    {
        $this->text($string, 'error', $verbosity);
    }

    public function textComment($string, $verbosity = null): void
    {
        $this->text($string, 'comment', $verbosity);
    }

    public function textWarn($string, $verbosity = null): void
    {
        $this->text($string, 'warning', $verbosity);
    }

    public function textCaution($string, $verbosity = null): void
    {
        $this->text($string, 'caution', $verbosity);
    }

    public function lineWithBadge($string, $badge, $style = null, $badgeStyle = null, $verbosity = null): void
    {
        $styled = $style ? "<$style>$string</$style>" : $string;
        $badgeStyled = $badgeStyle ? "<$badgeStyle>$badge</$badgeStyle>" : $badge;

        $this->output->writeln($badgeStyled . ' ' . $styled, $this->parseVerbosity($verbosity));
    }

    public function caution($string, $verbosity = null): void
    {
        $this->line($string, 'caution', $verbosity);
    }

    public function cautionWithBadge($string, $badge = 'CAUTION', $verbosity = null): void
    {
        $this->lineWithBadge($string, ' ' . $badge . ' ', 'caution', 'error-badge', $verbosity);
    }

    protected function handleBefore(): void
    {
    }

    protected function handleAfter(): void
    {
    }

    protected function queue(string $command, array $parameters = []): PendingDispatch
    {
        return Artisan::queue($command, $parameters);
    }

    protected function queueSelf(?array $parameters = null): PendingDispatch
    {
        return $this->queue($this->name, $parameters ?? array_merge(with($this->arguments(), static function (array $arguments) {
            $parameters = [];
            foreach ($arguments as $key => $argument) {
                if (is_null($argument) || $argument === 'command') {
                    continue;
                }
                $parameters[$key] = $argument;
            }
            return $parameters;
        }), with($this->options(), static function (array $options) {
            $parameters = [];
            foreach ($options as $key => $option) {
                if (is_null($option) || $option === false) {
                    continue;
                }
                $parameters["--$key"] = $option;
            }
            return $parameters;
        })));
    }

    protected function shouldQueue(): bool
    {
        return $this->queuedOnRequest && !App::runningSolelyInConsole();
    }

    public function handle(): int
    {
        if (!$this->shouldQueue()) {
            $this->handleBefore();
            $exit = $this->handling();
            $this->handleAfter();
            return $exit;
        }
        $this->queueSelf();
        return $this->exitSuccess();
    }

    abstract protected function handling(): int;

    protected function exitSuccess(): int
    {
        return self::SUCCESS;
    }

    protected function exitFailure(): int
    {
        return self::FAILURE;
    }

    protected function exitInvalid(): int
    {
        return self::INVALID;
    }

    protected function getSheller(): Sheller
    {
        return Shell::getFacadeRoot();
    }

    /**
     * @throws ShellException
     */
    protected function handleShell(string $shell, Closure $callback = null): int
    {
        if ($canShoutOut = $this->wrapCanShoutOut($this, $this->input)) {
            $this->info('Shell started.');
            $this->warn($shell);
            $this->line(str_repeat('-', 50));
        }
        $sheller = $this->getSheller();
        $exitCode = $sheller->run($shell, $callback);
        $successful = $sheller->successful();
        if ($output = $sheller->output()) {
            $successful
                ? $this->line($output)
                : $this->warn($output);
        }
        if ($canShoutOut) {
            $this->line(str_repeat('-', 50));
            $successful
                ? $this->info(sprintf('Shell succeeded (exit code: %d).', $exitCode))
                : $this->cautionWithBadge(sprintf('Shell failed (exit code: %d).', $exitCode), 'ERROR');
        }
        return $exitCode;
    }
}

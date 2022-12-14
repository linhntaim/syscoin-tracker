<?php

namespace App\Support\Console\Commands;

use App\Support\Exports\Export;
use App\Support\Exports\ModelCsvExport;
use App\Support\Http\Resources\Concerns\ResourceTransformer;
use App\Support\Models\FileProvider;

abstract class ExportCommand extends Command
{
    use ResourceTransformer;

    public $signature = '{--per-read=1000}';

    protected function perRead(): int
    {
        return (int)($this->option('per-read') ?? 1000);
    }

    protected function exportArguments(): array
    {
        return [];
    }

    abstract protected function exportClass(): string;

    protected function export(): Export
    {
        return transform($this->exportClass(), function ($class) {
            return with(new $class(...$this->exportArguments()), function (Export $export) {
                if ($export instanceof ModelCsvExport) {
                    $export->perRead($this->perRead());
                }
                return $export;
            });
        });
    }

    protected function handling(): int
    {
        $this->warn('Export started.');
        $export = $this->export();
        do {
            $filer = !isset($file) ? $export() : $export($file);
            $completed = $export->chunkEnded();
            $file = !isset($file)
                ? (new FileProvider())
                    ->enablePublish($completed)
                    ->createWithFiler($filer)
                : (new FileProvider())
                    ->withModel($file)
                    ->enablePublish($completed)
                    ->updateWithFiler($filer);
        }
        while (!$completed);
        $this->line(sprintf('<info>Exported:</info> %d.', $export->count()));
        $this->info('File:');
        print_r($this->resourceTransform($file));
        return $this->exitSuccess();
    }
}

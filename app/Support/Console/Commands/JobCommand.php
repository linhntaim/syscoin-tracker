<?php

namespace App\Support\Console\Commands;

use App\Support\Jobs\Job;

abstract class JobCommand extends Command
{
    protected string $jobClass;

    protected array $jobParams = [];

    protected function getJobClass(): string
    {
        return $this->jobClass;
    }

    protected function getJobParams(): array
    {
        return $this->jobParams;
    }

    protected function getJob(): ?string
    {
        if (is_a($class = $this->getJobClass(), Job::class, true)) {
            return $class;
        }
        return null;
    }

    protected function handling(): int
    {
        $this->runJob();
        return $this->exitSuccess();
    }

    protected function runJob(): void
    {
        if ($job = $this->getJob()) {
            $job::dispatch(...$this->getJobParams());
        }
    }
}

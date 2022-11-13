<?php

namespace App\Tracker\Console\Commands\Addresses\FromBlock;

use App\Support\Console\Commands\Command;

class LatestCommand extends Command
{
    use AccessLatestTrackedBlock;

    public $signature = '{--set=}';

    protected function latestTrackedBlockForSetting(): ?int
    {
        return is_null($latestTrackedBlock = $this->option('set')) ? null : (int)$latestTrackedBlock;
    }

    protected function handling(): int
    {
        if (!is_null($latestTrackedBlock = $this->latestTrackedBlockForSetting()) && $this->confirm(sprintf('Set the latest tracked block to %d?', $latestTrackedBlock))) {
            $this->rememberLastTrackedBlock($latestTrackedBlock);
        }
        $this->line(sprintf('<info>Latest tracked block:</info> %d.', $this->lastTrackedBlock()));
        return $this->exitSuccess();
    }
}
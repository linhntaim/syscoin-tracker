<?php

namespace App\Tracker\Console\Commands\Addresses\FromUtxo;

use App\Support\Console\Commands\Command;

class LastCommand extends Command
{
    use AccessLastBlock;

    public $signature = '{--set=}';

    protected function lastBlockForSetting(): ?int
    {
        return is_null($lastBlock = $this->option('set')) ? null : (int)$lastBlock;
    }

    protected function handling(): int
    {
        if (!is_null($lastBlock = $this->lastBlockForSetting()) && $this->confirm(sprintf('Set the last block to %d?', $lastBlock))) {
            $this->rememberLastBlock($lastBlock);
        }
        $this->line(sprintf('<info>Last block:</info> %d.', $this->lastBlock()));
        return $this->exitSuccess();
    }
}
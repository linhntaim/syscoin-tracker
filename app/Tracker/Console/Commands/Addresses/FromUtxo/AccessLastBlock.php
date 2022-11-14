<?php

namespace App\Tracker\Console\Commands\Addresses\FromUtxo;

use Illuminate\Support\Facades\Cache;

trait AccessLastBlock
{
    protected function lastBlock(): int
    {
        return Cache::get('addresses.from_utxo.last_block', 0);
    }

    protected function rememberLastBlock(int $block): void
    {
        Cache::forever('addresses.from_utxo.last_block', $block);
    }
}
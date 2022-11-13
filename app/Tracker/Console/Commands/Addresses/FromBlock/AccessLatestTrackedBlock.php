<?php

namespace App\Tracker\Console\Commands\Addresses\FromBlock;

use Illuminate\Support\Facades\Cache;

trait AccessLatestTrackedBlock
{
    protected function lastTrackedBlock(): int
    {
        return Cache::get('track_addresses.last_tracked_block', 0);
    }

    protected function rememberLastTrackedBlock(int $block): void
    {
        Cache::forever('track_addresses.last_tracked_block', $block);
    }
}
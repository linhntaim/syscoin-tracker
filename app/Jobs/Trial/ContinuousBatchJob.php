<?php

namespace App\Jobs\Trial;

use App\Support\Facades\App;
use App\Support\Jobs\ContinuousBatchJob as BaseContinuousBatchJob;
use Illuminate\Support\Facades\Log;

class ContinuousBatchJob extends BaseContinuousBatchJob
{
    protected function batchByIndex(int $batchIndex): iterable
    {
        return $this->batchIndex() < 10 ? range($batchIndex * 10, ($batchIndex + 1) * 10 - 1) : [];
    }

    protected function handleBatchItem($item)
    {
        Log::info(sprintf('Batch_%02d [%02d]: %s', $this->batchIndex(), $item, $date = date_timer()->compound('longDate', ' ', 'longTime')));
        if (App::runningSolelyInConsole()) {
            echo sprintf('Batch_%02d [item_%02d]: %s', $this->batchIndex(), $item, $date) . PHP_EOL;
        }
    }
}

<?php

namespace App\Tracker\Console\Commands\Addresses\FromUtxo;

use Carbon\Carbon;

trait ParseTxTimes
{
    protected function parseTxTimes(array $addressPayload): array
    {
        $firstAt = $lastAt = null;
        if ($addressPayload['txs'] === 1) {
            $firstAt = $lastAt = Carbon::createFromTimestamp($this->utxo->getTx($addressPayload['txids'][0])['blockTime']);
        }
        elseif ($addressPayload['txs'] > 1) {
            $firstAt = Carbon::createFromTimestamp($this->utxo->getTx($addressPayload['txids'][0])['blockTime']);
            $lastAt = Carbon::createFromTimestamp($this->utxo->getTx($addressPayload['txids'][$addressPayload['txs'] - 1])['blockTime']);
        }
        return [$firstAt, $lastAt];
    }
}
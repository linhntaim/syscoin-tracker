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

            if ($addressPayload['txs'] > 1000) {
                $lastPage = (int)($addressPayload['txs'] / 1000) + ($addressPayload['txs'] % 1000 === 0 ? 0 : 1);
                $lastAddressPayload = $this->utxo->getAddress($addressPayload['address'], $lastPage);
                $lastAt = Carbon::createFromTimestamp($this->utxo->getTx($lastAddressPayload['txids'][count($lastAddressPayload['txids']) - 1])['blockTime']);
            }
            else {
                $lastAt = Carbon::createFromTimestamp($this->utxo->getTx($addressPayload['txids'][$addressPayload['txs'] - 1])['blockTime']);
            }
        }
        return [$lastAt, $firstAt];
    }
}
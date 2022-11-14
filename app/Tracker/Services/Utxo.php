<?php

namespace App\Tracker\Services;

use App\Support\Services\Service;

/**
 * @see https://github.com/trezor/blockbook/blob/master/docs/api.md#blockbook-api
 * @see https://blockbook.elint.services/
 */
class Utxo extends Service
{
    protected string $baseUrl = 'https://blockbook.elint.services/api/v2';

    public function getStatus(): bool|array
    {
        return $this->get('')->response();
    }

    public function getBlock(int|string $block): bool|array
    {
        return $this->get("block/$block")->response();
    }

    public function getAddress(string $address): bool|array
    {
        return $this->get("address/$address")->response();
    }

    public function getTx(string $txId): bool|array
    {
        return $this->get("tx/$txId")->response();
    }
}
<?php

namespace App\Tracker\Models;

use App\Support\Models\Model;

/**
 * @property string $address
 * @property string $network
 * @property string $balance
 */
class Wallet extends Model
{
    public const NETWORK_UTXO = 'utxo';
    public const NETWORK_NEVM = 'nevm';

    protected $table = 'wallets';

    protected $fillable = [
        'address',
        'network',
        'balance',
        'created_at',
        'updated_at',
    ];
}
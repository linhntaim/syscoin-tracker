<?php

namespace App\Tracker\Models;

use App\Support\Models\ModelProvider;

/**
 * @method Wallet createWithAttributes(array $attributes = [])
 * @method Wallet firstOrCreateWithAttributes(array $attributes = [], array $values = [])
 * @method Wallet updateOrCreateWithAttributes(array $attributes, array $values = [])
 * @method Wallet updateWithAttributes(array $attributes = [])
 */
class WalletProvider extends ModelProvider
{
    public string $modelClass = Wallet::class;
}
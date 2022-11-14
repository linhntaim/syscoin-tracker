<?php

namespace App\Tracker\Console\Commands\Addresses\FromUtxo;

use App\Support\Console\Commands\Command;
use App\Support\Models\QueryValues\ComparingValue;
use App\Tracker\Models\Wallet;
use App\Tracker\Models\WalletProvider;
use App\Tracker\Services\Utxo;
use Illuminate\Database\Eloquent\Collection;

class UpdateCommand extends Command
{
    use ParseTxTimes;

    public $signature = '{--start=}';

    protected Utxo $utxo;

    protected WalletProvider $walletProvider;

    protected function handleBefore(): void
    {
        $this->utxo = new utxo;
        $this->walletProvider = new WalletProvider();

        parent::handleBefore();
    }

    protected function start(): int
    {
        return is_null($start = $this->option('start')) ? 1 : (int)$start;
    }

    protected function handling(): int
    {
        $status = $this->utxo->getStatus();
        $this->walletProvider->sort('id')->chunk(function (Collection $wallets, int $index) use ($status) {
            $this->warn(sprintf('Processing chunk %d (%d items) ...', $index, $wallets->count()));
            foreach ($wallets as $wallet) {
                $this->line(sprintf('<info>Wallet:</info> %s', $wallet->address));
                $wallet = $this->updateWallet($wallet, $status);
                $this->line(sprintf('<comment> - Balance:</comment> %s', $wallet->balance));
            }
            $this->info('Processed.');
        }, [
            'network' => Wallet::NETWORK_UTXO,
            'id' => new ComparingValue($this->start(), '>='),
        ]);
        return $this->exitSuccess();
    }

    protected function updateWallet(Wallet $wallet, array $status): Wallet
    {
        $addressPayload = $this->utxo->getAddress($wallet->address);

        [$createdAt, $updatedAt] = $this->parseTxTimes($addressPayload);
        return $this->walletProvider
            ->withModel($wallet)
            ->updateWithAttributes([
                'balance' => bcdiv($addressPayload['balance'], bcpow(10, $status['blockbook']['decimals'])),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
    }
}
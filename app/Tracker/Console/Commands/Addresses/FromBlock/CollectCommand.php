<?php

namespace App\Tracker\Console\Commands\Addresses\FromBlock;

use App\Support\Console\Commands\Command;
use App\Tracker\Models\Wallet;
use App\Tracker\Models\WalletProvider;
use App\Tracker\Services\Utxo;

class CollectCommand extends Command
{
    use AccessLatestTrackedBlock;

    public $signature = '{--fresh}';

    protected Utxo $utxo;

    protected WalletProvider $walletProvider;

    protected function handleBefore(): void
    {
        $this->utxo = new utxo;
        $this->walletProvider = new WalletProvider();

        parent::handleBefore();
    }

    protected function handling(): int
    {
        $status = $this->utxo->getStatus();
        $block = $this->option('fresh') ? 1 : $this->lastTrackedBlock() + 1;
        $blocks = $status['backend']['blocks'] ?? -1;
        $this->warn(sprintf('Tracking from block %d...', $block));
        for (; $block <= $blocks; ++$block) {
            $this->info(sprintf('Block %d tracking...', $block));
            $this->handleBlock($block, $status);
            $this->info(sprintf('Block %d tracked.', $block));
            $this->rememberLastTrackedBlock($block);
        }
        $this->warn(sprintf('All %d blocks tracked.', $blocks));
        return $this->exitSuccess();
    }

    protected function handleBlock(int $block, array $status): void
    {
        foreach ($this->onlyNewAddresses($this->extractAddresses($this->utxo->getBlock($block))) as $address) {
            $this->handleAddress($address, $status);
        }
    }

    /**
     * @param array $blockPayload
     * @return string[]
     */
    protected function extractAddresses(array $blockPayload): array
    {
        $addresses = [];
        foreach ($blockPayload['txs'] as $transactionPayload) {
            foreach ([...$transactionPayload['vin'], ...$transactionPayload['vout']] as $item) {
                if (($item['isAddress'] ?? false) === true) {
                    array_push($addresses, ...$item['addresses']);
                }
            }
        }
        return $addresses;
    }

    protected function onlyNewAddresses(array $addresses): array
    {
        return count($addresses) > 0
        && ($trackedAddresses = $this->walletProvider->all([
            'address' => $addresses,
            'network' => Wallet::NETWORK_UTXO,
        ])->pluck('address'))->count() > 0 ? array_diff($addresses, $trackedAddresses->all()) : $addresses;
    }

    protected function handleAddress(string $address, array $status): void
    {
        $this->outWallet($this->createWallet($this->utxo->getAddress($address), $status));
    }

    protected function createWallet(array $addressPayload, array $status): Wallet
    {
        return $this->walletProvider->createWithAttributes([
            'address' => $addressPayload['address'],
            'network' => Wallet::NETWORK_UTXO,
            'balance' => bcdiv($addressPayload['balance'], bcpow(10, $status['blockbook']['decimals'])),
        ]);
    }

    protected function outWallet(Wallet $wallet): void
    {
        $this->line(sprintf('<info>Wallet</info>: %s (%s)', $wallet->address, strtoupper($wallet->network)));
        $this->line(sprintf('<comment>- Balance</comment>: %s', $wallet->balance));
    }
}
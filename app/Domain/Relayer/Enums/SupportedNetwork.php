<?php

declare(strict_types=1);

namespace App\Domain\Relayer\Enums;

/**
 * Supported blockchain networks for gas relaying.
 */
enum SupportedNetwork: string
{
    case POLYGON = 'polygon';
    case ARBITRUM = 'arbitrum';
    case OPTIMISM = 'optimism';
    case BASE = 'base';
    case ETHEREUM = 'ethereum';

    public function getChainId(): int
    {
        return match ($this) {
            self::POLYGON => 137,
            self::ARBITRUM => 42161,
            self::OPTIMISM => 10,
            self::BASE => 8453,
            self::ETHEREUM => 1,
        };
    }

    public function getNativeCurrency(): string
    {
        return match ($this) {
            self::POLYGON => 'MATIC',
            self::ARBITRUM, self::OPTIMISM, self::BASE, self::ETHEREUM => 'ETH',
        };
    }

    public function getAverageGasCostUsd(): float
    {
        return match ($this) {
            self::POLYGON => 0.02,
            self::ARBITRUM => 0.15,
            self::OPTIMISM => 0.10,
            self::BASE => 0.05,
            self::ETHEREUM => 5.00,
        };
    }

    public function getRpcUrl(): string
    {
        return match ($this) {
            self::POLYGON => config('relayer.networks.polygon.rpc_url', ''),
            self::ARBITRUM => config('relayer.networks.arbitrum.rpc_url', ''),
            self::OPTIMISM => config('relayer.networks.optimism.rpc_url', ''),
            self::BASE => config('relayer.networks.base.rpc_url', ''),
            self::ETHEREUM => config('relayer.networks.ethereum.rpc_url', ''),
        };
    }
}

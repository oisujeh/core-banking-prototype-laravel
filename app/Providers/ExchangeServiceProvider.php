<?php

namespace App\Providers;

use App\Domain\Exchange\Contracts\ArbitrageServiceInterface;
use App\Domain\Exchange\Contracts\ExchangeServiceInterface;
use App\Domain\Exchange\Contracts\ExternalExchangeServiceInterface;
use App\Domain\Exchange\Contracts\ExternalLiquidityServiceInterface;
use App\Domain\Exchange\Contracts\FeeCalculatorInterface;
use App\Domain\Exchange\Contracts\LiquidityPoolServiceInterface;
use App\Domain\Exchange\Contracts\PriceAggregatorInterface;
use App\Domain\Exchange\Projectors\OrderBookProjector;
use App\Domain\Exchange\Projectors\OrderProjector;
use App\Domain\Exchange\Repositories\ExchangeEventRepository;
use App\Domain\Exchange\Services\ArbitrageService;
use App\Domain\Exchange\Services\ExchangeRateProviderRegistry;
use App\Domain\Exchange\Services\ExchangeService;
use App\Domain\Exchange\Services\ExternalExchangeService;
use App\Domain\Exchange\Services\ExternalLiquidityService;
use App\Domain\Exchange\Services\FeeCalculator;
use App\Domain\Exchange\Services\LiquidityPoolService;
use App\Domain\Exchange\Services\OrderService;
use App\Domain\Exchange\Services\PriceAggregator;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class ExchangeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind interfaces to implementations
        $this->app->singleton(ExchangeServiceInterface::class, ExchangeService::class);
        $this->app->singleton(FeeCalculatorInterface::class, FeeCalculator::class);
        $this->app->singleton(ExternalLiquidityServiceInterface::class, ExternalLiquidityService::class);
        $this->app->singleton(LiquidityPoolServiceInterface::class, LiquidityPoolService::class);
        $this->app->singleton(ExternalExchangeServiceInterface::class, ExternalExchangeService::class);
        $this->app->singleton(ArbitrageServiceInterface::class, ArbitrageService::class);
        $this->app->singleton(PriceAggregatorInterface::class, PriceAggregator::class);
        
        // Register concrete services (for backward compatibility)
        $this->app->singleton(ExchangeService::class);
        $this->app->singleton(FeeCalculator::class);
        $this->app->singleton(ExchangeRateProviderRegistry::class);
        $this->app->singleton(ExternalLiquidityService::class);
        $this->app->singleton(LiquidityPoolService::class);
        $this->app->singleton(OrderService::class);
        
        // Register exchange event repository
        $this->app->bind('exchange.event-repository', ExchangeEventRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register projectors
        Projectionist::addProjectors([
            OrderProjector::class,
            OrderBookProjector::class,
        ]);
    }
}
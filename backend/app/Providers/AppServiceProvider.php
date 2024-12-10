<?php

namespace App\Providers;

use App\Services\Orders\EasyPayPaymentService;
use App\Services\Orders\PaymentServiceInterface;
use App\Services\Orders\PriceCalculatorInterface;
use App\Services\Orders\PriceCalculatorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, EasyPayPaymentService::class);
        $this->app->bind(PriceCalculatorInterface::class, PriceCalculatorService::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}

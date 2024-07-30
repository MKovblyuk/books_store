<?php

namespace App\Providers;

use App\Http\Controllers\Api\V1\Books\BookController;
use App\Services\Books\BookStorageServiceInterface;
use App\Services\Books\ElectronicBookStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}

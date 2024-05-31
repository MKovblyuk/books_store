<?php

namespace App\Providers;

use App\Interfaces\Repositories\BookRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }
}

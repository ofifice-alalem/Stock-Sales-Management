<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Repositories\InvoiceRepository;
use App\Repositories\Interfaces\StoreDebtRepositoryInterface;
use App\Repositories\StoreDebtRepository;
use App\Repositories\Interfaces\MarketerRepositoryInterface;
use App\Repositories\MarketerRepository;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use App\Repositories\StoreRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(StoreDebtRepositoryInterface::class, StoreDebtRepository::class);
        $this->app->bind(MarketerRepositoryInterface::class, MarketerRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
    }
}
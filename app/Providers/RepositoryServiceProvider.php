<?php

namespace App\Providers;

use App\Interfaces\{
    SaleRepositoryInterface,
    SellerRepositoryInterface,
};
use App\Repositories\{
    SaleRepository,
    SellerRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SellerRepositoryInterface::class,
            SellerRepository::class,
        );

        $this->app->bind(
            SaleRepositoryInterface::class,
            SaleRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
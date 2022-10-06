<?php

namespace App\Providers;

use App\Interfaces\BarcodeGeneratorServiceInterface;
use App\Services\Ean13GeneratorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BarcodeGeneratorServiceInterface::class, Ean13GeneratorService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

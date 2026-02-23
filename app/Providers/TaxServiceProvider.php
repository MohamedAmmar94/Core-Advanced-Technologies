<?php
namespace App\Providers;

use App\Services\Taxes\MunicipalFeeTax;
use App\Services\Taxes\TaxService;
use App\Services\Taxes\VatTax;
use Illuminate\Support\ServiceProvider;

class TaxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TaxService::class, function ($app) {
            return new TaxService([
                $app->make(VatTax::class),
                $app->make(MunicipalFeeTax::class),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

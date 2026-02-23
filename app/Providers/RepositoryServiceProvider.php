<?php
namespace App\Providers;

use App\Repositories\ContractRepositoryInterface;
use App\Repositories\Eloquent\ContractRepository;
use App\Repositories\Eloquent\InvoiceRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;

class HomeController extends Controller
{
    public function test()
    {
        $invoice   = Invoice::find(1);
        $payment   = Payment::find(1);
        $contract  = $invoice->contract;
        $tenant    = $contract->tenant;
        $yearMonth = date('Ym');
        $sequence  = $invoice->repository->nextSequenceForTenant($tenant->id, $yearMonth);
        return 'test';
    }
}

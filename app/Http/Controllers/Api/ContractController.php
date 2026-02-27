<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ContractSummaryResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;

class ContractController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {}
    public function summary(Contract $contract)
    {
        $this->authorize('view', [Invoice::class, $contract]);
        $data = Contract::
            where('id', $contract->id)
            ->withCount('invoices')
            ->withSum('invoices as total_invoiced', 'total')
            ->withCount('payments')
            ->withSum('payments as total_paid', 'amount')
            ->withMax('invoices as latest_invoice_date', 'created_at')
            ->firstOrFail();

        return new ContractSummaryResource($data);

    }
}

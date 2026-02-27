<?php
namespace App\Http\Controllers\Api;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\InvoiceFilterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\Api\InvoiceResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {}
    public function store(StoreInvoiceRequest $request, Contract $contract)
    {

        $this->authorize('create', [Invoice::class, $contract]);
        $dto    = CreateInvoiceDTO::fromRequest($request, $contract);
        $result = $this->invoiceService->createInvoice($dto);
        if ($result['error']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], $result['status_code']);
        }
        $invoice = $result['data'];
        return new InvoiceResource($row)->response()->setStatusCode(201);
    }
    public function list(Contract $contract, Request $request)
    {

        $this->authorize('viewAny', [Invoice::class, $contract]);

        $filters = new InvoiceFilterDTO(
            status: $request->query('status'),
            from: $request->query('from'),
            to: $request->query('to'),
            min_total: $request->query('min_total'),
            max_total: $request->query('max_total'),
            per_page: $request->query('per_page') ?? 9,
        );
        $invoices = $this->invoiceService->getByContractId(
            $contract->id,
            $filters
        );

        return InvoiceResource::collection($invoices);
    }
    public function get_by_id(Invoice $invoice)
    {
        // dd($invoice);
        $this->authorize('view', [Invoice::class, $invoice->contract]);
        // $invoice_row = $this->invoiceService->findById($invoice);
        $invoice->load('payments');
        return new InvoiceResource($invoice);

    }

}

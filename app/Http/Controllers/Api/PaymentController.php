<?php
namespace App\Http\Controllers\Api;

use App\DTOs\RecordPaymentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecordPaymentRequest;
use App\Http\Resources\Api\PaymentResource;
use App\Models\Invoice;
use App\Services\InvoiceService;

class PaymentController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {}
    public function record_payment(RecordPaymentRequest $request,
        Invoice $invoice) {

        $this->authorize('recordPayment', [Invoice::class, $invoice]);
        $dto = RecordPaymentDTO::fromRequest($request, $invoice);
        // dd($dto, $invoice->total_paid);
        $payment_res = $this->invoiceService->recordPayment($dto);
        if ($payment_res['error']) {
            return response()->json([
                'success' => false,
                'message' => $payment_res['message'],
            ], $payment_res['status_code']);
        }
        $payment = $payment_res['data'];
        return PaymentResource::make($payment)->response()->setStatusCode(201);
    }
}

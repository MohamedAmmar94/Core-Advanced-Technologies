<?php
namespace App\Services;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\InvoiceFilterDTO;
use App\DTOs\RecordPaymentDTO;
use App\Repositories\ContractRepositoryInterface;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\Taxes\TaxService;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService,
    ) {}

    public function createInvoice(CreateInvoiceDTO $dto)
    {
        DB::beginTransaction();
        try {
            $contract = $this->contractRepo->findById($dto->contract_id);
            // dd($contract);
            //=============>first condition
            if (! $contract || $contract->status !== 'active') {
                return ['error' => true, 'message' => 'Invoice cannot be created for non-active contract.', 'status_code' => 422];
            }
            //============>second condition
            $subtotal = $contract->rent_amount;

            $taxAmount = $this->taxService->calculateTotal($subtotal);
            // dd($subtotal, $taxAmount);

            $total = $subtotal + $taxAmount;

            $invoiceNumber = $this->generateInvoiceNumber(
                $dto->tenant_id
            );
            // dd($invoiceNumber);
            $row = $this->invoiceRepo->create([
                'contract_id'    => $contract->id,
                'invoice_number' => $invoiceNumber,
                'subtotal'       => $subtotal,
                'tax_amount'     => $taxAmount,
                'total'          => $total,
                'status'         => 'pending',
                'due_date'       => $dto->due_date,
            ]);
            DB::commit();
            return ['error' => false, 'message' => 'Invoice created successfully.', 'data' => $row];

        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => true, 'message' => $e->getMessage(), 'status_code' => 500];
        }
    }
    public function getByContractId(int $contractId, InvoiceFilterDTO $dto)
    {
        return $this->invoiceRepo->getByContractId($contractId, $dto);
    }
    public function recordPayment(RecordPaymentDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $invoice = $this->invoiceRepo->findById($dto->invoice_id);

            if (! $invoice) {

                return ['error' => true, 'message' => 'Invoice not found.', 'status_code' => 422];

            }

            // $totalPaid        = $this->paymentRepo->sumByInvoice($invoice->id);
            $totalPaid        = $invoice->total_paid;
            $remainingBalance = $invoice->total - $totalPaid;
            if ($dto->amount > $remainingBalance) {
                return ['error' => true, 'message' => 'payment exceeds remaining balance.', 'status_code' => 422];

            }
            // dd($dto->amount, $remainingBalance);

            $payment = $this->paymentRepo->create([
                'invoice_id'       => $invoice->id,
                'amount'           => $dto->amount,
                'payment_method'   => $dto->payment_method,
                'reference_number' => $dto->reference_number,
                'paid_at'          => now(),
            ]);

            $newTotalPaid = $totalPaid + $dto->amount;

            if ($newTotalPaid == $invoice->total) {
                $this->invoiceRepo->updateStatus($invoice->id, 'paid');
            } elseif ($newTotalPaid > 0) {
                $this->invoiceRepo->updateStatus($invoice->id, 'partially_paid');
            }
            return ['error' => false, 'message' => 'payment created successfully.', 'status_code' => 201, 'data' => $payment];

            // return $payment;
        });
    }

    public function getContractSummary(int $contractId): array
    {
        $totalInvoiced = $this->invoiceRepo->sumTotalByContract($contractId);

        $totalPaid = $this->paymentRepo->sumPaidByContract($contractId);

        return [
            'total_invoiced' => $totalInvoiced,
            'total_paid'     => $totalPaid,
            'outstanding'    => $totalInvoiced - $totalPaid,
        ];
    }

    public function generateInvoiceNumber(int $tenantId): string
    {
        $yearMonth = now()->format('Ym');

        $sequence = $this->invoiceRepo->nextSequenceForTenant($tenantId, $yearMonth);

        return sprintf(
            'INV-%03d-%s-%04d',
            $tenantId,
            $yearMonth,
            $sequence
        );
    }
}

<?php
namespace App\Repositories\Eloquent;

use App\DTOs\InvoiceFilterDTO;
use App\Models\Invoice;
use App\Repositories\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function getByContractId(int $contractId, InvoiceFilterDTO $dto)
    {
        // dd($dto->status);
        $query = Invoice::where('contract_id', $contractId)
            ->when(! empty($dto->status), function ($query) use ($dto) {
                $query->where('status', $dto->status);
            })
            ->when(! empty($dto->from), function ($query) use ($dto) {
                $query->whereDate('due_date', '>=', $dto->from);
            })
            ->when(! empty($dto->to), function ($query) use ($dto) {
                $query->whereDate('due_date', '<=', $dto->to);
            })
            ->when(! empty($dto->min_total), function ($query) use ($dto) {
                $query->where('total', '>=', $dto->min_total);
            })
            ->when(! empty($dto->max_total), function ($query) use ($dto) {
                $query->where('total', '<=', $dto->max_total);
            })->paginate($dto->per_page);

        return $query;
    }
    public function nextSequenceForTenant(int $tenantId, string $yearMonth): int
    {
        $prefix = sprintf(
            'INV-%03d-%s-',
            $tenantId,
            $yearMonth
        );
        $lastInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('invoice_number')
            ->lockForUpdate()
            ->first();
        // dd($prefix, $lastInvoice);
        if (! $lastInvoice) {
            return 1;
        }

        $lastSequence = (int) substr($lastInvoice->invoice_number, -4);

        return $lastSequence + 1;
    }
    public function updateStatus(int $invoice_id, string $status)
    {
        return Invoice::where('id', $invoice_id)->update(['status' => $status]);

    }
}

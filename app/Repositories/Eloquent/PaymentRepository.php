<?php
namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function findById(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function getByInvoiceId(int $invoiceId): array
    {
        return Payment::where('invoice_id', $invoiceId)->get()->all();
    }
}

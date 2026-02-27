<?php
namespace App\Repositories;

use App\Models\Payment;

interface PaymentRepositoryInterface
{
    public function findById(int $id): ?Payment;

    public function create(array $data): Payment;

    public function getByInvoiceId(int $invoiceId): array;
    public function sumByInvoice(int $invoiceId): float;

}

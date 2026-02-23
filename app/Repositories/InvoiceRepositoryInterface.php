<?php
namespace App\Repositories;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice;

    public function create(array $data): Invoice;

    public function getByContractId(int $contractId): array;
}

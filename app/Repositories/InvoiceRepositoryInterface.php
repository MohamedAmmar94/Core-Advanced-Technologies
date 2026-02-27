<?php
namespace App\Repositories;

use App\DTOs\InvoiceFilterDTO;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function findById(int $id): ?Invoice;

    public function create(array $data): Invoice;

    public function getByContractId(int $contractId, InvoiceFilterDTO $dto);

    public function nextSequenceForTenant(int $tenantId, string $yearMonth): int;

    public function updateStatus(int $invoice_id, string $status);
}

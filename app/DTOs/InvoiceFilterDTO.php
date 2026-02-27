<?php
namespace App\DTOs;

use App\Http\Requests\StoreInvoiceRequest;

final class InvoiceFilterDTO
{
    public function __construct(
        public readonly ?string $status,
        public readonly ?string $from,
        public readonly ?string $to,
        public readonly ?float $min_total,
        public readonly ?float $max_total,
        public readonly ?float $per_page,
    ) {}

}

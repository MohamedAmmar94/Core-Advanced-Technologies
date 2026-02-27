<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->total_invoiced);
        // $total_invoiced = $this->invoices()->count();
        return [
            'contract_id'         => $this->id,
            'total_invoiced'      => $this->total_invoiced,
            'total_paid'          => $this->total_paid,
            'outstanding_balance' => (float) $this->total_invoiced - (float) $this->total_paid,
            'invoices_count'      => $this->invoices_count,
            'latest_invoice_date' => $this->latest_invoice_date,
        ];
    }
}

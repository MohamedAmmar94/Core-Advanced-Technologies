<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'invoice_number'    => $this->invoice_number,
            'subtotal'          => $this->subtotal,
            'tax_amount'        => $this->tax_amount,
            'total'             => $this->total,
            'due_date'          => $this->due_date,
            'paid_at'           => $this->paid_at,
            'remaining_balance' => ($this->total - $this->total_paid),

            'status'            => $this->status,
            'contract'          => new ContractResource($this->whenLoaded('contract')),
            'payments'          => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}

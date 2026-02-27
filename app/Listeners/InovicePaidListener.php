<?php
namespace App\Listeners;

use App\Events\InovicePaid;
use Illuminate\Support\Facades\Log;

class InovicePaidListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InovicePaid $event): void
    {
        // dd($event->invoice);
        Log::info('Invoice paid listener ', [
            'invoice_id' => $event?->invoice?->id ?? '',
            'amount'     => $event?->invoice?->total,
        ]);
    }
}

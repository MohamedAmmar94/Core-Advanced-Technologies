<?php
namespace App\Console\Commands;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $affected = Invoice::whereDate('due_date', '<', $today)
            ->where('status', 'pending')
            ->update(['status' => 'overdue']);

        $this->info("✅ {$affected} invoices marked as overdue.");

    }
}

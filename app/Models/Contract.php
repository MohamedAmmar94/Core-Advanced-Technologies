<?php
namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'rent_amount' => 'decimal:2',
    ];
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class, // final model
            Invoice::class, // intermediate model
            'contract_id',  // Foreign key on invoices table
            'invoice_id',   // Foreign key on payments table
            'id',           // Local key on contracts
            'id'            // Local key on invoices
        );
    }
}

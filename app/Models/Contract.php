<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tenant_id',
        'unit_name',
        'customer_name',
        'rent_amount',
        'start_date',
        'end_date',
        'status',
    ];
    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'rent_amount' => 'decimal:2',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_id',
        'invoice_number',
        'total',
        'payment_status',
        'device_id',
        'replaced_items',
        'checklist_id',
        'repair_cost',
    ];

    protected $casts = [
        
        'total' => 'decimal:2',
        'payment_status' => 'string',
        'replaced_items' => 'json',
        'repair_cost' => 'decimal:2',
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
    
    public function checklist(): HasMany
    {
        return $this->hasMany(Checklist::class);
    }
}

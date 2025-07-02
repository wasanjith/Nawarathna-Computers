<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'reference',
        'received_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'method' => 'string',
        'received_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}

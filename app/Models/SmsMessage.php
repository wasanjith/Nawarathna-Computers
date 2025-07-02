<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'phone',
        'body',
        'send_at',
        'provider_message_id',
        'status',
        'error',
    ];

    protected $casts = [
        'send_at' => 'datetime',
        'status' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

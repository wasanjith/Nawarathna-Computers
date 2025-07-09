<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCall extends Model
{
    protected $fillable = [
        'customer_id',
        'called_at',
        'status',
        'notes',
        'device_id',
    ];

    protected $casts = [
        'called_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_seconds) return 'N/A';
        
        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}

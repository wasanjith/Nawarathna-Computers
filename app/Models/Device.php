<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'device_type',
        'brand',
        'model',
        'serial_number',
        'slug',
        'intheshowroom'
    ];

    protected $casts = [
        'status' => 'string'
       
    ];

    public function getNameAttribute(): string
    {
        return "{$this->brand} {$this->model}";
    }

    protected static function booted()
    {
        static::created(function ($device) {
            $latestCall = CustomerCall::where('customer_id', $device->customer_id)
                ->whereNull('device_id')
                ->latest('called_at')
                ->first();

            if ($latestCall) {
                $latestCall->update(['device_id' => $device->id]);
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function customerCalls(): HasMany
    {
        return $this->hasMany(CustomerCall::class);
    }
}

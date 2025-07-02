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
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
}

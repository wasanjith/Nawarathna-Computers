<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repair extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'device_id',
        'customer_id',
        'problem_description',
        'status',
        'estimated_cost',
        'estimated_completion_at',
        'completed_at',
        'warranty_months',
        'slug',
        'techniction_id',// Assuming slug is a foreign key to the device
    ];

    protected $casts = [
        'status' => 'string',
        'estimated_cost' => 'decimal:2',
        'estimated_completion_at' => 'datetime',
        'completed_at' => 'datetime',
        'warranty_months' => 'integer',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function checkList(): HasOne
    {
        return $this->hasOne(CheckList::class);
    }
    
    public function technictions(): HasMany
    {
        return $this->hasMany(Techniction::class);
    }

    protected static function booted()
    {
        static::creating(function ($repair) {
            if (empty($repair->slug) && !empty($repair->device_id)) {
                $device = Device::find($repair->device_id);
                if ($device) {
                    $repair->slug = $device->slug;
                }
            }
        });
    }

    // relation to Techniction
    public function techniction(): HasMany
    {
        return $this->hasMany(Techniction::class);
    }
    
}


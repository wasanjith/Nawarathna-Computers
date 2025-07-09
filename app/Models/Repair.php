<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    ];

    protected $casts = [
        'status' => 'string',
        'estimated_cost' => 'decimal:2',
        'estimated_completion_at' => 'datetime',
        'completed_at' => 'datetime',
        'warranty_months' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($repair) {
            $repair->checkList()->create([
                'repair_id' => $repair->id,
            ]);
        });
    }

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
}

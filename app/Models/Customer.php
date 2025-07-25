<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CustomerCall;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'city',
        'whatsAppEnable',
        'customer_state',
    ];

    protected $casts = [
        'whatsAppEnable' => 'string',
    ];

    protected static function booted()
    {
        static::created(function ($customer) {
            CustomerCall::create([
                'customer_id' => $customer->id,
                'device_id' => null,
                'called_at' => now(),
                'status' => 'no_answer',
                'notes' => 'Initial call record created automatically',
            ]);
        });
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function smsMessages(): HasMany
    {
        return $this->hasMany(SmsMessage::class);
    }

    // Add this new relationship
    public function calls(): HasMany
    {
        return $this->hasMany(CustomerCall::class);
    }

    public function getLastCallAttribute()
    {
        return $this->calls()->latest('called_at')->first();
    }

    /**
     * Get all of the customerCalls for the Customer.
     */
    public function customerCalls(): HasMany
    {
        return $this->hasMany(CustomerCall::class);
    }
}

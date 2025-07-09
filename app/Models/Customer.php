<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'city',
        'whatsAppEnable',
    ];

    protected $casts = [
        'whatsAppEnable' => 'string',
    ];

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
}

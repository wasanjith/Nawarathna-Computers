<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Techniction extends Model
{
    protected $table = 'technictions';

    protected $fillable = [
        'name',
        'phone',
        'repair_id',
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }
}

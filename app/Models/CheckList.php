<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckList extends Model
{
    protected $fillable = [
        'repair_id',
        'processor',
        'motherboard',
        'ram',
        'hard_disk_1',
        'hard_disk_2',
        'optical_drive',
        'network',
        'wifi',
        'camera',
        'hinges',
        'laptopSPK',
        'mic',
        'touchPad',
        'keyboard',
        'frontUSB',
        'rearUSB',
        'frontSound',
        'rearSound',
        'vgaPort',
        'hdmiPort',
        'hardHealth',
        'stressTest',
        'benchMark',
        'powerCable_1',
        'powerCable_2',
        'vgaCable',
        'dviCable',
        'backpanelnuts',
        'nutQty',
        // Add the note fields below
        'benchMark_note',
        'stressTest_note',
        'hardHealth_note',
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }

    //belongs to invoice
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // Helper to get replaced items as array
    public function getReplacedItems(): array
    {
        $fields = [
            'processor','motherboard','ram','hard_disk_1','hard_disk_2','optical_drive','network','wifi','camera',
            'hinges','laptopSPK','lapCamera','mic','touchPad','keyboard',
            'frontUSB','rearUSB','frontSound','rearSound','vgaPort','hdmiPort',
            'hardHealth','stressTest','benchMark','powerCable_1','powerCable_2','vgaCable','dviCable'
        ];
        $replaced = [];
        foreach ($fields as $field) {
            if ($this->$field === 'replaced') {
                $replaced[] = $field;
            }
        }
        return $replaced;
    }
}

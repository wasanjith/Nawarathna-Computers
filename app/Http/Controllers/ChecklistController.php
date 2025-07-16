<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChecklistController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $repair_id = $request->query('repair_id');
        $checklist = Checklist::where('repair_id', $repair_id)->first();

        if ($checklist) {
            return redirect()->route('checklist.edit', $checklist->id);
        }

        return redirect('/admin/repair/repairs')->with('error', 'Checklist not found and creation from this endpoint is not supported.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and extract data
        $data = $request->all();

        // 1. Create or update Customer
        $customer = \App\Models\Customer::firstOrCreate(
            [
                'phone' => $data['customer_phone'],
            ],
            [
                'name' => $data['customer_name'],
                'city' => $data['customer_city'],
                'whatsAppEnable' => $request->has('whatsapp_enabled') ? '1' : '0',
            ]
        );

        // 2. Create Device
        $device = \App\Models\Device::firstOrCreate(
            [
                'slug' => $data['slug'] ?? null,
                'customer_id' => $customer->id,
            ],
            [
                'device_type' => $data['device_type'],
                'brand' => $data['device_brand'],
                'model' => $data['device_model'],
            ]
        );

        // 3. Create Repair
        $repair = \App\Models\Repair::create([
            'device_id' => $device->id,
            'customer_id' => $customer->id,
            'slug' => $data['slug'] ?? null,
            // Add more fields as needed
        ]);

        // 4. Create Checklist (store all checklist items)
        if (isset($data['checklist']) && is_array($data['checklist'])) {
            foreach ($data['checklist'] as $item) {
                \App\Models\CheckList::create([
                    'repair_id' => $repair->id,
                    'component' => $item['component'] ?? null,
                    'status' => $item['status'] ?? null,
                ]);
            }
        }

        return redirect('/')->with('success', 'Repair is saved!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        return view('checklist', compact('checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $validatedData = $this->getValidatedData($request);
        $checklist->update($validatedData);

        return redirect('/admin/repair/repairs')->with('success', 'Checklist updated successfully.');
    }

    private function getValidatedData(Request $request)
    {
        return $request->validate([
            'repair_id' => 'required|exists:repairs,id',
            'processor_brand' => 'nullable|string|max:255',
            'processor' => 'nullable|string',
            'motherboard_brand' => 'nullable|string|max:255',
            'motherboard' => 'nullable|string',
            'ram_brand' => 'nullable|string|max:255',
            'ram' => 'nullable|string',
            'hard_disk_1_brand' => 'nullable|string|max:255',
            'hard_disk_1' => 'nullable|string',
            'hard_disk_2_brand' => 'nullable|string|max:255',
            'hard_disk_2' => 'nullable|string',
            'optical_drive_brand' => 'nullable|string|max:255',
            'optical_drive' => 'nullable|string',
            'network_brand' => 'nullable|string|max:255',
            'network' => 'nullable|string',
            'wifi_brand' => 'nullable|string|max:255',
            'wifi' => 'nullable|string',
            'camera_brand' => 'nullable|string|max:255',
            'camera' => 'nullable|string',
            'hinges_brand' => 'nullable|string|max:255',
            'hinges' => 'nullable|string',
            'laptopSPK_brand' => 'nullable|string|max:255',
            'laptopSPK' => 'nullable|string',
            'mic_brand' => 'nullable|string|max:255',
            'mic' => 'nullable|string',
            'touchPad_brand' => 'nullable|string|max:255',
            'touchPad' => 'nullable|string',
            'keyboard_brand' => 'nullable|string|max:255',
            'keyboard' => 'nullable|string',
            'frontUSB' => 'nullable|string',
            'rearUSB' => 'nullable|string',
            'frontSound' => 'nullable|string',
            'rearSound' => 'nullable|string',
            'vgaPort' => 'nullable|string',
            'hdmiPort' => 'nullable|string',
            'hardHealth' => 'nullable|string',
            'stressTest' => 'nullable|string',
            'benchMark' => 'nullable|string',
            'powerCable_1' => 'nullable|string',
            'powerCable_2' => 'nullable|string',
            'vgaCable' => 'nullable|string',
            'dviCable' => 'nullable|string',
            'backpanelnuts' => 'nullable|string',
            'nutQty' => 'nullable|integer|min:0',
        ]);
    }
}

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
        Log::info('Checklist store called', ['data' => $request->all()]);
        // Validate and extract data
        $data = $request->all();

        // 1. Handle Customer (existing or new)
        if (!empty($data['customer_id'])) {
            // Use existing customer
            $customer = \App\Models\Customer::find($data['customer_id']);
            if (!$customer) {
                Log::error('Selected customer not found', ['customer_id' => $data['customer_id']]);
                return redirect('/')->with('error', 'Selected customer not found.');
            }
            
            // Update customer details if provided
            $customer->update([
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'],
                'city' => $data['customer_city'],
                'whatsAppEnable' => $request->has('whatsapp_enabled') ? 'yes' : 'no',
                'customer_state' => $data['customer_state'] ?? 'Mr',
            ]);
            Log::info('Customer updated', ['customer' => $customer]);
        } else {
            // Create new customer
            $customer = \App\Models\Customer::firstOrCreate(
                [
                    'phone' => $data['customer_phone'],
                ],
                [
                    'name' => $data['customer_name'],
                    'city' => $data['customer_city'],
                    'whatsAppEnable' => $request->has('whatsapp_enabled') ? 'yes' : 'no',
                    'customer_state' => $data['customer_state'] ?? 'Mr',
                ]
            );
            Log::info('Customer created or found', ['customer' => $customer]);
        }

        // 2. Handle Device (existing or new)
        $device = null;
        if (!empty($data['device_id'])) {
            $device = \App\Models\Device::find($data['device_id']);
        }
        if ($device) {
            // Update device details if provided
            $device->update([
                'device_type' => $data['device_type'],
                'brand' => $data['device_brand'],
                'model' => $data['device_model'],
                'slug' => $data['slug'] ?? $device->slug,
            ]);
            Log::info('Device updated', ['device' => $device]);
        } else {
            // Create new device
            $device = \App\Models\Device::create([
                'device_type' => $data['device_type'],
                'brand' => $data['device_brand'],
                'model' => $data['device_model'],
                'slug' => $data['slug'] ?? null,
                'customer_id' => $customer->id,
            ]);
            Log::info('Device created', ['device' => $device]);
        }

        // 3. Create Repair
        $repair = \App\Models\Repair::create([
            'device_id' => $device->id,
            'customer_id' => $device->customer_id, // Use device's customer_id to ensure consistency
            'slug' => $data['slug'] ?? null,
            'problem_description' => $data['problem_description'] ?? null,
            'techniction_id' => $data['technician_id'] ?? null,
            // Add more fields as needed
        ]);
        Log::info('Repair created', ['repair' => $repair]);

        // Update the repair ID field with the actual created repair ID
        $data['repair_id'] = $repair->id;

        // 4. Create Checklist (store all checklist items in one row)
        $fieldMap = [
            'Processor' => 'processor',
            'Motherboard' => 'motherboard',
            'RAM' => 'ram',
            'Hard Disk 1' => 'hard_disk_1',
            'Hard Disk 2' => 'hard_disk_2',
            'Optical Drive' => 'optical_drive',
            'Network' => 'network',
            'WiFi Module' => 'wifi',
            'Camera' => 'camera',
            'Front USB' => 'frontUSB',
            'Rear USB' => 'rearUSB',
            'Front Sound' => 'frontSound',
            'Rear Sound' => 'rearSound',
            'VGA Port' => 'vgaPort',
            'HDMI Port' => 'hdmiPort',
            'Hard Health' => 'hardHealth',
            'Stress Test' => 'stressTest',
            'Benchmark' => 'benchMark',
            'Power Cable 1' => 'powerCable_1',
            'Power Cable 2' => 'powerCable_2',
            'VGA Cable' => 'vgaCable',
            'DVI Cable' => 'dviCable',
            'Hinges' => 'hinges',
            'Laptop Speakers' => 'laptopSPK',
            'Microphone' => 'mic',
            'TouchPad' => 'touchPad',
            'Keyboard' => 'keyboard',
        ];

        $checklistData = [
            'repair_id' => $repair->id,
            'nutQty' => $request->input('nutQty', 0),
            'backpanelnuts' => $request->input('backpanelnuts', 'yes'),
        ];

        // List of all checklist fields
        $fields = [
            'processor','motherboard','ram','hard_disk_1','hard_disk_2','optical_drive','network','wifi','camera','hinges','laptopSPK','mic','touchPad','keyboard',
            'frontUSB','rearUSB','frontSound','rearSound','vgaPort','hdmiPort','hardHealth','stressTest','benchMark','powerCable_1','powerCable_2','vgaCable','dviCable'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $checklistData[$field] = $request->input($field);
            }
        }
        // Add notes fields
        $checklistData['benchMark_note'] = $request->input('benchMark_note');
        $checklistData['stressTest_note'] = $request->input('stressTest_note');
        $checklistData['hardHealth_note'] = $request->input('hardHealth_note');

        $checklist = \App\Models\CheckList::create($checklistData);
        Log::info('Checklist created', ['checklist' => $checklist]);
        // Log activity
        if (auth()->check()) {
            $userName = auth()->user()->name;
            $customerName = $repair->customer ? $repair->customer->name : 'Unknown Customer';
            $deviceName = $repair->device ? $repair->device->name : 'Unknown Device';
            $description = "$userName created $customerName's $deviceName checklist";
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'subject_type' => \App\Models\CheckList::class,
                'subject_id' => $checklist->id,
                'description' => $description,
            ]);
        }

        return redirect('/')->with('success', 'Repair is saved!');
    }

    /**
     * Update the specified checklist in storage.
     */
    public function update(Request $request, $id)
    {
        $checklist = \App\Models\CheckList::findOrFail($id);

        // You may want to validate the request here
        $data = $request->all();

        // Map fields as in store method
        $fieldMap = [
            'Processor' => 'processor',
            'Motherboard' => 'motherboard',
            'RAM' => 'ram',
            'Hard Disk 1' => 'hard_disk_1',
            'Hard Disk 2' => 'hard_disk_2',
            'Optical Drive' => 'optical_drive',
            'Network' => 'network',
            'WiFi Module' => 'wifi',
            'Camera' => 'camera',
            'Front USB' => 'frontUSB',
            'Rear USB' => 'rearUSB',
            'Front Sound' => 'frontSound',
            'Rear Sound' => 'rearSound',
            'VGA Port' => 'vgaPort',
            'HDMI Port' => 'hdmiPort',
            'Hard Health' => 'hardHealth',
            'Stress Test' => 'stressTest',
            'Benchmark' => 'benchMark',
            'Power Cable 1' => 'powerCable_1',
            'Power Cable 2' => 'powerCable_2',
            'VGA Cable' => 'vgaCable',
            'DVI Cable' => 'dviCable',
            'Hinges' => 'hinges',
            'Laptop Speakers' => 'laptopSPK',
            'Microphone' => 'mic',
            'TouchPad' => 'touchPad',
            'Keyboard' => 'keyboard',
        ];

        $checklistData = [
            'nutQty' => $request->input('nutQty', 0),
            'backpanelnuts' => $request->input('backpanelnuts', 'yes'),
        ];

        // List of all checklist fields
        $fields = [
            'processor','motherboard','ram','hard_disk_1','hard_disk_2','optical_drive','network','wifi','camera','hinges','laptopSPK','mic','touchPad','keyboard',
            'frontUSB','rearUSB','frontSound','rearSound','vgaPort','hdmiPort','hardHealth','stressTest','benchMark','powerCable_1','powerCable_2','vgaCable','dviCable',
            'benchMark_note','stressTest_note','hardHealth_note',
            'benchMark_extra1','benchMark_extra2','benchMark_extra3','benchMark_extra4',
            'stressTest_extra1','stressTest_extra2','stressTest_extra3','stressTest_extra4',
            'hardHealth_extra1','hardHealth_extra2','hardHealth_extra3','hardHealth_extra4',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $checklistData[$field] = $request->input($field);
            }
        }

        $checklist->update($checklistData);
        // Log activity
        if (auth()->check()) {
            $userName = auth()->user()->name;
            $customerName = $checklist->repair && $checklist->repair->customer ? $checklist->repair->customer->name : 'Unknown Customer';
            $deviceName = $checklist->repair && $checklist->repair->device ? $checklist->repair->device->name : 'Unknown Device';
            $description = "$userName updated $customerName's $deviceName checklist";
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'subject_type' => \App\Models\CheckList::class,
                'subject_id' => $checklist->id,
                'description' => $description,
            ]);
        }

        return redirect('/admin/repair/repairs')->with('success', 'Checklist updated successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        return view('checklist', compact('checklist'));
    }

    /**
     * Search customers by name or phone
     */
    public function searchCustomers(Request $request)
    {
        $term = $request->get('term', '');
        
        if (empty($term)) {
            return response()->json([]);
        }

        $customers = \App\Models\Customer::where('name', 'like', "%{$term}%")
            ->orWhere('phone', 'like', "%{$term}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'phone', 'city', 'whatsAppEnable']);

        return response()->json($customers);
    }

    /**
     * Get customer details by ID
     */
    public function getCustomer($id)
    {
        $customer = \App\Models\Customer::find($id);
        
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    /**
     * Get devices for a specific customer
     */
    public function getCustomerDevices($customerId)
    {
        $devices = \App\Models\Device::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'device_type', 'brand', 'model', 'slug']);

        return response()->json($devices);
    }

    /**
     * Get the next available repair ID
     */
    public function getNextRepairId()
    {
        $nextId = \App\Models\Repair::max('id') + 1;
        return response()->json(['next_id' => $nextId]);
    }

    
}

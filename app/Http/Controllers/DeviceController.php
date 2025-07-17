<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function getDeviceIds(Request $request)
    {
        $term = $request->input('term');
        $devices = Device::where('serial_number', 'like', "%$term%")
            ->orWhere('id', 'like', "%$term%")
            ->select('id', 'serial_number', 'device_type', 'brand', 'model')
            ->get();
        return response()->json($devices);
    }

    public function getNextDeviceId()
    {
        $lastDevice = Device::orderBy('id', 'desc')->first();
        $nextId = $lastDevice ? $lastDevice->id + 1 : 1;
        return response()->json(['next_id' => $nextId]);
    }
} 
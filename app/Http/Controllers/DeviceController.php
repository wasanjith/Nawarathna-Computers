<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function getDeviceIds(Request $request)
    {
        $term = $request->input('term');
        $devices = Device::where('id', 'like', "%$term%")
            ->pluck('id');
        return response()->json($devices);
    }
} 
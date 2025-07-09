<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerCall;
use Illuminate\Http\Request;

class CustomerCallController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'called_at' => 'required|date',
            'status' => 'required|in:answered,no_answer,busy,switched_off',
            'notes' => 'nullable|string',
        ]);

        $customer->calls()->create($validated);

        return back()->with('success', 'Call record added successfully.');
    }
}

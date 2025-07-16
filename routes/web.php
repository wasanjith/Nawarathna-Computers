<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CustomerCallController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cheking');
});
Route::get('/admin/repairs/{repair}/order', function (App\Models\Repair $repair) {
    return view('Checklist', compact('repair'));
})->name('admin.repair.order');

Route::resource('admin/repairs', RepairController::class)->names('admin.repairs');

Route::get('/admin/repairs/{repair}/checklist', [ChecklistController::class, 'create'])->name('checklist.create');
Route::post('/admin/repairs/checklist', [ChecklistController::class, 'store'])->name('checklist.store');
Route::get('customer/{customer}/callhistory', function (Customer $customer) {
    $callHistory = $customer->customerCalls()->with('device')->orderBy('called_at', 'desc')->get();
    return view('CallHistory', compact('customer', 'callHistory'));
})->name('customer.callhistory');
Route::resource('checklist', ChecklistController::class)->except(['index', 'show', 'destroy']);

Route::post('/customers/{customer}/calls', [CustomerCallController::class, 'store'])->name('customers.calls.store');

Route::get('/checklist', function () {
    return view('cheking');
});

// Checklist save route
Route::post('/checklist/save', [App\Http\Controllers\ChecklistController::class, 'store'])->name('checklist.save');

// API endpoints for auto-suggest
Route::get('/api/repairs/ids', [RepairController::class, 'getRepairIds']);
Route::get('/api/devices/ids', [DeviceController::class, 'getDeviceIds']);
<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePrintController extends Controller
{
    public function show($invoice)
    {
        $record = Invoice::findOrFail($invoice);
        $customer = $record->repair->device->customer ?? null;
        $device = $record->repair->device ?? null;
        $checklist = $record->repair->checkList ?? null;
        $replacedItems = $record->replaced_items ?? [];
        $replacedBrands = $record->replaced_items_brand ?? [];
        $replacedPrices = $record->replaced_items_prices ?? [];

        return view('filament.resources.invoice.invoice', compact(
            'record', 'customer', 'device', 'checklist', 'replacedItems', 'replacedBrands', 'replacedPrices'
        ));
    }
} 
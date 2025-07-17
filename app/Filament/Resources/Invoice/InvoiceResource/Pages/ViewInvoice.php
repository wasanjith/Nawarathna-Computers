<?php

namespace App\Filament\Resources\Invoice\InvoiceResource\Pages;

use App\Filament\Resources\Invoice\InvoiceResource;
use Filament\Resources\Pages\Page;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Device;
use App\Models\CheckList;

class ViewInvoice extends Page
{
    protected static string $resource = InvoiceResource::class;
    protected static string $view = 'filament.resources.invoice.invoice';

    public $record;
    public $customer;
    public $device;
    public $checklist;
    public $replacedItems;
    public $replacedBrands;
    public $replacedPrices;

    public function mount($record)
    {
        $this->record = Invoice::findOrFail($record);
        $this->customer = $this->record->repair->device->customer ?? null;
        $this->device = $this->record->repair->device ?? null;
        $this->checklist = $this->record->repair->checkList ?? null;
        $this->replacedItems = $this->record->replaced_items ?? [];
        $this->replacedBrands = $this->record->replaced_items_brand ?? [];
        $this->replacedPrices = $this->record->replaced_items_prices ?? [];
    }
} 
<?php

namespace App\Filament\Resources\Invoice\InvoiceResource\Pages;

use App\Filament\Resources\Invoice\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

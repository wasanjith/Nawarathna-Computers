<?php

namespace App\Filament\Resources\Invoice\InvoiceResource\Pages;

use App\Filament\Resources\Invoice\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If replaced_items_table is present, split it into three arrays
        if (isset($data['replaced_items_table']) && is_array($data['replaced_items_table'])) {
            $items = [];
            $brands = [];
            $prices = [];
            foreach ($data['replaced_items_table'] as $row) {
                $items[] = $row['item'] ?? '';
                $brands[] = $row['brand'] ?? '';
                $prices[] = $row['price'] ?? '';
            }
            $data['replaced_items'] = $items;
            $data['replaced_items_brand'] = $brands;
            $data['replaced_items_prices'] = $prices;
        }
        return $data;
    }
}

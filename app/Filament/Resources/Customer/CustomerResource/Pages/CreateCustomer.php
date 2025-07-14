<?php

namespace App\Filament\Resources\Customer\CustomerResource\Pages;

use App\Filament\Resources\Customer\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $customerId = $this->record->id;
        // Use Filament's resource URL generator for DeviceResource
        $this->redirect(\App\Filament\Resources\Device\DeviceResource::getUrl('create', ['customer_id' => $customerId]));
    }
}

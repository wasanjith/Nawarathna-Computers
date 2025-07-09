<?php

namespace App\Filament\Resources\CustomerCallResource\Pages;

use App\Filament\Resources\CustomerCallResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerCalls extends ListRecords
{
    protected static string $resource = CustomerCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

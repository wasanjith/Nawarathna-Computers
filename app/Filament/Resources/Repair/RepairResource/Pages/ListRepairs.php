<?php

namespace App\Filament\Resources\Repair\RepairResource\Pages;

use App\Filament\Resources\Repair\RepairResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepairs extends ListRecords
{
    protected static string $resource = RepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

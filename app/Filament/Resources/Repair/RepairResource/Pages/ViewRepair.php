<?php

namespace App\Filament\Resources\Repair\RepairResource\Pages;

use App\Filament\Resources\Repair\RepairResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRepair extends ViewRecord
{
    protected static string $resource = RepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Removed Actions\EditAction::make(),
        ];
    }
}

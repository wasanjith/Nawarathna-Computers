<?php

namespace App\Filament\Resources\Repair\RepairResource\Pages;

use App\Filament\Resources\Repair\RepairResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepair extends EditRecord
{
    protected static string $resource = RepairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

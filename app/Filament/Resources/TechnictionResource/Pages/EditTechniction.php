<?php

namespace App\Filament\Resources\TechnictionResource\Pages;

use App\Filament\Resources\TechnictionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechniction extends EditRecord
{
    protected static string $resource = TechnictionResource::class;

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
}

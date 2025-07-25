<?php

namespace App\Filament\Resources\TechnictionResource\Pages;

use App\Filament\Resources\TechnictionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnictions extends ListRecords
{
    protected static string $resource = TechnictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

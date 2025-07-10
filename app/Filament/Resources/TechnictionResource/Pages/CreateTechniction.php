<?php

namespace App\Filament\Resources\TechnictionResource\Pages;

use App\Filament\Resources\TechnictionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTechniction extends CreateRecord
{
    protected static string $resource = TechnictionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

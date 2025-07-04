<?php

namespace App\Filament\Resources\SmsMessage\SmsMessageResource\Pages;

use App\Filament\Resources\SmsMessage\SmsMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSmsMessage extends EditRecord
{
    protected static string $resource = SmsMessageResource::class;

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

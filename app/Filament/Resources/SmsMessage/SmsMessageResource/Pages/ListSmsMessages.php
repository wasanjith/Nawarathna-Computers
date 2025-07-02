<?php

namespace App\Filament\Resources\SmsMessage\SmsMessageResource\Pages;

use App\Filament\Resources\SmsMessage\SmsMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSmsMessages extends ListRecords
{
    protected static string $resource = SmsMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

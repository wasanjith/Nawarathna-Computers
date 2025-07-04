<?php

namespace App\Filament\Resources\Payment\PaymentResource\Pages;

use App\Filament\Resources\Payment\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('checklist')
                ->label('Checklist')
                ->url('http://nawarathnacomputers.test/', true)
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary'),
        ];
    }
} 
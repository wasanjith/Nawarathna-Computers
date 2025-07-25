<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions;
use App\Filament\Widgets\ActivityHistoryWidget;
use App\Filament\Widgets\RevenueWidget;
use App\Filament\Widgets\StatsOverview;

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

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            RevenueWidget::class,
            ActivityHistoryWidget::class,
        ];
    }
} 
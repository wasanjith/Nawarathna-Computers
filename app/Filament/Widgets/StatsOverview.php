<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Invoice;
use App\Models\Repair;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('Active customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Pending Repairs', Repair::where('status', 'pending')->count())
                ->description('Awaiting repair')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('In Progress Repairs', Repair::where('status', 'in_progress')->count())
                ->description('Currently being repaired')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('info'),
            
            Stat::make('Completed Repairs', Repair::where('status', 'completed')->count())
                ->description('Successfully completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}

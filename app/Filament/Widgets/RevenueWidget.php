<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalRevenue = Payment::sum('amount');
        $thisMonthRevenue = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $pendingInvoices = Invoice::where('payment_status', 'unpaid')->sum('total');

        return [
            Stat::make('Total Revenue', 'Rs. ' . number_format($totalRevenue, 2))
                ->description('All time revenue')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('This Month Revenue', 'Rs. ' . number_format($thisMonthRevenue, 2))
                ->description('Current month earnings')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            
            Stat::make('Pending Payments', 'Rs. ' . number_format($pendingInvoices, 2))
                ->description('Unpaid invoices')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}

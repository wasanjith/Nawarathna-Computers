<?php

namespace App\Filament\Widgets;

use App\Models\Repair;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRepairsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Latest Repairs';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Repair::query()
                    ->with(['customer', 'device'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('device.slug')
                    ->label('Device')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('problem_description')
                    ->label('Problem')
                    ->limit(30),
                
                
                
                Tables\Columns\TextColumn::make('estimated_cost')
                    ->money('LKR')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('estimated_completion_at')
                    ->label('Est. Completion')
                    ->date()
                    ->sortable(),
            ]);
    }
}

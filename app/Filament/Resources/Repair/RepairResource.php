<?php

namespace App\Filament\Resources\Repair;

use App\Filament\Resources\Repair\RepairResource\Pages;
use App\Models\Repair;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RepairResource extends Resource
{
    protected static ?string $model = Repair::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Repair Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('device_id')
                    ->relationship('device', 'slug')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $device = \App\Models\Device::find($state);
                            if ($device && $device->customer_id) {
                                $set('customer_id', $device->customer_id);
                            }
                        }
                    }),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Forms\Components\Textarea::make('problem_description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('device.slug')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('problem_description')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('replaced_items')
                    ->label('Replaced Items')
                    ->html()
                    ->getStateUsing(function (Repair $record) {
                        $checklist = $record->checkList;
                        if (!$checklist) {
                            return '';
                        }
                        $fields = [
                            'processor', 'motherboard', 'ram', 'hard_disk_1', 'hard_disk_2', 'optical_drive',
                            'network', 'wifi', 'camera', 'hinges', 'laptopSPK', 'mic', 'touchPad', 'keyboard',
                            'frontUSB', 'rearUSB', 'frontSound', 'rearSound', 'vgaPort', 'hdmiPort', 'hardHealth',
                            'stressTest', 'benchMark', 'powerCable_1', 'powerCable_2', 'vgaCable', 'dviCable',
                            'backpanelnuts'
                        ];
                        $replaced = [];
                        foreach ($fields as $field) {
                            if (isset($checklist->$field) && $checklist->$field === 'replaced') {
                                $replaced[] = $field;
                            }
                        }
                        if (empty($replaced)) {
                            return '-';
                        }
                        $rows = [];
                        for ($i = 0; $i < count($replaced); $i += 2) {
                            $col1 = e(ucwords(str_replace(['_', 'SPK'], [' ', ' Speaker'], $replaced[$i])));
                            $col2 = isset($replaced[$i + 1]) ? e(ucwords(str_replace(['_', 'SPK'], [' ', ' Speaker'], $replaced[$i + 1]))) : '';
                            $rows[] = "<tr><td>{$col1}</td><td>{$col2}</td></tr>";
                        }
                        $table = '<table style="width:100%;border:none;">' . implode('', $rows) . '</table>';
                        return '<details><summary style="cursor:pointer;">Show Replaced Items</summary>' . $table . '</details>';
                    })
                    ->sortable(false)
                    ->searchable(false),
                Tables\Columns\SelectColumn::make('techniction_id')
                    ->label('Technician')
                    ->options(fn () => \App\Models\Techniction::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->sortable()
                    ->placeholder('Not Assigned')
                    ->default(null)
                    ->selectablePlaceholder('Select Technician'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('checklist')
                    ->label('Checklist')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Repair $record): string => route('checklist.edit', $record->checkList->id))
                    ->openUrlInNewTab()
                    ->visible(fn(Repair $record): bool => isset($record->checkList)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 WHEN status = 'in_progress' THEN 2 WHEN status = 'completed' THEN 3 WHEN status = 'cancelled' THEN 4 ELSE 5 END");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepairs::route('/'),
            'create' => Pages\CreateRepair::route('/create'),
            'edit' => Pages\EditRepair::route('/{record}/edit'),
        ];
    }
}

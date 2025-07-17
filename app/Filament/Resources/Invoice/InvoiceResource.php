<?php

namespace App\Filament\Resources\Invoice;

use App\Filament\Resources\Invoice\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Financial Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('repair_id')
                    ->relationship('repair', 'slug')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $repair = \App\Models\Repair::find($state);
                        $checklist = $repair?->checkList;
                        if ($checklist) {
                            $fields = [
                                'processor', 'motherboard', 'ram', 'hard_disk_1', 'hard_disk_2', 'optical_drive',
                                'network', 'wifi', 'camera', 'hinges', 'laptopSPK', 'lapCamera', 'mic', 'touchPad',
                                'keyboard', 'frontUSB', 'rearUSB', 'frontSound', 'rearSound', 'vgaPort', 'hdmiPort',
                                'hardHealth', 'stressTest', 'benchMark', 'powerCable_1', 'powerCable_2', 'vgaCable', 'dviCable'
                            ];
                            $replaced = [];
                            foreach ($fields as $field) {
                                if ($checklist->$field === 'replaced') {
                                    $replaced[] = $field;
                                }
                            }
                            // Pre-fill the repeater
                            $rows = [];
                            foreach ($replaced as $item) {
                                $rows[] = [
                                    'item' => $item,
                                    'brand' => '',
                                    'price' => '',
                                ];
                            }
                            $set('replaced_items_table', $rows);
                            $set('checklist_id', $checklist->id);
                        } else {
                            $set('replaced_items_table', []);
                            $set('checklist_id', null);
                        }
                    }),
                Forms\Components\TextInput::make('invoice_number')
                    ->required()
                    ->maxLength(5)
                    ->default(function () {
                        $lastInvoice = \App\Models\Invoice::orderByDesc('id')->first();
                        $nextNumber = $lastInvoice ? intval($lastInvoice->invoice_number) + 1 : 1;
                        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                    })
                    ->unique(ignoreRecord: true),

                Forms\Components\Repeater::make('replaced_items_table')
                    ->label('Replaced Items Table')
                    ->schema([
                        Forms\Components\TextInput::make('item')
                            ->label('Replaced Item')
                            ->disabled(),
                        Forms\Components\TextInput::make('brand')
                            ->label('Brand')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->prefix('Rs.')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                // When a price is updated, recalculate total
                                $rows = $get('../../replaced_items_table') ?? [];
                                $total = 0;
                                foreach ($rows as $row) {
                                    $total += floatval($row['price'] ?? 0);
                                }
                                $set('../../total', $total);
                            }),
                    ])
                    ->grid(3)
                    ->columnSpanFull()
                    ->required(false)
                    ->afterStateHydrated(function ($component, $state, $record, $set) {
                        // On edit, hydrate from the three columns if present
                        if ($record) {
                            $items = $record->replaced_items ?? [];
                            $brands = $record->replaced_items_brand ?? [];
                            $prices = $record->replaced_items_prices ?? [];
                            $rows = [];
                            foreach ($items as $i => $item) {
                                $rows[] = [
                                    'item' => $item,
                                    'brand' => $brands[$i] ?? '',
                                    'price' => $prices[$i] ?? '',
                                ];
                            }
                            $set('replaced_items_table', $rows);
                        }
                    })
                    ->dehydrateStateUsing(function ($state) {
                        // Only return the state, do not try to set other fields here
                        return $state;
                    })
                    ->reactive(),

                Forms\Components\Hidden::make('replaced_items')
                    ->dehydrateStateUsing(fn ($state, $get) => collect($get('replaced_items_table'))->pluck('item')->toArray()),
                Forms\Components\Hidden::make('replaced_items_brand')
                    ->dehydrateStateUsing(fn ($state, $get) => collect($get('replaced_items_table'))->pluck('brand')->toArray()),
                Forms\Components\Hidden::make('replaced_items_prices')
                    ->dehydrateStateUsing(fn ($state, $get) => collect($get('replaced_items_table'))->pluck('price')->toArray()),
                Forms\Components\TextInput::make('repair_cost')
                    ->label('Repair Cost')
                    ->numeric()
                    ->prefix('Rs.')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // When repair_cost changes, update total
                        $rows = $get('replaced_items_table') ?? [];
                        $repairCost = floatval($state ?? 0);
                        $total = 0;
                        foreach ($rows as $row) {
                            $total += floatval($row['price'] ?? 0);
                        }
                        $total += $repairCost;
                        $set('total', $total);
                    }),
                    Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ])
                    ->default('unpaid')
                    ->required(),
                

                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.')
                    ->reactive()
                    ->afterStateHydrated(function ($set, $get) {
                        // On load, sum prices if present and add repair_cost
                        $rows = $get('replaced_items_table') ?? [];
                        $repairCost = floatval($get('repair_cost') ?? 0);
                        $total = 0;
                        foreach ($rows as $row) {
                            $total += floatval($row['price'] ?? 0);
                        }
                        $total += $repairCost;
                        $set('total', $total);
                    })
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // When prices or repair_cost change, update total
                        $rows = $get('replaced_items_table') ?? [];
                        $repairCost = floatval($get('repair_cost') ?? 0);
                        $total = 0;
                        foreach ($rows as $row) {
                            $total += floatval($row['price'] ?? 0);
                        }
                        $total += $repairCost;
                        $set('total', $total);
                    }),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                // ->alignCenter(),
                Tables\Columns\TextColumn::make('repair.device.slug')
                    ->label('Device')
                    ->searchable(),
                // ->alignCenter(),
                Tables\Columns\TextColumn::make('total')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ])
                    ->alignCenter(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                \Filament\Tables\Actions\Action::make('view_invoice')
                    ->label('View Invoice')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('invoice.print', ['invoice' => $record->id]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view-invoice' => Pages\ViewInvoice::route('/{record}/view-invoice'),
        ];
    }
}

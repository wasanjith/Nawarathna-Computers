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
                    ->afterStateUpdated(function ($state, callable $set) {
                        $repair = \App\Models\Repair::find($state);
                        $checklist = $repair?->checkList;
                        if ($checklist) {
                            // List all relevant columns to check for 'replaced' status
                            $fields = [
                                'processor',
                                'motherboard',
                                'ram',
                                'hard_disk_1',
                                'hard_disk_2',
                                'optical_drive',
                                'network',
                                'wifi',
                                'camera',
                                'hinges',
                                'laptopSPK',
                                'lapCamera',
                                'mic',
                                'touchPad',
                                'keyboard',
                                'frontUSB',
                                'rearUSB',
                                'frontSound',
                                'rearSound',
                                'vgaPort',
                                'hdmiPort',
                                'hardHealth',
                                'stressTest',
                                'benchMark',
                                'powerCable_1',
                                'powerCable_2',
                                'vgaCable',
                                'dviCable'
                            ];
                            $replaced = [];
                            foreach ($fields as $field) {
                                if ($checklist->$field === 'replaced') {
                                    $replaced[] = $field;
                                }
                            }
                            $set('replaced_items', !empty($replaced) ? json_encode($replaced, JSON_PRETTY_PRINT) : null);
                            $set('checklist_id', $checklist->id);
                        } else {
                            $set('replaced_items', null);
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

                Forms\Components\Textarea::make('replaced_items')
                    ->label('Replaced Items')
                    ->rows(3)
                    ->nullable()
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return '';
                        }
                        // If already an array, format as bullet list
                        if (is_array($state)) {
                            return '• ' . implode("\n• ", $state);
                        }
                        // If JSON string, decode and format as bullet list
                        $items = json_decode($state, true);
                        if (is_array($items)) {
                            return '• ' . implode("\n• ", $items);
                        }
                        // Otherwise, return as is
                        return $state;
                    })
                    ->dehydrateStateUsing(function ($state) {
                        // Convert bullet list or plain text to JSON array for saving
                        if (empty($state)) {
                            return null;
                        }
                        // Remove bullets and split by lines
                        $lines = preg_split('/\r\n|\r|\n/', $state);
                        $items = [];
                        foreach ($lines as $line) {
                            $line = trim($line, "• \t\n\r\0\x0B");
                            if ($line !== '') {
                                $items[] = $line;
                            }
                        }
                        return !empty($items) ? json_encode($items, JSON_PRETTY_PRINT) : null;
                    })
                    ->helperText('Automatically suggested from checklist, you can edit if needed. Enter one item per line.'),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.'),
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ])
                    ->default('unpaid')
                    ->required(),
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
        ];
    }
}

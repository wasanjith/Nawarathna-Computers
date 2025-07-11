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
                        // Fetch checklist replaced items for selected repair
                        $repair = \App\Models\Repair::find($state);
                        $checklist = $repair?->checklist;
                        if ($checklist && !empty($checklist->replaced_items)) {
                            // Assume replaced_items is stored as JSON array in checklist
                            $set('replaced_items', json_encode($checklist->replaced_items, JSON_PRETTY_PRINT));
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
                Forms\Components\Textarea::make('replaced_items')
                    ->label('Replaced Items (JSON Array)')
                    ->rows(3)
                    ->nullable()
                    ->helperText('Automatically suggested from checklist, you can edit if needed.'),
                // Forms\Components\Select::make('checklist_id')
                //     ->relationship('checklist', 'id')
                //     ->searchable()
                //     ->preload()
                //     ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('repair.customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('repair.device.slug')
                    ->label('Device')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'danger' => 'unpaid',
                        'warning' => 'partial',
                        'success' => 'paid',
                    ]),
                Tables\Columns\TextColumn::make('replaced_items')
                    ->label('Replaced Items')
                    ->limit(50),
                Tables\Columns\TextColumn::make('checklist_id')
                    ->label('Checklist ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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

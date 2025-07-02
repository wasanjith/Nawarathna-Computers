<?php

namespace App\Filament\Resources\Payment;

use App\Filament\Resources\Payment\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Financial Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('invoice_id')
                    ->relationship('invoice', 'invoice_number')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.'),
                Forms\Components\Select::make('method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'bank' => 'Bank Transfer',
                        'online' => 'Online Payment',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('received_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice.repair.customer.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('method')
                    ->colors([
                        'success' => 'cash',
                        'primary' => 'card',
                        'warning' => 'bank',
                        'info' => 'online',
                    ]),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('received_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'bank' => 'Bank Transfer',
                        'online' => 'Online Payment',
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Customer;

use App\Filament\Resources\Customer\CustomerCallResource\Pages;
use App\Models\CustomerCall;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerCallResource extends Resource
{
    protected static ?string $model = CustomerCall::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?string $navigationLabel = 'Customer Calls';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('called_at')
                    ->required()
                    ->default(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'answered' => 'Answered',
                        'no_answer' => 'No Answer',
                        'busy' => 'Busy',
                        'switched_off' => 'Switched Off',
                    ])
                    ->required()
                    ->default('no_answer'),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('called_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'answered',
                        'warning' => 'busy',
                        'danger' => ['no_answer', 'switched_off'],
                    ]),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(50),
            ])
            ->defaultSort('called_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'answered' => 'Answered',
                        'no_answer' => 'No Answer',
                        'busy' => 'Busy',
                        'switched_off' => 'Switched Off',
                    ]),
                Tables\Filters\Filter::make('today')
                    ->query(fn ($query) => $query->whereDate('called_at', today()))
                    ->label('Today\'s Calls'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerCalls::route('/'),
            'create' => Pages\CreateCustomerCall::route('/create'),
            'edit' => Pages\EditCustomerCall::route('/{record}/edit'),
        ];
    }
}
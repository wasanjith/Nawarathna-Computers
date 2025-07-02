<?php

namespace App\Filament\Resources\SmsMessage;

use App\Filament\Resources\SmsMessage\SmsMessageResource\Pages;
use App\Models\SmsMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SmsMessageResource extends Resource
{
    protected static ?string $model = SmsMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Communication';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('send_at')
                    ->required(),
                Forms\Components\TextInput::make('provider_message_id')
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'queued' => 'Queued',
                        'sent' => 'Sent',
                        'failed' => 'Failed',
                    ])
                    ->default('queued')
                    ->required(),
                Forms\Components\Textarea::make('error')
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
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('send_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'queued',
                        'success' => 'sent',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('provider_message_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'queued' => 'Queued',
                        'sent' => 'Sent',
                        'failed' => 'Failed',
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
            'index' => Pages\ListSmsMessages::route('/'),
            'create' => Pages\CreateSmsMessage::route('/create'),
            'edit' => Pages\EditSmsMessage::route('/{record}/edit'),
        ];
    }
}

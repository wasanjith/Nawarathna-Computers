<?php

namespace App\Filament\Resources\Device;

use App\Filament\Resources\Device\DeviceResource\Pages;
use App\Models\Device;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationGroup = 'Device Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->default(fn () => request()->get('customer_id')) // <-- Add this line
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateSlug($set, $get);
                    }),
                Forms\Components\TextInput::make('device_type')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateSlug($set, $get);
                    }),
                Forms\Components\TextInput::make('brand')
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateSlug($set, $get);
                    }),
                Forms\Components\TextInput::make('model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial_number')
                    ->maxLength(3)
                    ->default(function () {
                        // Get the last serial_number, increment, and pad to 3 digits
                        $last = \App\Models\Device::orderByDesc('id')->first();
                        $lastSerial = $last?->serial_number ?? '000';
                        // Ensure we only consider the last 3 characters
                        $lastSerial = substr($lastSerial, -3);
                        $nextSerial = str_pad(((int)$lastSerial) + 1, 3, '0', STR_PAD_LEFT);
                        return $nextSerial;
                    })
                    ->required()
                    ->unique(ignoreRecord: true),
                    
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                    
                Forms\Components\Select::make('intheshowroom')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])
            ]);
    }

    private static function generateSlug(callable $set, callable $get)
    {
        $customerId = $get('customer_id');
        $deviceType = $get('device_type');
        $brand = $get('brand');

        if ($customerId && $deviceType && $brand) {
            // Get customer name
            $customer = \App\Models\Customer::find($customerId);
            $customerName = $customer?->name ?? '';

            // Extract first name and add possessive
            $firstName = explode(' ', trim($customerName))[0] ?? '';
            $possessiveName = $firstName ? $firstName . "'s" : '';

            // Get first 3 characters of device type
            $deviceShort = substr($deviceType, 0, 3);

            // Create slug: "John's MSI Lap"
            $slug = trim($possessiveName . ' ' . $brand . ' ' . $deviceShort);

            $set('slug', $slug);
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('intheshowroom')
                    ->label('In the Showroom')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'yes' => 'success',
                        'no' => 'danger',
                    })
                    ->sortable(),
                //Register date column
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),


            ])
            ->defaultSort(function (\Illuminate\Database\Eloquent\Builder $query) {
                return $query
                    ->orderByRaw("CASE WHEN intheshowroom = 'yes' THEN 0 ELSE 1 END ASC")
                    ->orderBy('created_at', 'asc');
            })

            ->filters([
                //
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}

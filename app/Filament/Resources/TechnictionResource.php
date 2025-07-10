<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnictionResource\Pages;
use App\Filament\Resources\TechnictionResource\RelationManagers;
use App\Models\Techniction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Repair;

class TechnictionResource extends Resource
{
    protected static ?string $model = Techniction::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $navigationGroup = 'Repair Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->required()
                    ->maxLength(20),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('phone')->sortable()->searchable(),

                // TextColumn::make('repairs_count')
                //     ->label('Repairs')
                //     ->counts('repairs')
                //     ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechnictions::route('/'),
            'create' => Pages\CreateTechniction::route('/create'),
            'edit' => Pages\EditTechniction::route('/{record}/edit'),
        ];
    }
}

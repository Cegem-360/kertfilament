<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('foundation_name')
                    ->required()
                    ->maxLength(100)
                    ->default('Különleges Ellátásban Részesülők Támogatásáért Alapítvány'),
                Forms\Components\TextInput::make('foundation_headquarters')
                    ->required()
                    ->maxLength(100)
                    ->default('3100 Salgótarján, Úttörők útja 15.'),
                Forms\Components\TextInput::make('foundation_tax_identification_number')
                    ->required()
                    ->maxLength(100)
                    ->default('18649954-1-12'),
                Forms\Components\DateTimePicker::make('donation_date')
                    ->required(),
                Forms\Components\TextInput::make('donation_amount')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('people_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('donation_type_id')
                    ->relationship('donationType', 'name')
                    ->required(),
                Forms\Components\Select::make('family_id')
                    ->relationship('family', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('foundation_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foundation_headquarters')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foundation_tax_identification_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('donation_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('donation_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('people_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('donationType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}

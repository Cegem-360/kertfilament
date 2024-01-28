<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Actions;
use App\Models\People;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use App\Filament\Imports\PeopleImporter;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Resources\PeopleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PeopleResource\RelationManagers;

class PeopleResource extends Resource
{
    protected static ?string $model = People::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                    ->maxLength(100),
                Forms\Components\DateTimePicker::make('date_of_birth'),
                TextInput::make('birth_name')
                    ->maxLength(100),
                TextInput::make('place_of_birth')
                    ->maxLength(100),
                TextInput::make('mobile_number')
                    ->maxLength(100),
                TextInput::make('postal_code')
                    ->maxLength(100),
                TextInput::make('postal_city')
                    ->maxLength(100),
                TextInput::make('postal_street')
                    ->maxLength(100),
                TextInput::make('tax_identification_number')
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->email()
                    ->maxLength(100),
                TextInput::make('status')
                    ->maxLength(100)
                    ->default('Támogatott'),
                TextInput::make('account_number')
                    ->maxLength(100),
                TextInput::make('company_name')
                    ->maxLength(100),
                TextInput::make('mother_birth_name')
                    ->maxLength(100),
                TextInput::make('dead_name')
                    ->maxLength(100),
                Forms\Components\Select::make('family_id')
                    ->relationship('family', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('dead_date'),
                TextInput::make('damaged')
                    ->maxLength(255)
                    ->default('nem'),
                TextInput::make('dead_mother_certificate')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('place_of_birth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tax_identification_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mother_birth_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dead_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('family.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dead_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('damaged')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dead_mother_certificate')
                    ->searchable(),
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

                Tables\Actions\CreateAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PeopleImporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    protected function getHeaderActions(): array
    {
        return [];
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePeople::route('/create'),
            'edit' => Pages\EditPeople::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('camp_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('project_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('thematics')
                    ->maxLength(100),
                Forms\Components\DateTimePicker::make('project_start')
                    ->required(),
                Forms\Components\DateTimePicker::make('project_end')
                    ->required(),
                Forms\Components\TextInput::make('travel_expenses')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('accommodation')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('camp_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thematics')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_start')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_end')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('travel_expenses')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accommodation')
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Donation;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Imports\DonationImporter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\DonationResource\Pages\EditDonation;
use App\Filament\Resources\DonationResource\Pages\ListDonations;
use App\Filament\Resources\DonationResource\Pages\CreateDonation;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('foundation_name')
                    ->required()
                    ->maxLength(100)
                    ->default('Különleges Ellátásban Részesülők Támogatásáért Alapítvány'),
                TextInput::make('foundation_headquarters')
                    ->required()
                    ->maxLength(100)
                    ->default('3100 Salgótarján, Úttörők útja 15.'),
                TextInput::make('foundation_tax_identification_number')
                    ->required()
                    ->maxLength(100)
                    ->default('18649954-1-12'),
                DateTimePicker::make('donation_date')
                    ->required(),
                TextInput::make('donation_amount')
                    ->numeric()
                    ->default(0),
                TextInput::make('people_id')
                    ->required()
                    ->numeric(),
                Select::make('donation_type_id')
                    ->relationship('donationType', 'name')
                    ->required(),
                Select::make('family_id')
                    ->relationship('family', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('foundation_name')
                    ->searchable(),
                TextColumn::make('foundation_headquarters')
                    ->searchable(),
                TextColumn::make('foundation_tax_identification_number')
                    ->searchable(),
                TextColumn::make('donation_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('donation_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('people_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('donationType.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('family.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(), Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-s-arrow-small-down')
                    ->action(function (Donation $record) {
                        return response()->streamDownload(
                            callback: function () use ($record) {
                                echo Pdf::loadHtml(
                                    Blade::render('pdf', ['record' => $record])
                                )->stream();
                            },
                            name: $record->foundation_name . '.pdf'
                        );
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->headerActions([
                ImportAction::make()
                    ->importer(DonationImporter::class),
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
            'index' => ListDonations::route('/'),
            'create' => CreateDonation::route('/create'),
            'edit' => EditDonation::route('/{record}/edit'),
        ];
    }
}

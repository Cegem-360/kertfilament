<?php

namespace App\Filament\Imports;

use App\Models\People;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PeopleImporter extends Importer
{
    protected static ?string $model = People::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('full_name')
                ->rules(['max:100']),
            ImportColumn::make('date_of_birth')
                ->rules(['datetime']),
            ImportColumn::make('birth_name')
                ->rules(['max:100']),
            ImportColumn::make('place_of_birth')
                ->rules(['max:100']),
            ImportColumn::make('mobile_number')
                ->rules(['max:100']),
            ImportColumn::make('postal_code')
                ->rules(['max:100']),
            ImportColumn::make('postal_city')
                ->rules(['max:100']),
            ImportColumn::make('postal_street')
                ->rules(['max:100']),
            ImportColumn::make('tax_identification_number')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('email')
                ->rules(['email', 'max:100']),
            ImportColumn::make('status')
                ->rules(['max:100']),
            ImportColumn::make('account_number')
                ->rules(['max:100']),
            ImportColumn::make('company_name')
                ->rules(['max:100']),
            ImportColumn::make('mother_birth_name')
                ->rules(['max:100']),
            ImportColumn::make('dead_name')
                ->rules(['max:100']),
            ImportColumn::make('family')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('dead_date')
                ->rules(['datetime']),
            ImportColumn::make('damaged')
                ->rules(['max:255']),
            ImportColumn::make('dead_mother_certificate')
                ->rules(['max:100']),
        ];
    }

    public function resolveRecord(): ?People
    {
        // return People::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new People();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your people import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

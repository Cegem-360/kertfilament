<?php

namespace App\Filament\Imports;

use App\Models\Donation;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DonationImporter extends Importer
{
    protected static ?string $model = Donation::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('foundation_name')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('foundation_headquarters')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('foundation_tax_identification_number')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
            ImportColumn::make('donation_date')
                ->requiredMapping()
                ->rules(['required', 'datetime']),
            ImportColumn::make('donation_amount')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('people_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('donationType')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('family')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Donation
    {
        // return Donation::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Donation();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your donation import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Imports;

use App\Models\Family;
use App\Models\People;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
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
                ->rules(['max:255']),
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
                ->rules(['max:100']),
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
                ->relationship('family', function (string $state): Family {
                    return Family::query()
                        ->where('name', $state)
                        ->first();
                })
                ->rules(['required']),
            ImportColumn::make('dead_date')
                ->rules(['max:255']),
            ImportColumn::make('damaged')
                ->rules(['max:255']),
            ImportColumn::make('dead_mother_certificate')
                ->rules(['max:100']),
        ];
    }

    public function resolveRecord(): ?People
    {
        return People::firstOrNew([
            'full_name' => $this->data['full_name'],
            'date_of_birth' => $this->data['date_of_birth'],
            'birth_name' => $this->data['birth_name'],
            'place_of_birth' => $this->data['place_of_birth'],
            'mobile_number' => $this->data['mobile_number'],
            'postal_code' => $this->data['postal_code'],
            'postal_city' => $this->data['postal_city'],
            'postal_street' => $this->data['postal_street'],
            'tax_identification_number' => $this->data['tax_identification_number'],
            'email' => $this->data['email'],
            'status' => $this->data['status'],
            'account_number' => $this->data['account_number'],
            'company_name' => $this->data['company_name'],
            'mother_birth_name' => $this->data['mother_birth_name'],
            'dead_name' => $this->data['dead_name'],
            'dead_date' => $this->data['dead_date'],
            'damaged' => $this->data['damaged'],
            'dead_mother_certificate' => $this->data['dead_mother_certificate'],
            'family_id' => $this->data['family'],
        ]);
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

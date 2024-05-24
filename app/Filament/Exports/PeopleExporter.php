<?php

namespace App\Filament\Exports;

use App\Models\People;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PeopleExporter extends Exporter
{
    protected static ?string $model = People::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('full_name'),
            ExportColumn::make('date_of_birth'),
            ExportColumn::make('birth_name'),
            ExportColumn::make('place_of_birth'),
            ExportColumn::make('mobile_number'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('postal_city'),
            ExportColumn::make('postal_street'),
            ExportColumn::make('tax_identification_number'),
            ExportColumn::make('email'),
            ExportColumn::make('status'),
            ExportColumn::make('account_number'),
            ExportColumn::make('company_name'),
            ExportColumn::make('mother_birth_name'),
            ExportColumn::make('dead_name'),
            ExportColumn::make('family_id'),
            ExportColumn::make('dead_date'),
            ExportColumn::make('damaged'),
            ExportColumn::make('dead_mother_certificate'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your people export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

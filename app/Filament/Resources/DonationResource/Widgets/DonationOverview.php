<?php

namespace App\Filament\Resources\DonationResource\Widgets;

use Filament\Widgets\ChartWidget;

class DonationOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

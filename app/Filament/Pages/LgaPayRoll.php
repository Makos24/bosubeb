<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LgaPayRoll extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.lga-pay-roll';

    protected static ?string $title = 'LGA Payroll Summary';

    protected static ?string $navigationGroup = 'Payroll';

    protected static ?int $navigationSort = 2;
}

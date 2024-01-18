<?php

namespace App\Filament\Pages;

use App\Models\Lga;
use App\Models\Staff;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class PayRoll extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pay-roll';

    protected static ?string $title = 'Payroll Summary';
    
    protected static ?string $navigationGroup = 'Payroll';
    protected static ?int $navigationSort = 2;
    
}

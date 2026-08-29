<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\Staff;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $activeStaff = Staff::notStudent()->notDead()->notSenior()->notPensioners()->count();
        $pensioners  = Staff::pensioners()->count();
        $openLoans   = Loan::where('status', 0)->count();
        $deceased    = Staff::dead()->count();

        return [
            Stat::make('Active Staff', number_format($activeStaff))
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make('Pensioners', number_format($pensioners))
                ->icon('heroicon-o-identification')
                ->color('info'),

            Stat::make('Pending Loans', number_format($openLoans))
                ->icon('heroicon-o-banknotes')
                ->color('warning'),

            Stat::make('Deceased', number_format($deceased))
                ->icon('heroicon-o-archive-box')
                ->color('gray'),
        ];
    }
}

<?php

namespace App\Filament\Resources\PayrollResource\Pages;

use App\Exports\PayrollExport;
use App\Filament\Resources\PayrollResource;
use App\Models\Staff;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListPayrolls extends ListRecords
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('export_pay')->label("Download All Payroll")->action(function() {
                $payroll =  Staff::with(["lga", "school", "salary_data"])->where('expected_date_of_retirement', '>=', \Carbon\Carbon::today())->get();
                //dd($payroll);
               return Excel::download(new PayrollExport("Summary", $payroll), 'allstaff.xlsx');
            }),
        ];
    }
}

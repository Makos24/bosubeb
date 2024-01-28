<?php

namespace App\Filament\Resources\PensionPayrollResource\Pages;

use App\Exports\PensionPayrollExport;
use App\Filament\Resources\PensionPayrollResource;
use App\Models\Staff;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListPensionPayrolls extends ListRecords
{
    protected static string $resource = PensionPayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pay')->label("Download Pension Payroll")->action(function() {
                $payroll =  Staff::with(["lga", "school", "salary_data"])->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->get();
                //dd($payroll);
               return Excel::download(new PensionPayrollExport("Summary", $payroll), Carbon::today().'allstaff.xlsx');
            }),
            // Actions\CreateAction::make(),
        ];
    }
}

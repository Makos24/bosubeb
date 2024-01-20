<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Exports\LGAStaffExport;
use App\Exports\PayrollExport;
use App\Filament\Resources\StaffResource;
use App\Imports\StaffImport;
use App\Models\Staff;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\BulkAction;
use Maatwebsite\Excel\Facades\Excel;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        set_time_limit(500);
        
        return [
            Actions\CreateAction::make(),
            Action::make('Upload Staff Records')
            ->form([
                FileUpload::make('file')
                ->required()
                ->disk('public')
                ->directory('files'),
            ])
            ->action(function ($data) {
                //dd($data);
                $url = storage_path('app/public/'.$data['file']);
                //dd($url);

                $import = new StaffImport;
                $import->import($url);

                if ($import->failures()->isNotEmpty()) {
                    dd($import->failures()[0]);
                }
                //Excel::import(new StaffImport, $url);
            }),

            ActionGroup::make([
                // Array of actions
                Action::make('export_all')->label("Export All Records")->action(fn() => (Excel::download(new LGAStaffExport(), 'allstaff.xlsx'))),
                Action::make('export_lga')->label("Export by LGA")->action(fn() => (Excel::download(new LGAStaffExport(), 'allstaff.xlsx'))),
                Action::make('export_pay')->label("All Payroll Summary")->action(function() {
                    $payroll =  Staff::with(["lga", "school"])->get()->groupBy('lga_id');
                    //dd($payroll);
                   return Excel::download(new PayrollExport("Summary", $payroll), 'allstaff.xlsx');
                }),
                Action::make('export_pay_lga')->label("LGA Payroll Summary")->action(fn() => (Excel::download(new LGAStaffExport(), 'allstaff.xlsx'))),

            ])
                ->label('Export')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button()
           
            
        ];
    }
}

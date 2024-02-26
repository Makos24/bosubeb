<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Exports\ExportPaymentSchedule;
use App\Exports\LGAPayrollExport;
use App\Exports\LGAStaffExport;
use App\Exports\PayrollExport;
use App\Filament\Resources\StaffResource;
use App\Imports\StaffImport;
use App\Models\Agency;
use App\Models\Category;
use App\Models\Lga;
use App\Models\PaymentSchedule;
use App\Models\Staff;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        set_time_limit(5000);
        
        return [
            Actions\CreateAction::make(),
            Action::make('Upload Staff Records')
            ->visible(fn () => auth()->user()->role_id == 1)
            ->form([
                FileUpload::make('file')
                ->required()
                ->disk('public')
                ->directory('files'),
                Select::make('category_id')
                ->label("Category")
                ->placeholder('Select Category')
                ->options(Category::query()->pluck("name", "id"))
                ->required()
                ->live(),
                Select::make('agency_id')
                ->label("MDA")
                ->placeholder('Select MDA')
                ->options(fn (Get $get): Collection => Agency::query()
                ->where('category_id', $get('category_id'))
                ->pluck('name', 'id'))
                ->required()
                ->visible(fn (Get $get): bool => $get('category_id') < 4 && $get('category_id') != ""),
            ])
            ->action(function ($data) {
                //dd($data);
                $url = storage_path('app/public/'.$data['file']);
                //dd($url);

                $import = new StaffImport($data['category_id'], $data['agency_id']);
                $import->import($url);

                if ($import->failures()->isNotEmpty()) {
                    //dd($import->failures()->first());

                    // Notification::make()
                    // ->title('Upload Interupted')
                    // ->error()
                    // ->body('Changes to the post have been saved.')
                    // ->send();
                }
                Storage::delete('public/' . $data['file']);

                Notification::make() 
                ->title('Uploaded successfully')
                ->success()
                ->send(); 
                //Excel::import(new StaffImport, $url);
            }),

            ActionGroup::make([
                // Array of actions
                Action::make('export_payment')->label("Payment Schedule")
                ->form([
                    Select::make('category_id')
                    ->label("Category")
                    ->options(Category::query()->pluck("name", "id"))
                    ->required()
                    ->live(),
                    Select::make('lga_id')
                    ->label('LGA')
                    ->options(Lga::query()->where('state_id', 8)->pluck("name", "id"))
                    ->visible(fn (Get $get): bool => $get('category_id') != "" && $get('category_id') < 4)
                    ->multiple(),
                    Select::make('agency_id')
                    ->label('MDA')
                    ->options(Agency::query()->pluck("name", "id"))
                    ->visible(fn (Get $get): bool => $get('category_id') == 4)
                    ->multiple(),
                    DatePicker::make('payment_due_date')
                    ->label("Payment Due Date")
                    ->required(),
                ])
                ->modalWidth("md")
                ->action(function($data){
                    
                    if($data['category_id'] < 4){
                        $ps = Staff::with("lga", "bank")->where('category_id', $data['category_id'])->whereIn('lga_id', $data['lga_id'])
                        ->whereDoesntHave("payments", function($query) use($data) {
                            return $query->whereYear('payment_due_date', $data['payment_due_date'])
                                         ->whereMonth('payment_due_date', $data['payment_due_date']);
                        } )->get();
                    }else{
                        $ps = Staff::with("lga", "bank")->where('category_id', $data['category_id'])->whereIn('agency_ic', $data['agency_id'])
                        ->whereDoesntHave("payments", function($query) use($data) {
                            return $query->whereYear('payment_due_date', $data['payment_due_date'])
                                         ->whereMonth('payment_due_date', $data['payment_due_date']);
                        } )->get();
                    }
                    

                    //dd($ps);

                    $date = Carbon::parse($data['payment_due_date']);
                    foreach($ps as $p){
                        PaymentSchedule::firstOrCreate([
                            'payment_reference' => $p->category_id != 4 ? $p->lga->lga_code."/".strtoupper($date->format('M'))."/Sal/".$date->format('j/y/n')."/".$p->id : 'SAL'.strtoupper($date->format('MY')).'-'.$p->id
                        ], 
                        [
                            'staff_id' => $p->id,
                            'amount' => $p->net_salary,
                            'payment_due_date' => $date->format('Y-m-d')
                        ]);
                    }

                    $payments =  PaymentSchedule::with(["staff.bank"])->where('payment_due_date', $date->format('Y-m-d'))->get();
                //dd($payroll);
                    return Excel::download(new ExportPaymentSchedule("Summary", $payments), Category::find($data['category_id'])->name.Carbon::now().'PaymentSchedule.xlsx');

                }),
                //Action::make('export_lga')->label("Export by LGA")->action(fn() => (Excel::download(new LGAStaffExport(), 'allstaff.xlsx'))),
                Action::make('export_pay')->label("All Payroll Summary")->action(function() {
                    $payroll =  Staff::with(["lga", "school", "salary_data"])->where('expected_date_of_retirement', '>=', \Carbon\Carbon::today())->get();
                //dd($payroll);
                    return Excel::download(new PayrollExport("Summary", $payroll), Carbon::now().'Payroll.xlsx');
                }),
                Action::make('export_pay_lga')->label("LGA Payroll Summary")->action(function(){
                    $payroll =  Staff::with(["lga", "school"])->get()->groupBy('school_id');
                    //dd($payroll);
                    return Excel::download(new LGAPayrollExport("Summary", $payroll), Carbon::today().'LGAPayroll.xlsx');
                }),

            ])
                ->label('Export')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('primary')
                ->button()
           
            
        ];
    }
}

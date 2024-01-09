<?php

namespace App\Http\Livewire;

use App\Exports\LGAStaffExport;
use App\Exports\SelectedStaffExport;
use App\Exports\StaffExport;
use App\Models\Lga;
use App\Models\Payroll;
use App\Models\School;

use App\Models\Staff;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class StaffTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    

    public function table(Table $table): Table
    {
        return $table
            ->query(Staff::query())
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('gender')->searchable(),
                TextColumn::make('lga.name')->searchable(),
                TextColumn::make('school.name')->searchable(),
                TextColumn::make('qualification')->searchable(),
                TextColumn::make('remark')->searchable(),
                TextColumn::make('status')->searchable(),
                TextColumn::make('dor')->searchable(),
                TextColumn::make('cadre')->searchable(),
                TextColumn::make('grade')->searchable(),
                TextColumn::make('salary_grade')->searchable(),
                TextColumn::make('bvn')->searchable(),
                TextColumn::make('nin')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
    
    public function render(): View
    {
        return view('livewire.staff-table');
    }
    
//     public bool $columnSelect = true, $test;
//     public array $filterNames = [
//         'lga' => 'LGA',
//         'qualification' => 'Qualification',
//         'gender' => 'Gender',
//         'status' => 'Status',
//         'remark' => 'Remark',
//     ];

    

//     public array $bulkActions = [
//         'exportSelected' => 'Export Selected',
//         'exportAllLga' => 'Export All by LGA',
//         'exportSelectedLga' => 'Export Selected LGA',
//         'payrollModal' => 'Export Payroll',
//         'payrollModalR' => 'Export Retirees Data',
//     ];

//     public $listeners = [
//         "staffAlertFunction" => 'staffAlertListener',
//    ];

   
// public function configure(): void
// {
//     $this->setPrimaryKey('id');
// }

// public function columns(): array
// {
//         return [
//             Column::make("Name ", "name")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Gender", "gender")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("LGA", "lga.name")
//                 ->sortable(function(Builder $query, $direction) {
//                     return $query->orderBy(Lga::select('name')->whereColumn('lgas.id', 'staff.lga_id'), $direction);
//                 })
//                 //->sortable()
//                   ->asHtml(),
//             Column::make("School", "school.name")
//                 ->sortable(function(Builder $query, $direction) {
//                     return $query->orderBy(School::select('name')->whereColumn('schools.id', 'staff.school_id'), $direction);
//                 })
//                   ->asHtml(),
//             Column::make("Qualification", "qualification")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Remark", "remark")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Status", "status")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Date of Retirement", "dor")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Cadre", "cadre")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Present GL", "grade")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Salary GL", "salary_grade")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("BVN", "bvn")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("NIN", "nin")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Salary", "net_salary")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Next of Kin Name", "next_of_kin_name")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Next of Kin Phone", "next_of_kin_phone")
//                 ->sortable()
//                   ->asHtml(),
//             Column::make("Relationship with Next of Kin", "next_of_kin_relationship")
//                 ->sortable()
//                   ->asHtml(),
//             // Column::make("Updated at", "updated_at")
//             //     ->sortable()
//             //       ->asHtml(),
//             Column::make("Actions")
//                   ->format(function($value, $column, $row){
//                     return view('partials.action', ['data' => $row]);
//                   })
//                   ,
                  
                  
//         ];
//     }

// public function query(): Builder
// {
//     return Staff::latest()
//         ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
//         ->when($this->getFilter('lga'), fn ($query, $lga) => $query->where('lga_id', $lga))
//         ->when($this->getFilter('cadre'), fn ($query, $cadre) => $query->where('cadre', $cadre))
//         ->when($this->getFilter('remark'), fn ($query, $remark) => $query->where('remark', $remark))
//         ->when($this->getFilter('qualification'), fn ($query, $qualification) => $query->where('qualification', $qualification))
//         ->when($this->getFilter('fdor'), fn ($query, $dor) => $query->where('dor', '>=', $dor))
//         ->when($this->getFilter('tdor'), fn ($query, $dor) => $query->where('dor', '<=', $dor))
//         ->when($this->getFilter('gender'), fn ($query, $gender) => $query->where('gender', $gender));
//             //->when($this->getFilter('2fa'), fn ($query, $twoFactor) => $twoFactor === 'enabled' ? $query->whereNotNull('two_factor_secret') : $query->whereNull('two_factor_secret'));

// }

// public function filters(): array
// {
//     $lgas = Lga::select('id', 'name')->pluck('name', 'id')->toArray();
    
//     array_unshift($lgas, "Select");
//    // dd($lgas);
//     $cadre = Staff::select('cadre')->distinct()->pluck('cadre','cadre')->toArray();
//     //array_unshift($cadre, "Select");
//     $qual = Staff::select('qualification')->distinct()->pluck('qualification','qualification')->toArray();
//     //array_unshift($qual, "Select");
//     $rem = Staff::select('remark')->distinct()->pluck('remark','remark')->toArray();
//     //array_unshift($rem, "Select");
//     //dd($cadre);
//     return [
//         'lga' => Filter::make('LGA')
//             ->select($lgas),
//         'qualification' => Filter::make('Qualification')
//             ->select($qual),
//         'cadre' => Filter::make('Cadre')
//             ->select($cadre),
//         'remark' => Filter::make('Remark')
//             ->select($rem),
//         'gender' => Filter::make('Gender')
//             ->select([
//                 '' => 'Any',
//                 'M' => 'M',
//                 'F' => 'F',
//             ]),
            
//         //  'dor' => Filter::make('Date of Retirement')
//         //     ->date([
//         //         'min' => now()->subYear()->format('Y-m-d'), // Optional
//         //         'max' => now()->format('Y-m-d') // Optional
//         //     ]),
//             'fdor' => Filter::make('Retired from')
//                 ->date([
                   
//                 ]),
//             'tdor' => Filter::make('Retired to')
//                 ->date([
                    
//                 ]),
         
//     ];
// }

// public function exportSelected()
//     {
//         //dd($this->selectedRowsQuery->groupBy('lga_id')->pluck('lga_id'));
//         if ($this->selectedRowsQuery->count() > 0) {
//             return (Excel::download(new SelectedStaffExport($this->selectedRowsQuery), $this->tableName.'.xlsx'));
//         }

//     }

// public function exportAllLga()
//     {
        
//         return (Excel::download(new LGAStaffExport(), $this->tableName.'.xlsx'));

//     }

//     public function exportSelectedLga()
//     {
//         //test
//     }

//     public function payrollModal()
//     {
//         $this->emit('selectMonth', 1);
//     }

//     public function payrollModalR()
//     {
//         $this->emit('selectMonth', 2);
//     }

//     // public function payroll()
//     // {
//     //    $this->emit()
//     // }
    
//     public function staffAlertListener()
//     {
//         $this->dispatchBrowserEvent('swal', ['title' => 'hello from Livewire']);
//     }

//     public function edit($id)
//     {
//         $this->emit('staffEdit', $id);
//     }

//     public function delete($id)
//     {
//         $this->dispatchBrowserEvent('swal_del');
//     }

//     // public function rowView(): string
//     // {
//     //     return 'livewire-tables.rows.staff_table';
//     // }
}

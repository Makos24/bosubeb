<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Salary;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class SalaryTable extends DataTableComponent
{
    public $listeners = [
        "salaryAlertFunction" => 'salaryAlertListener',
   ];

   public array $filterNames = [
    'percent' => 'Salary Percent',
    'grade' => 'Grade Level',
    'step' => 'Step',
];

    public function columns(): array
    {
        return [
            Column::make("Salary Percent", "percent")
                ->sortable(),
            Column::make("Grade Level", "grade")
                ->sortable(),
            Column::make("Step", "step")
                ->sortable(),
            Column::make("Basic", "basic")
                ->sortable(),
            Column::make("Rent", "rent")
                ->sortable(),
            Column::make("Transport", "transport")
                ->sortable(),
            Column::make("Meals", "meals")
                ->sortable(),
            Column::make("Entertainment", "ent")
                ->sortable(),
            Column::make("Domestic Staff", "domestic_staff")
                ->sortable(),
            Column::make("Leave Grant", "lgt")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable(),
        ];
    }

    public function query(): Builder
    {
        return Salary::query()
        ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
        ->when($this->getFilter('percent'), fn ($query, $percent) => $query->where('percent', $percent))
        ->when($this->getFilter('grade'), fn ($query, $grade) => $query->where('grade', $grade))
        ->when($this->getFilter('step'), fn ($query, $step) => $query->where('step', $step))
        ;
    }

    public function filters(): array
    {
        
        //dd($lgas);
        $grades = array_combine(range(1,17),range(1,17));
        return [
            'percent' => Filter::make('Salary Percent')
            ->select([
                "" => "Any",
                "0" => "0",
                "20" => "20",
                "35" => "35",
                "40" => "40",
                "60" => "60",
            ]),
            'grade' => Filter::make('Grade Level')
            ->select($grades),
            'step' => Filter::make('Salary Percent')
            ->select($grades),
        ];
    }

    public function salaryAlertListener()
    {
        $this->dispatchBrowserEvent('swal');
    }

    public function delete($id)
    {
        $this->dispatchBrowserEvent('swal_del');
    }
}

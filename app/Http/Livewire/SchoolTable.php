<?php

namespace App\Http\Livewire;

use App\Models\Lga;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\School;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class SchoolTable extends DataTableComponent
{

    public $listeners = [
        "schoolAlertFunction" => 'schoolAlertListener',
   ];
   public array $filterNames = [
    'lga' => 'LGA',
];

   public $test;

    public function columns(): array
    {
        return [
            Column::make("School Name", "name")
                ->sortable(),
            Column::make("LGA", "lga.name")
            ->sortable(function(Builder $query, $direction) {
                return $query->orderBy(Lga::select('name')->whereColumn('lgas.id', 'schools.lga_id'), $direction);
            }),
                Column::make("Actions")
                ->format(function($value, $column, $row){
                  return view('partials.action', ['data' => $row]);
                }),
        ];
    }

    public function query(): Builder
    {
        return School::latest()
        ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
        ->when($this->getFilter('lga'), fn ($query, $lga) => $query->where('lga_id', $lga));
    }

    public function filters(): array
    {
        $lgas = Lga::select('id', 'name')->pluck('name', 'id')->toArray();
        //dd($lgas);
        return [
            'lga' => Filter::make('LGA')
                ->select($lgas)
        ];
    }

    public function schoolAlertListener()
    {
        $this->dispatchBrowserEvent('swal');
    }

    public function edit($id)
    {
        $this->emit('schoolEdit', $id);
    }

    public function delete($id)
    {
        $this->dispatchBrowserEvent('swal_del');
    }

}

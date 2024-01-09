<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Lga;

class LgaTable extends DataTableComponent
{

    public $listeners = [
        "lgaAlertFunction" => 'lgaAlertListener',
   ];

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Lga code", "lga_code")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
                Column::make("Salary Percent", "salary_percent")
                ->sortable(),
            Column::make("Actions")
            ->format(function($value, $column, $row){
                return view('partials.action', ['data' => $row]);
            }),
        ];
    }

    public function query(): Builder
    {
        return Lga::query()
        ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    
    public function edit($id)
    {
        $this->emit('lgaEdit', $id);
    }

    public function delete($id)
    {
        $this->dispatchBrowserEvent('swal_del');
    }

    public function lgaAlertListener()
    {
        $this->dispatchBrowserEvent('swal');
    }

}

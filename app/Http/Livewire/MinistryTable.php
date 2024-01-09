<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ministry;

class MinistryTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Accronymn", "accronymn")
                ->sortable(),
            Column::make("Actions")
            ->format(function($value, $column, $row){
                return view('partials.action', ['data' => $row]);
            }),
        ];
    }

    public function query(): Builder
    {
        return Ministry::query();
    }
}

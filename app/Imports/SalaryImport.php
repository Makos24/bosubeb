<?php

namespace App\Imports;

use App\Models\Salary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalaryImport implements ToModel,WithHeadingRow
{
    use Importable;
    protected $percent;

    public function __construct($percent)
    {
        $this->percent = $percent;
    }
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        
        //dd($row);

        return Salary::firstOrNew([
            'percent' => $this->percent,
            'grade' => $row['gl'],
            'step' => $row['step'],
        ],
        [
            'basic' => $row['basic'],
            'rent' => $row['rent'],
            'transport' => $row['trans'],
            'utility' => $row['utility'],
            'meals' => $row['meals'],
            'ltg' => $row['ltg'],
            'ent' => $row['ent'],
            'domestic_staff' => $row['dstaff'],
            'total' => $row['total'],
        ]);
    }
}

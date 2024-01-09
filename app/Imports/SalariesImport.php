<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalariesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [
            'sixty' => new SalaryImport(60),
            'zero' => new SalaryImport(0),
            'thirty_five' => new SalaryImport(35),
            'fourty' => new SalaryImport(40),
        ];

        //dd($sheets);

        return $sheets;
    }
}

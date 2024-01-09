<?php

namespace App\Imports;

use App\Models\Lga;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SchoolsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = array();

        foreach(Lga::all() as $lga){
            $sheets[strtoupper($lga->name)] = new SchoolImport($lga->id);
        }

        //dd($sheets);

        return $sheets;
    }
}

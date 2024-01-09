<?php

namespace App\Imports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolImport implements ToModel
{
    protected $lga;

    public function __construct($lga)
    {
        $this->lga = $lga;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row);

        return new School([
            'name' => $row[0],
            'lga_id' => $this->lga,
        ]);
    }
}

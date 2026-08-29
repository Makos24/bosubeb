<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllStaffExport implements FromCollection
{
    public function collection()
    {
        return Staff::with(['lga', 'school', 'bank'])->get();
    }
}

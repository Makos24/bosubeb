<?php

namespace App\Exports;

use App\Models\Lga;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LGAStaffExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        foreach (Lga::all() as $lga) {
            $staff = Staff::with('school')->where('lga_id', $lga->id)->get();

            if ($staff->isNotEmpty()) {
                $sheets[] = new StaffExport($lga->name, $staff);
            }
        }

        return $sheets;
    }
}

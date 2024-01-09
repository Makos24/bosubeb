<?php

namespace App\Exports;

use App\Models\Lga;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LGAStaffExport implements WithMultipleSheets
{
    
    use Exportable;
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $staff =  Staff::with('school');

        $data = $staff->get();

        $lgas = $staff->groupBy('lga_id')->pluck('lga_id');

        //dd($data);
        
        foreach (Lga::findMany($lgas) as $lga) {
            $sheets[] = new StaffExport($lga->name, $data->where('lga_id', $lga->id));
        }

        return $sheets;
    }
}

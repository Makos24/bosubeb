<?php

namespace App\Exports;

use App\Models\Lga;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SelectedStaffExport implements WithMultipleSheets
{
    use Exportable;

    protected $lgas, $staff;
    
    public function __construct($query)
    {
        $this->staff = $query->with('school')->get();
        $this->lgas = Lga::findMany($query->groupBy('lga_id')->pluck('lga_id'));
    }


    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->lgas as $lga) {
            $sheets[] = new StaffExport($lga->name, $this->staff->where('lga_id', $lga->id));
        }

        return $sheets;
    }
}

<?php

namespace App\Http\Livewire;

use App\Exports\LGAPayrollExport;
use App\Models\Lga;
use App\Models\Staff;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class LgaPayRoll extends Component
{
    public function render()
    {
        $payrolls =  Staff::with(["lga", "school"])->get()->groupBy('school_id');
        $lgas = Lga::where('state_id', 8)->get();
        return view('livewire.lga-pay-roll', compact('payrolls', 'lgas'));
    }

    public function downloadSummary()
    {
        $payroll =  Staff::with(["lga", "school"])->get()->groupBy('school_id');
                    //dd($payroll);
        return Excel::download(new LGAPayrollExport("Summary", $payroll), 'allstaff.xlsx');
    }
}

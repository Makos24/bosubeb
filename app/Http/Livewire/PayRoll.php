<?php

namespace App\Http\Livewire;

use App\Exports\PayrollExport;
use App\Models\Lga;
use App\Models\Staff;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PayRoll extends Component
{
    public function render()
    {
        $payrolls =  Staff::with(["lga", "school"])->get()->groupBy('lga_id');
        $lgas = Lga::where('state_id', 8)->get();
        
        return view('livewire.pay-roll', compact('payrolls','lgas'));
    }

    public function downloadSummary()
    {
        $payroll =  Staff::with(["lga", "school"])->get()->groupBy('lga_id');
                    //dd($payroll);
        return Excel::download(new PayrollExport("Summary", $payroll), 'allstaff.xlsx');
    }
}

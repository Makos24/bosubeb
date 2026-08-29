<?php

namespace App\Http\Livewire;

use App\Exports\PayrollSummaryExport;
use App\Models\Lga;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PayRoll extends Component
{
    use WithPagination;

    public function render()
    {
        $lgas = Lga::where('state_id', config('app.state_id'))->paginate(20);
        $lga_ids = $lgas->pluck('id');

        $payrolls = Staff::with(['lga', 'school', 'salary_data'])
            ->where('expected_date_of_retirement', '>=', Carbon::today())
            ->whereIn('lga_id', $lga_ids)
            ->get()
            ->groupBy('lga_id');

        return view('livewire.pay-roll', compact('payrolls', 'lgas'));
    }

    public function downloadSummary()
    {
        $payroll = Staff::with(['lga', 'school'])->get()->groupBy('lga_id');

        return Excel::download(new PayrollSummaryExport("Summary", $payroll), Carbon::today().'PayrollSummary.xlsx');
    }
}

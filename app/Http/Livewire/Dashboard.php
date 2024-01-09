<?php

namespace App\Http\Livewire;

use App\Exports\SummaryExport;
use App\Models\Agency;
use App\Models\Lga;
use App\Models\Ministry;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    use WithPagination;

    public $ministry, $agency, $lga;

    public function render()
    {
        $data = Staff::when($this->ministry, function($query, $ministry){
            return $query->where('cadre', $ministry);
        })->when($this->agency, function($query, $agency){
            return $query->where('remark', $agency);
        })->when($this->lga, function($query, $lga){
            return $query->where('lga_id', $lga);
        });

        $staff_all = clone $data;
        $staff_retired = clone $data;
        $staff_lga = clone $data;
        $staff_q = clone $data;
        $staff_t = clone $data;
        $staff_nq = clone $data;
        $staff_salary = clone $data;
        $staff_school = clone $data;
        $lga_page = Lga::where('state_id', 8)->paginate();

       

        return view('livewire.dashboard', [
            'staff' => $data,
            'all' => $staff_all,
            'retired' => $staff_retired,
            'q' => $staff_q,
            't' => $staff_t,
            'nq' => $staff_nq,
            'lg' => $staff_lga->get()->groupBy('lga_id'),
            'salary' => $staff_salary,
            'school' => $staff_school,
            'lga_page' => $lga_page,
            'ministries' => $data->select('cadre')->distinct()->get(),
            'agencies' => $data->select('cadre')->distinct()->get(),
            'lgas' => Lga::where('state_id', 8)->get()
        ]);
    }

    public function clearFilters()
    {
        $this->ministry = '';
        $this->agency = '';
        $this->lga = '';
    }

    public function downloadSummary()
    {
        $staff = Staff::query();
        $data = $staff->get()->groupBy('lga_id');
        $lgas = Lga::all();
        //dd($staff->count());
        return (Excel::download(new SummaryExport($data, $lgas, $staff), Carbon::today().'Summary.xlsx'));
    }

    
}

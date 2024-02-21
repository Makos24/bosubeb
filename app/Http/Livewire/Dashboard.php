<?php

namespace App\Http\Livewire;

use App\Exports\SummaryExport;
use App\Models\Agency;
use App\Models\Lga;
use App\Models\Ministry;
use App\Models\agency_id;
use App\Models\Category;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    use WithPagination;

    public $category_id, $agency_id, $lga;

    public function render()
    {
        $data = Staff::query()
    ->when($this->category_id, function ($query, $category_id) {
        return $query->where('category_id', $category_id);
    })
    ->when($this->agency_id, function ($query, $agency_id) {
        return $query->where('agency_id', $agency_id);
    })
    ->when($this->lga, function ($query, $lga) {
        return $query->where('lga_id', $lga);
    });


        $staff_all = clone $data;
        
        $students = clone $data;
        $staff_lga = clone $data;
        $late = clone $data;
        $senior = clone $data;
        $pensions = clone $data;
        $staff_nq = clone $data;
        $staff_salary = clone $data;
        $staff_school = clone $data;
        $lga_page = Lga::where('state_id', 8)->paginate();

    //    dd($pensions->pensioners()->get());

        return view('livewire.dashboard', [
            'staff' => $staff_all->notStudent()->notDead()->notSenior()->notPensioners(),
            'all' => $staff_lga,
            'students' => $students->student(),
            'late' => $late->dead(),
            'pensions' => $pensions->pensioners(),
            'senior' => $senior->senior(),
            'nq' => $staff_nq,
            'lg' => $staff_lga->get()->groupBy('lga_id'),
            'salary' => $staff_salary,
            'school' => $staff_school,
            'lga_page' => $lga_page,
            'categories' => Category::get(),
            'agencies' => Agency::get(),
            'lgas' => Lga::where('state_id', 8)->get()
        ]);
    }

    public function clearFilters()
    {
        $this->agency_id = '';
        $this->category_id = '';
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

<?php

namespace App\Http\Livewire;

use App\Exports\SummaryExport;
use App\Models\Agency;
use App\Models\Category;
use App\Models\Lga;
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
        $base = Staff::query()
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->when($this->agency_id, fn($q) => $q->where('agency_id', $this->agency_id))
            ->when($this->lga, fn($q) => $q->where('lga_id', $this->lga));

        $lga_page = Lga::where('state_id', config('app.state_id'))->paginate();

        return view('livewire.dashboard', [
            'staff'    => (clone $base)->notStudent()->notDead()->notSenior()->notPensioners(),
            'all'      => clone $base,
            'students' => (clone $base)->student(),
            'late'     => (clone $base)->dead(),
            'pensions' => (clone $base)->pensioners(),
            'senior'   => (clone $base)->senior(),
            'nq'       => clone $base,
            'lg'       => $base,
            'salary'   => clone $base,
            'school'   => clone $base,
            'lga_page' => $lga_page,
            'categories' => Category::get(),
            'agencies' => Agency::get(),
            'lgas' => Lga::where('state_id', config('app.state_id'))->get(),
        ]);
    }

    public function clearFilters(): void
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

        return Excel::download(new SummaryExport($data, $lgas, $staff), Carbon::today().'Summary.xlsx');
    }
}


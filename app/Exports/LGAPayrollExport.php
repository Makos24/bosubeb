<?php

namespace App\Exports;

use App\Models\Lga;
use App\Models\Payroll;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class LGAPayrollExport implements FromView, WithTitle
{
    use Exportable;

    protected $name, $payroll;
    
    // public function __construct($month, $year, $type)
    // {
    //     $this->month = $month;
    //     $this->year = $year;
    //     $this->type = $type;
    // }

    public function __construct($name, $payroll)
    {
        $this->name = $name;
        $this->payroll = $payroll;
    }

    public function view(): View
    {
        return view('exports.lga-payroll', [
            'payrolls' => $this->payroll
        ]);
    }

    public function title(): string
    {
        return $this->name;
    }


    /**
     * @return array
     */
    // public function sheets(): array
    // {
    //     $sheets = [];

    //     // $payrolls =  Payroll::with('staff');

    //     // $data = $payrolls->get();

    //     //$lgas = $staff->groupBy('lga_id')->pluck('lga_id');

    //     //dd($data);
        
    //     foreach (Lga::all() as $lga) {
    //         //dd(Payroll::where('month', $this->month)->where('year', $this->year)->whereRelation('staff', 'lga_id', '=', $lga->id)->get());
    //         $sheets[] = new PayrollExport($lga->name, Payroll::where('month', $this->month)->where('year', $this->year)
    //         ->where('type', $this->type)
    //         ->whereRelation('staff', 'lga_id', '=', $lga->id)->get());
    //     }

    //     //dd($sheets);
    //     return $sheets;
    // }
}

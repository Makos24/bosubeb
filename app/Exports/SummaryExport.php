<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryExport implements FromView
{
    protected $data, $lgas, $staff;

    public function __construct($data, $lgas, $staff)
    {
        $this->data = $data;
        $this->lgas = $lgas;
        $this->staff = $staff;
    }

    public function view(): View
    {
        return view('exports.summary', ['lg' => $this->data, 'lgas' => $this->lgas, 'staff' => $this->staff]);
    }
}

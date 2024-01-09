<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PayrollExport implements FromView, WithTitle
{
    protected $name, $payroll;
    
    public function __construct($name, $payroll)
    {
        $this->name = $name;
        $this->payroll = $payroll;
    }

    public function view(): View
    {
        return view('exports.payroll', [
            'payrolls' => $this->payroll
        ]);
    }

    public function title(): string
    {
        return $this->name;
    }
}

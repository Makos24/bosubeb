<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportPaymentSchedule implements FromView, WithTitle
{
    protected $name, $payment;
    
    public function __construct($name, $payment)
    {
        $this->name = $name;
        $this->payment = $payment;
    }

    public function view(): View
    {
        return view('exports.payment', [
            'payments' => $this->payment
        ]);
    }

    public function title(): string
    {
        return $this->name;
    }
}

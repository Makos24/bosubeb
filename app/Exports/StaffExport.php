<?php

namespace App\Exports;

use App\Models\Staff;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class StaffExport implements FromView, WithTitle
{

    protected $name, $staff;
    
    public function __construct($name, $staff)
    {
        $this->name = $name;
        $this->staff = $staff;
    }

    public function view(): View
    {
        return view('exports.staff', [
            'staffs' => $this->staff
        ]);
    }

    public function title(): string
    {
        return $this->name;
    }
}

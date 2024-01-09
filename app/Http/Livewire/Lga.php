<?php

namespace App\Http\Livewire;

use App\Models\Lga as ModelsLga;
use App\Models\Salary;
use Livewire\Component;

class Lga extends Component
{

    public $modalFormVisible = false;
    
    public $lgaId, $percent;

    protected $rules =[
        'percent' => 'required', 
    ];

    public $listeners = [
         //"alertFunction" => 'alertListener',
         "lgaEdit" => 'edit',
    ];

    public function render()
    {
        return view('livewire.lga', [
            'percents' => Salary::distinct()->pluck('percent')
        ]);
    }

    public function edit($id)
    {
        $this->lgaId = $id;
        $this->modalFormVisible = true;
        
    }

    public function update()
    {
        $this->validate();
        ModelsLga::find($this->lgaId)->update(['salary_percent' => $this->percent]);

        $this->modalFormVisible = false;

        $this->percent = '';

        $this->emit('lgaAlertFunction');
    }

}

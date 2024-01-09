<?php

namespace App\Http\Livewire;

use App\Imports\SalariesImport;
use App\Imports\SalaryImport;
use App\Models\Salary as ModelsSalary;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Salary extends Component
{
    use WithFileUploads, WithPagination;
    
    public $modalFormVisible = false;
    public $modalUploadVisible = false;
    public ModelsSalary $salary;
    public $excelFile, $iteration = 0, $schoolId, $fail;

    public function mount()
    {
        $this->salary = new ModelsSalary();
       
    }

    public function render()
    {
        return view('livewire.salary');
    }

    public function createFormShow()
    {
        $this->salary = new ModelsSalary();   
        $this->modalFormVisible = true;
    
    }
    
    public function uploadFormShow()
    {
        $this->modalUploadVisible = true;
    }

    public function create()
    {
        $this->validate();

        $this->school->save();

        $this->school = new School();
        
        $this->modalFormVisible = false;

        $this->emit('schoolAlertFunction');
       

    }
    
    public function upload()
    {
        try{
            Excel::import(new SalariesImport, $this->excelFile);
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $this->fail = $e->failures();
            dd($e);
        }catch(\Exception $ex){
            dd($ex);
        }

        $this->excelFile = null;
        $this->iteration++;

        $this->modalUploadVisible = false;

        $this->emit('salaryAlertFunction');

        //$this->dispatchBrowserEvent('swal', ['title' => 'hello from Livewire']);

    }

    public function edit($id)
    {
        $this->salary = ModelsSalary::find($id);
        $this->salaryId = $this->salary->id;
        $this->modalFormVisible = true;
        
    }

    public function update()
    {
        if($this->salary->isDirty()){
            $this->validate();
            ModelsSalary::find($this->salaryId)->update($this->salary->getDirty());
        }

        $this->modalFormVisible = false;

        $this->emit('salaryAlertFunction');
    }

}

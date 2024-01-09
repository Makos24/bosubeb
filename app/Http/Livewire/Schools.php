<?php

namespace App\Http\Livewire;

use App\Imports\SchoolsImport;
use App\Models\Lga;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\School;
use App\Models\Staff;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Schools extends Component
{

    use WithFileUploads, WithPagination;
    
    public $modalFormVisible = false;
    public $modalUploadVisible = false;
    public School $school;
    public $excelFile, $iteration = 0, $schoolId;

    protected $rules =[
        'school.name' => 'required', 
        'school.lga_id' => 'required', 
    ];

    public $listeners = [
         //"alertFunction" => 'alertListener',
         "schoolEdit" => 'edit',
    ];

    public function mount()
    {
        $this->school = new School();
       
    }

    public function render()
    {
        return view('livewire.schools', [
            'data' => $this->read(),
            'lgas' => Lga::all()
        ]);
    }

    public function createFormShow()
    {
        $this->school = new School();   
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

    public function read()
    {
        return School::paginate(10);
    }

    public function upload()
    {
        // $this->file->validate([
        //     'file' => 'required|', // 1MB Max
        // ]);

        //dd($this->excelFile);

        Excel::import(new SchoolsImport, $this->excelFile);

        $this->excelFile = null;
        $this->iteration++;

        $this->modalUploadVisible = false;

        $this->emit('schoolAlertFunction');

        //$this->dispatchBrowserEvent('swal', ['title' => 'hello from Livewire']);

    }

    public function edit($id)
    {
        $this->school = School::find($id);
        $this->schoolId = $this->school->id;
        $this->modalFormVisible = true;
        
    }

    public function update()
    {
        if($this->school->isDirty()){
            $this->validate();
            School::find($this->schoolId)->update($this->school->getDirty());
        }

        $this->modalFormVisible = false;

        $this->emit('schoolAlertFunction');
    }
    
   
}

<?php

namespace App\Http\Livewire;

use App\Exports\LGAPayrollExport;
use App\Imports\SchoolsImport;
use App\Imports\StaffImport;
use App\Models\Lga;
use App\Models\Payroll;
use App\Models\School;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Staff as ModelsStaff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithFileUploads, WithPagination;
    
    public $modalFormVisible = false;
    public $modalUploadVisible = false;
    public $modalMonthVisible = false;
    public ModelsStaff $staff;
    public $excelFile, $iteration = 0, $lgas, $schools, $lga_id, $data, $staffId, $fail,$type;
    public $month = 1;
    public $year = 2022;
    public $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');

    public $listeners = [
        "staffEdit" => "edit",
        "selectMonth" => "payrollModal",
    ];

    protected $rules = [
        'staff.firstname' => 'required|string', 
        'staff.surname' => 'required|string', 
        'staff.othername' => 'nullable|string', 
        'staff.gender' => 'nullable|string', 
        'staff.email' => 'nullable|string', 
        'staff.phone' => 'required|string', 
        'staff.lga_id' => 'required|string', 
        'staff.nin' => 'nullable|string', 
        'staff.school_id' => 'required|string', 
        'staff.qualification' => 'required|string', 
        'staff.status' => 'required|string', 
        'staff.dob' => 'required|string', 
        'staff.dofa' => 'required|string', 
        'staff.cadre' => 'required|string', 
        'staff.grade' => 'required|string', 
        'staff.step' => 'required|string', 
        'staff.salary_grade' => 'required|string', 
        'staff.salary_step' => 'required|string', 
        'staff.bvn' => 'required|string', 
        'staff.bank' => 'required|string', 
        'staff.account_name' => 'required|string', 
        'staff.account_number' => 'required|string', 
        'staff.address' => 'required|string', 
        'staff.remark' => 'required', 
        'staff.nok_name' => 'required|string', 
        'staff.nok_number' => 'required|string', 
        'staff.nok_address' => 'required|string', 
        'staff.nok_relationship' => 'required|string', 
    ];

    public function render()
    {
        $this->lgas = Lga::all();
        if(!is_null($this->staff->lga_id)){
            $this->schools = School::where('lga_id', $this->staff->lga_id)->get();
        }

        return view('livewire.staff');
    }

    public function mount()
    {
        $this->staff = new ModelsStaff();
        $this->data = config('data');
        $this->schools = collect();
    }

    public function createFormShow()
    {
        $this->staff = new ModelsStaff();
        $this->modalFormVisible = true;
    
    }
    
    public function uploadFormShow()
    {
        $this->modalUploadVisible = true;
    }

    public function create()
    {
        $this->validate();
        $this->staff->fileno = $this->staff->lga_id."/".$this->staff->school_id."/".rand();
        $this->staff->dor = Carbon::parse($this->staff->dofa)->addYears(35) > Carbon::parse($this->staff->dob)->addYears(60) ? Carbon::parse($this->staff->dob)->addYears(60) : Carbon::parse($this->staff->dofa)->addYears(35);

        $this->staff->save();
        $this->staff = new ModelsStaff();
       
        $this->modalUploadVisible = false;

        $this->emit('staffAlertFunction');
    }

    public function edit($id)
    {
        $this->staff = ModelsStaff::find($id);
        $this->staffId = $this->staff->id;
        $this->modalFormVisible = true;
       
    }

    public function update()
    {
        if($this->staff->isDirty()){
            $this->validate();
            ModelsStaff::find($this->staffId)->update($this->staff->getDirty());
        }

        $this->emit('staffAlertFunction');

    }

    public function read()
    {
        return ModelsStaff::paginate(10);
    }

    public function upload()
    {
        try{
            Excel::import(new StaffImport, $this->excelFile);
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $this->fail = $e->failures();
            dd($e);
        }catch(\Exception $ex){
            dd($ex);
        }

        $this->excelFile = null;

        $this->iteration++;

        $this->modalUploadVisible = false;
       // $this->emit('uploadAlertFunction');

       $this->emit('staffAlertFunction');

    }

    public function payrollModal($type)
    {
        $this->modalMonthVisible = true;
        $this->type = $type;
    }

    public function payrollDownload()
    {
        if(Payroll::where('month', $this->month)->where('year', $this->year)->count() < ModelsStaff::get()->count()){
            //$exitCode = Artisan::call('command:payrolls', [$this->month]);
            //dd(Staff::all());
            foreach(ModelsStaff::all() as $data){
                //dd($data);
                //if(!$data->payroll()->where('year', date('Y'))->where('month', date('n'))){
                     $data->payroll()->firstOrCreate([
                    'month' => $this->month,
                    'year' => $this->year,
                     ],
                     [
                    'current_salary' => $data->net_salary,
                    'grade_salary' => $data->salary_data() ? $data->salary_data()->total : $data->net_salary,
                    'difference' => $data->salary_data() ? $data->salary_data()->total - $data->net_salary : 0,
                    'type' => Carbon::parse($data->dor)->gte(now()) ? 2 : 1,
                    
                ]);
                //}
            
            }

            //dd($exitCode);
        }

        $this->modalMonthVisible = false;
        
        return (Excel::download(new LGAPayrollExport($this->month, $this->year, $this->type), 'Payroll.xlsx'));
        
    }

}

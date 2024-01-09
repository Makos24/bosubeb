<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Cadre;
use App\Models\DutyStation;
use App\Models\LGA;
use App\Models\School;
use App\Models\Staff;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StaffImport implements ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithChunkReading
    
{
    use Importable, SkipsErrors, SkipsFailures;
   
    public function collection(Collection $rows)
    {
        //dd($rows[0]);
        foreach ($rows as $row) 
        {
            //dd($row);
            $lga_id = LGA::where('name', $row['lga'])->first() ? Lga::where('name', $row['lga'])->first()->id : '';

        $school_id = School::firstOrCreate([
                'name' => $row['school'],
                'lga_id' => $lga_id
            ]
        )->id;
        
            Staff::updateOrCreate(
                [
                    'form_no' =>  $row['form_no']
                ],
                [
                    'first_name' => $row['first_name'], 
                    'last_name' => $row['surname'], 
                    'middle_name' => $row['other_name'], 
                    'name' => $row['first_name'].' '.$row['other_name'].' '.$row['surname'],
                    'duty_station' => DutyStation::firstOrCreate(['name' => $row['duty_station_lga'], 'lga_id' => $lga_id])->id, 
                    'minimum_wage' => $row['minimum_wage'], 
                    'gender_id' => $row['gender'] == "MALE" ? 1 : 2, 
                    'marital_status_id' => $row['marital_status'] == "Single" ? 1 : 2,
                    'date_of_birth' => $this->transformDate($row['date_of_birth']),
                    'qualification' => $row['qualification'],  
                    'phone' => $row['phone_no'],  
                    'nin' => $row['nin_no'],  
                    'lga_of_origin_id' => LGA::where('name', $row['lga_of_origin'])->first()->id,  
                    'state_id' => State::where('name', $row['state_of_origin'])->first()->id,  
                    'blood_group' => $row['blood_group'],  
                    'status' => $row['status'],  
                    'cadre' => Cadre::firstOrCreate(['name' => $row['cadrerank']])->id,  
                    'salary_id' => 1,  
                    // 'salary_id' => $row['salary_structure_based_on'],  
                    'grade_level' => $row['present_grade_levelhighest_promotion'],  
                    'salary_grade_level' => $row['grade_level_of_your_salary'],  
                    'gross_salary' => str_replace(["'",","],"",$row['present_gross_salary']),  
                    'net_salary' => str_replace(["'",","],"",$row['present_net_salary']),  
                    'bank_id' => Bank::firstOrCreate(['name' => $row['bank_name']])->id,  
                    'account_name' => $row['account_name'],  
                    'account_number' => $row['account_no'],  
                    'bvn' => $row['bvn_no'],  
                    'address' => $row['your_home_address'],  
                    'email' => $row['email_address'],  
                    'next_of_kin_name' => $row['next_of_kin_name'], 
                    'next_of_kin_phone' => $row['nextof_kin_no'], 
                    'next_of_kin_address' => $row['next_of_kin_address'], 
                    'next_of_kin_relationship' => $row['relationship_with_next_of_kin'], 
                    'lga_id' => $lga_id, 
                    'school_id' => $school_id,
                    // 'date_of_appointment' => $row['date_of_1st_appointment'], 
                    // 'date_of_last_promotion' => $row['date_of_last_promotion'], 
                    // 'expected_date_of_retirement' => $row['expected_date_of_retirement'], 
                    'date_of_appointment' => $this->transformDate($row['date_of_1st_appointment']),
                    'date_of_last_promotion' => $this->transformDate($row['date_of_last_promotion']),
                    'expected_date_of_retirement' => $this->transformDate($row['expected_date_of_retirement']),
                    // 'date_of_appointment' => Date::excelToDateTimeObject($row['date_of_1st_appointment']), 
                    // 'date_of_last_promotion' => Date::excelToDateTimeObject($row['date_of_last_promotion']), 
                    // 'expected_date_of_retirement' => Date::excelToDateTimeObject($row['expected_date_of_retirement']), 
                    
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.email_address' => ['nullable','email', 'unique:staff,email'],
            '*.form_no' => ['required', 'unique:staff,form_no'],
            '*.bvn_no' => ['required', 'unique:staff,bvn'],
            '*.nin_no' => ['required', 'unique:staff,nin'],
            'date_of_1st_appointment' => ['required'],
            'date_of_last_promotion' => ['required'],
            'expected_date_of_retirement' => ['required'],
            'date_of_birth' => ['required'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function transformDate($value, $format = 'd/m/Y')
{
    try {
        return is_numeric($value) ? Carbon::instance(Date::excelToDateTimeObject($value)) : Carbon::createFromFormat($format, $value);
    } catch (\ErrorException $e) {
        dd($e);
        return Carbon::createFromFormat($format, $value);
    }
}

    // public function onFailure(Failure ...$failure)
    // {
    // }
}

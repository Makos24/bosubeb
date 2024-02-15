<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Cadre;
use App\Models\Certificate;
use App\Models\DutyStation;
use App\Models\Lga;
use App\Models\Promotion;
use App\Models\School;
use App\Models\Staff;
use App\Models\State;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
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

    protected $category_id;

    public function  __construct($category_id)
    {
        $this->category_id = $category_id;
    }
   
    public function collection(Collection $rows)
    {
        //dd($rows);
        foreach ($rows as $row) 
        {
            //dd($row);
            $nin = $row['nin_no'];
            // if ($this->isDuplicateNIN($nin) || $row['account_no'] == "0000000000") {
            if ($row['account_no'] == "0000000000") {
                continue;
            }
            // dd($row);
            $lga_id = Lga::where('name', ucwords(strtolower($row['lga'])))->orWhere('id', $row['lga'])->first() ? Lga::where('name', ucwords(strtolower($row['lga'])))->orWhere('id', $row['lga'])->first()->id : null;
            
            // $bank_id = Bank::where('name', $row['bank_name'])
            //                 ->orWhere('other_name', $row['bank_name'])
            //                 ->orWhere('bank_code', $row['bank_name'])
            //                 ->orWhere('sort_code', $row['bank_name'])->first() ? Bank::where('name', $row['bank_name'])
            //                                                                     ->orWhere('other_name', $row['bank_name'])
            //                                                                     ->orWhere('other_name', $row['bank_name'])
            //                                                                     ->orWhere('bank_code', $row['bank_name'])
            //                                                                     ->orWhere('sort_code', $row['bank_name'])->first()->id : '';
            // if(strlen($row['school']) > 3){
            // $school_id = School::firstOrCreate([
            //         'name' => $row['school'],
            //         'lga_id' => $lga_id
            //     ]
            // )->id;
            // }
            $staff = Staff::firstOrCreate(
                [
                    'form_no' =>  $row['form_no']
                ],
                [
                    'category_id' => $this->category_id,
                    'agency_id' => $row['agency'],
                    'first_name' => $row['first_name'], 
                    'last_name' => $row['surname'], 
                    'middle_name' => $row['other_name'], 
                    'name' => $row['first_name'].' '.$row['other_name'].' '.$row['surname'],
                    //'duty_station' => DutyStation::firstOrCreate(['name' => $row['duty_station_lga'], 'lga_id' => $lga_id])->id, 
                    //'minimum_wage' => $row['minimum_wage'], 
                    //'gender_id' => $row['gender'] == "MALE" ? 1 : 2, 
                    //'marital_status_id' => $row['marital_status'] == "Single" ? 1 : 2,
                    //'date_of_birth' => $this->transformDate($row['date_of_birth']),
                    //'qualification' => $row['qualification'],  
                    //'phone' => $row['phone_no'],  
                    //'nin' => $row['nin_no'],  
                    //'lga_of_origin_id' => isset(LGA::where('name', ucwords(strtolower($row['lga_of_origin'])))->first()->id) ? : null,  
                    //'state_id' => State::where('name', ucwords(strtolower($row['state_of_origin'])))->first() ? State::where('name', ucwords(strtolower($row['state_of_origin'])))->first()->id : null,  
                    //'blood_group' => $row['blood_group'],  
                    //'status' => $row['status'],  
                    //'cadre' => Cadre::firstOrCreate(['name' => $row['cadrerank']])->id,  
                    //'salary_id' => 1,  
                    //'salary_structure' => is_numeric($row['salary_structure_based_on']) && $row['salary_structure_based_on'] < 1 ? round((float)$row['salary_structure_based_on']*100).'%' : $row['salary_structure_based_on'],  
                    'salary_structure' => $row['salary_structure_based_on'],  
                    'salary_grade' => explode("/", $row['grade_level_of_your_salary'])[0],  
                    'salary_step' => explode("/", $row['grade_level_of_your_salary'])[1],  
                    'grade_level' => $row['present_grade_levelhighest_promotion'],  
                    'salary_grade_level' => $row['grade_level_of_your_salary'],  
                    'gross_salary' => to_num($row['present_gross_salary']),  
                    'net_salary' => to_num($row['present_net_salary']),  
                    'bank_id' => $row['bank_name'],  
                    //'account_name' => $row['account_name'],  
                    'account_number' => $row['account_no'],  
                    //'bvn' => $row['bvn_no'],  
                    //'address' => $row['your_home_address'],  
                    //'email' => $row['email_address'],  
                    //'next_of_kin_name' => $row['next_of_kin_name'], 
                    //'next_of_kin_phone' => $row['nextof_kin_no'], 
                    //'next_of_kin_address' => $row['next_of_kin_address'], 
                    //'next_of_kin_relationship' => $row['relationship_with_next_of_kin'], 
                    //'lga_id' => $lga_id, 
                    //'school_id' => $school_id,
                    // 'date_of_appointment' => $row['date_of_1st_appointment'], 
                    // 'date_of_last_promotion' => $row['date_of_last_promotion'], 
                    // 'expected_date_of_retirement' => $row['expected_date_of_retirement'], 
                    //'date_of_appointment' => $this->transformDate($row['date_of_1st_appointment']),
                    //'date_of_last_promotion' => $this->transformDate($row['date_of_last_promotion']),
                    //'expected_date_of_retirement' => $this->transformDate($row['expected_date_of_retirement']),
                    // 'date_of_appointment' => Date::excelToDateTimeObject($row['date_of_1st_appointment']), 
                    // 'date_of_last_promotion' => Date::excelToDateTimeObject($row['date_of_last_promotion']), 
                    // 'expected_date_of_retirement' => Date::excelToDateTimeObject($row['expected_date_of_retirement']), 
                    
            ]);

        //     if(strlen($row['primary_school_attended']) > 5){
        //         Certificate::firstOrCreate(
        //             [
        //                 'staff_id' => $staff->id,
        //                 'certificate' => $row['certificate1']
        //             ],
        //             [
        //                 'from' => $row['from1'],
        //                 'to' => $row['to1'],
        //                 'school_attended' => $row['primary_school_attended'],
        //             ]
        //         );
        //     }
            
        //     if(strlen($row['secondary_school_attended']) > 5){
        //         Certificate::firstOrCreate(
        //             [
        //                 'staff_id' => $staff->id,
        //                 'certificate' => $row['certificate2']
        //             ],
        //             [
        //                 'from' => $row['from2'],
        //                 'to' => $row['to2'],
        //                 'school_attended' => $row['secondary_school_attended'],
        //             ]
        //         );

        //     }
        //     if(strlen($row['other_school_attended']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate3']
        //         ],
        //         [
        //             'from' => $row['from3'],
        //             'to' => $row['to3'],
        //             'school_attended' => $row['other_school_attended'],
        //         ]
        //     );
        // }
        // if(strlen($row['college_of_education_attended']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate4']
        //         ],
        //         [
        //             'from' => $row['from4'],
        //             'to' => $row['to4'],
        //             'school_attended' => $row['college_of_education_attended'],
        //         ]
        //     );
        // }
        // if(strlen($row['polytechnic_attended']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate5']
        //         ],
        //         [
        //             'from' => $row['from5'],
        //             'to' => $row['to5'],
        //             'school_attended' => $row['polytechnic_attended'],
        //         ]
        //     );
        // }
        // if(strlen($row['university_attended_first_degree']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate6']
        //         ],
        //         [
        //             'from' => $row['from6'],
        //             'to' => $row['to6'],
        //             'school_attended' => $row['university_attended_first_degree'],
        //         ]
        //     );
        // }
        // if(strlen($row['university_attended_second_degree']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate7']
        //         ],
        //         [
        //             'from' => $row['from7'],
        //             'to' => $row['to7'],
        //             'school_attended' => $row['university_attended_second_degree'],
        //         ]
        //     );
        // }

        // if(strlen($row['university_attended_third_degree']) > 5){
        //     Certificate::firstOrCreate(
        //         [
        //             'staff_id' => $staff->id,
        //             'certificate' => $row['certificate8']
        //         ],
        //         [
        //             'from' => $row['from8'],
        //             'to' => $row['to8'],
        //             'school_attended' => $row['university_attended_third_degree'],
        //         ]
        //     );
        // }

        // for($i = 1; $i < 7; $i++){
        //     if(strlen($row['promotions_rank_and_level'.$i]) > 5){
        //         Promotion::firstOrCreate(
        //             [
        //                 'staff_id' => $staff->id,
        //                 'promotion' => $row['promotions_rank_and_level'.$i]
        //             ],
        //             [
        //                 'date' => $this->transformDate($row['dates'.$i]),
                        
        //             ]
        //         );
        //     }
        // }

        }
    }

    public function rules(): array
    {
        return [
            // 'email_address' => ['nullable','email', 'unique:staff,email'],
            // 'form_no' => ['required', 'unique:staff,form_no'],
            // 'bvn_no' => ['nullable', 'unique:staff,bvn'],
            // 'nin_no' => ['nullable', 'unique:staff,nin'],
            // 'date_of_1st_appointment' => ['nullable'],
            // 'date_of_last_promotion' => ['nullable'],
            // 'expected_date_of_retirement' => ['nullable'],
            // 'date_of_birth' => ['nullable'],
        ];
    }

    public function chunkSize(): int
    {
        return 50;
    }

    public function transformDate($value, $format = 'd/m/Y')
{

    try { 
        return Carbon::createFromFormat($format, $value); 
    } catch (InvalidFormatException $e) {
         try { 
            return Carbon::createFromFormat('d/m/Y', $value); 
        } catch (InvalidFormatException $e) { 
            try { 
                return Carbon::createFromFormat('m/d/Y', $value); 
            } catch (InvalidFormatException $e) 
            { 
                // handle the error or return null
                return null;
             } 
            } 
        }
    // try {
    //     return is_numeric($value) ? Carbon::instance(Date::excelToDateTimeObject($value)) : Carbon::createFromFormat($format, $value);
    // } catch (\ErrorException $e) {
    //     //dd($e);
    //     return Carbon::createFromFormat($format, $value);
    // }
}

    public function onFailure(Failure ...$failure)
    {
        
    }

    protected function isDuplicateNIN($nin)
    {
        // Check if the NIN already exists in the staff table
        return Staff::where('nin', $nin)->exists();
    }
    // protected function isDuplicateBVN($nin)
    // {
    //     // Check if the NIN already exists in the staff table
    //     return Staff::where('nin', $nin)->exists();
    // }
}

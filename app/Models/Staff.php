<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $guarded = ['id'];

    protected $casts = [
        'dob', 'dofa', 'dor'
    ];

    public function salaryTwentySeven(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 1 && filter_var($this->qualification, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 10))) ? $this->salary_data->basic*.275 : 0,
            set:null
        );
    }

    public function salaryFifteen(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 1 && !filter_var($this->qualification, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 10))) ? $this->salary_data->basic*.15 : 0,
            set:null
        );
    }

    public function salaryTwelve(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 0 && filter_var($this->qualification, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 10))) ? $this->salary_data->basic*.125 : 0,
            set:null
        );
    }

    public function salaryZero(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 0 && !filter_var($this->qualification, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 10))) ? $this->salary_data->basic*.125 : 0,
            set:null
        );
    }

    public function salaryNut(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 1 ? $this->salary_data->basic * .03 : 0,
            set:null
        );
    }

    public function salaryNulge(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 0 ? $this->salary_data->basic * .03 : 0,
            set:null
        );
    }

    public function AnnualPension(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => Pension::where('years', $this->service_years)->first() ? (Pension::where('years', $this->service_years)->first()->pension/100) * $this->salary_net * 12 : 0,
            set:null
        );
    }

    public function MonthlyPension(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => number_format($this->annual_pension/12, 2),
            set:null
        );
    }

    public function ServiceYears(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => Carbon::parse($this->date_of_appointment)->diffInYears($this->expected_date_of_retirement) >= 35 ? 35 : Carbon::parse($this->date_of_appointment)->diffInYears($this->expected_date_of_retirement),
            set:null
        );
    }

    public function salaryTd(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => number_format($this->salary_nut + $this->salary_nulge + $this->salary_data->paye, 2),
            set:null
        );
    }
    public function salaryNet(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data->gross - to_num($this->salary_td),
            set:null
        );
    }

    public function StaffStatus(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->status == 1 ? "Teacher" : "Non Teacher",
            set:null
        );
    }

    public function Difference(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_net - to_num($this->monthly_pension),
            set:null
        );
    }

    public function getOnameAttribute()
    {
        return " ".$this->othername;
    }

    // public function getNameAttribute()
    // {
    //     return $this->firstname."".$this->oname." ".$this->surname." ";
    // }

    public function lga()
    {
        return $this->belongsTo(Lga::class, 'lga_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    public function duty_stations()
    {
        return $this->belongsTo(DutyStation::class, 'duty_station');
    }

    public function qualifications()
    {
        return $this->belongsTo(Qualification::class, 'qualification');
    }

    public function cadres()
    {
        return $this->belongsTo(Cadre::class, 'qualification');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public function marital_status() {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function certificates(){
        return $this->hasMany(Certificate::class);
    }

    public function payments(){
        return $this->hasMany(PaymentSchedule::class);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) => $query->where('firstname', 'like', '%'.$term.'%')
                ->orWhere('surname', 'like', '%'.$term.'%')
                ->orWhere('othername', 'like', '%'.$term.'%')
                ->orWhere('name', 'like', '%'.$term.'%')
                ->orWhere('email', 'like', '%'.$term.'%')
                ->orWhere('bvn', 'like', '%'.$term.'%')
                ->orWhere('account_number', 'like', '%'.$term.'%')
                ->orWhere('bank', 'like', '%'.$term.'%')
        );
    }

    public function salary_percent()
    {
        return $this->lga->percent;
    }

    public function salary_data()
    {
            //[$grade, $step] = explode("/", $this->salary_grade_level);
            //return Salary::where('grade', $grade)->where('step', $step)->where('payment_method', $this->lga->percent)->first();
        return $this->belongsTo(Salary::class, ['salary_structure', 'salary_grade', 'salary_step'], ['payment_method', 'grade', 'step']);
     
    }

    public function getTotalAttribute()
    {
        return $this->literacy + $this->numeracy + $this->oral;
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class);
    }


}

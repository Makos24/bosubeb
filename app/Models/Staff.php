<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'dob', 'dofa', 'dor'
    ];

    // public function setQualificationAttribute($value)
    // {
    //     $data = config('data');
    //     $key = array_search(strtolower($value), array_map('strtolower', $data['qualification']));
    //     return $key;
    // }

    public function salaryGrade(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => explode("/", $attributes["salary_grade_level"])[0],
            set:null
        );
    }

    public function salaryStep(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => explode("/", $attributes["salary_grade_level"])[1],
            set:null
        );
    }

    public function salaryBasic(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->basic,
            set:null
        );
    }

    public function salaryRent(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->rent,
            set:null
        );
    }

    public function salaryTransport(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->transport,
            set:null
        );
    }

    public function salaryUtility(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->utility,
            set:null
        );
    }

    public function salaryDomesticStaff(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->domestic_staff,
            set:null
        );
    }

    public function salaryEnt(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->ent,
            set:null
        );
    }

    public function salaryMeals(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->meals,
            set:null
        );
    }

    public function salaryPaye(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->paye,
            set:null
        );
    }

    public function salaryUnion(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->union,
            set:null
        );
    }

    public function salaryTd(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->td,
            set:null
        );
    }
    public function salaryGross(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $this->salary_data($attributes)->gross,
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

    public function salary_data($attributes)
    {
        [$grade, $step] = explode("/", $attributes["salary_grade_level"]);
        return Salary::where('grade', $grade)->where('step', $step)->where('payment_method', $this->lga->percent)->first();
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

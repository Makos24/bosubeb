<?php

namespace App\Models;

use App\Models\Scopes\UserRoleScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;
    use SoftDeletes;


    protected $guarded = ['id'];

    protected $casts = [
        'dob', 'dofa', 'dor'
    ];

    
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

    public function suspensions(){
        return $this->hasMany(Suspension::class);
    }

    public function retirement(){
        return $this->hasOne(Retirement::class);
    }

    public function loans(){
        return $this->hasMany(Loan::class);
    }

    public function promotions(){
        return $this->hasMany(Promotion::class);
    }

    // Existing scope
    public function scopeDead(Builder $query): void {
        $query->where('deceased', true);
    }
  
  // Negative scope
    public function scopeNotDead(Builder $query): void {
        $query->where('deceased', null); // Using whereNot to negate the condition
    }

     // Existing scope
     public function scopeStudent(Builder $query): void {
        $query->where('student', true);
    }
  
  // Negative scope
    public function scopeNotStudent(Builder $query): void {
        $query->where('student', null); // Using whereNot to negate the condition
    }

     // Existing scope
     public function scopeSenior(Builder $query): void {
        $query->where('senior_citizen', true);
    }
  
  // Negative scope
    public function scopeNotSenior(Builder $query): void {
        $query->where('senior_citizen', null); // Using whereNot to negate the condition
    }

     // Existing scope
     public function scopePensioners(Builder $query): void {
        $query->where('expected_date_of_retirement', '<=', Carbon::today());
    }
  
  // Negative scope
    public function scopeNotPensioners(Builder $query): void {
        $query->where(function ($query) {
            $query->whereNotNull('expected_date_of_retirement')
                  ->where('expected_date_of_retirement', '>', Carbon::today());
        })
        ->orWhereNull('expected_date_of_retirement'); // Using whereNot to negate the condition
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserRoleScope);
    }

}


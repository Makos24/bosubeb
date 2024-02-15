<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function grade_benefits(){
        return $this->hasMany(GradeBenefits::class);
    }

    public function salary_item(){
        return $this->belongsTo(SalaryItem::class);
    }
}

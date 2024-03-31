<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeBenefits extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function salary_item(){
        return $this->belongsTo(SalaryItem::class);
    }

    public function salary_structure(){
        return $this->belongsTo(SalaryStructure::class);
    }
}

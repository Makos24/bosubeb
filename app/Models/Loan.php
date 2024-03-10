<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }
}

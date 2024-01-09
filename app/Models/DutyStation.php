<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyStation extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lga_id'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}

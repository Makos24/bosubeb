<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $guarded = ['id'];

    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) => $query->where('percent', 'like', '%'.$term.'%')
                ->orWhere('grade', 'like', '%'.$term.'%')
                ->orWhere('step', 'like', '%'.$term.'%')
        );
    }
}

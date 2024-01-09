<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lga extends Model
{
    protected $fillable = ['lga_code', 'name', 'state_id'];
    use HasFactory;

    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) => $query->where('name', 'like', '%'.$term.'%')
        );
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function state() : BelongsTo {
        return $this->belongsTo(State::class);
    }

    public function schools() : HasMany {
        return $this->hasMany(School::class);
    }

}

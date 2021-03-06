<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by');   
    }

    public function crew() {
        return $this->hasMany(Crew::class);
    }
}

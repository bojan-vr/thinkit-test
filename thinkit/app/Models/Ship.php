<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ship extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function crew()
    {
        return $this->hasMany(Crew::class);
    }
    
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by' ,'id');   
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crew extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'crew';

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class,'id');   
    }
}

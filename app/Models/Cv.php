<?php

namespace App\Models;

use App\Models\User;
use App\Models\Hobby;
use App\Models\Academic_experience;
use App\Models\Professional_experience;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['user_id','template','title','pdf_path'];

    public function hobbies()
    {
        return $this->hasMany(Hobby::class);
    }

    public function academic_experiences()
    {
        return $this->hasMany(Academic_experience::class);
    }

    public function professional_experiences()
    {
        return $this->hasMany(Professional_experience::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

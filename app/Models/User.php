<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;

class User extends Model implements Authenticatable{
    use BasicAuthenticatable;

    protected $fillable = ['first_name','last_name','email','phone_number','password'];

    public function getRememberTokenName()
    {
        return '';
    }

    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }
}
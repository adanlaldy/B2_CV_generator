<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    protected $fillable = ['cv_id','description'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}

<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;

class Professional_experience extends Model
{
    protected $fillable = ['cv_id','name','location','description','start_date','end_date'];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}

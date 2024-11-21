<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'courseName',
        'description',
        'details',
        'image',
        'price',
    ];
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Các cột có thể gán giá trị bằng Mass Assignment
    protected $fillable = [
        'user_id', 
        'course_id',   
        'quantity',
        'amount',     
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseCart extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'course_cart';
    protected $fillable = [
        'course_id',
        'user_id',
        'course_added_date'
    ];
}

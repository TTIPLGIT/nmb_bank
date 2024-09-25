<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'events';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'event_name',
        'event_date',
        'event_image',
        'event_description'
    ];

    // If you want to customize the date format
    protected $dates = ['event_date'];
}

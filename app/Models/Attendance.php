<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Attendance extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attendances';

    protected $fillable = [
        'employee_id',
        'course_id',
        'date',
        'check_in',
        'check_out',
        'total_hours'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_hours' => 'float'
    ];
} 
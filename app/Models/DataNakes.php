<?php
// app/Models/DataNakes.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNakes extends Model
{
    use HasFactory;

    protected $table = 'data_nakes';
    
    protected $fillable = [
        'nama',
        'status',
        'contact',
        'admitted_date'
    ];

    protected $casts = [
        'admitted_date' => 'date'
    ];
}
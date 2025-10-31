<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_date',
        'title',
        'description',
        'status',
        'patient_name',
        'doctor_name'
    ];

    protected $casts = [
        'event_date' => 'date'
    ];

    // Scope untuk filter berdasarkan tanggal
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('event_date', $date);
    }
}
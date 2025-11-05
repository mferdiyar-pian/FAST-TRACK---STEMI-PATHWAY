<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CodeStemi extends Model
{
    use HasFactory;

    protected $table = 'code_stemi';

    protected $fillable = [
        'status',
        'start_time',
        'end_time',
        'duration',
        'checklist',
        'custom_message',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'checklist' => 'array',
    ];

    // Accessor untuk door_to_balloon_time
    public function getDoorToBalloonTimeAttribute()
    {
        if (!$this->start_time) {
            return '00h : 00m : 00s';
        }

        // Gunakan waktu server saat ini dengan timezone yang sama
        $endTime = $this->end_time ? Carbon::parse($this->end_time) : now();
        $start = Carbon::parse($this->start_time);
        
        // Pastikan tidak negatif
        if ($endTime->lt($start)) {
            return '00h : 00m : 00s';
        }
        
        $diff = $endTime->diff($start);
        
        return sprintf('%02dh : %02dm : %02ds', $diff->h, $diff->i, $diff->s);
    }

    // Accessor untuk formatted_date
    public function getFormattedDateAttribute()
    {
        return $this->start_time ? $this->start_time->format('d M, Y') : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk data running
    public function scopeRunning($query)
    {
        return $query->where('status', 'Running');
    }

    // Scope untuk data finished
    public function scopeFinished($query)
    {
        return $query->where('status', 'Finished');
    }
}
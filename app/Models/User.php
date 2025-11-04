<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_number',
        'profile_photo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke settings
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    // Helper untuk mendapatkan setting
    public function getSetting($key, $default = null)
    {
        $setting = $this->settings()->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Accessor untuk profile photo URL
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && \Illuminate\Support\Facades\Storage::exists('public/profile-photos/' . $this->profile_photo)) {
            return \Illuminate\Support\Facades\Storage::url('profile-photos/' . $this->profile_photo);
        }
        return null;
    }
}
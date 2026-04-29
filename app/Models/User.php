<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'branch',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ---- İlişkiler (Relationships) ---- */

    // Öğretmenin nöbet atamaları
    public function dutyAssignments()
    {
        return $this->hasMany(DutyAssignment::class);
    }

    // Yöneticinin oluşturduğu nöbet çizelgeleri
    public function createdSchedules()
    {
        return $this->hasMany(DutySchedule::class, 'created_by');
    }

    // Öğretmenin gönderdiği takas talepleri
    public function sentSwapRequests()
    {
        return $this->hasMany(SwapRequest::class, 'requester_id');
    }

    // Öğretmene gelen takas talepleri
    public function receivedSwapRequests()
    {
        return $this->hasMany(SwapRequest::class, 'target_id');
    }

    /* ---- Yardımcı Metotlar ---- */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    // Bugünkü nöbet ataması
    public function todayDuty()
    {
        return $this->dutyAssignments()
            ->whereHas('dutySchedule', function ($query) {
                $query->where('date', today());
            });
    }
}

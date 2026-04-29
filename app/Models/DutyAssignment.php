<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DutyAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'duty_schedule_id',
        'user_id',
        'location_id',
        'period',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'string',
            'end_time' => 'string',
        ];
    }

    /* ---- İlişkiler ---- */

    // Atanan öğretmen
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Nöbet yeri
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Ait olduğu çizelge
    public function dutySchedule()
    {
        return $this->belongsTo(DutySchedule::class);
    }

    // Bu atama için takas talepleri
    public function swapRequests()
    {
        return $this->hasMany(SwapRequest::class);
    }

    /* ---- Yardımcı Metotlar ---- */

    public function getPeriodLabelAttribute(): string
    {
        return match ($this->period) {
            'morning' => 'Sabah',
            'noon' => 'Öğle',
            'afternoon' => 'Öğleden Sonra',
            default => $this->period,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'assigned' => 'Atandı',
            'completed' => 'Tamamlandı',
            'absent' => 'Gelmedi',
            'swapped' => 'Takas Edildi',
            default => $this->status,
        };
    }
}

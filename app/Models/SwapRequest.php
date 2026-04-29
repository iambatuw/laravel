<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SwapRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'requester_id',
        'target_id',
        'duty_assignment_id',
        'reason',
        'status',
        'approved_by',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    /* ---- İlişkiler ---- */

    // Takas isteyen öğretmen
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    // Takas hedefi öğretmen
    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    // İlgili nöbet ataması
    public function dutyAssignment()
    {
        return $this->belongsTo(DutyAssignment::class);
    }

    // Onaylayan yönetici
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ---- Scope'lar ---- */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /* ---- Yardımcı Metotlar ---- */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Beklemede',
            'approved' => 'Onaylandı',
            'rejected' => 'Reddedildi',
            default => $this->status,
        };
    }
}

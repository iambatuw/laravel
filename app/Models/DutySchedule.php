<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DutySchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'day_of_week',
        'title',
        'notes',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    /* ---- İlişkiler ---- */

    // Bu çizelgeyi oluşturan yönetici
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Bu çizelgedeki nöbet atamaları
    public function assignments()
    {
        return $this->hasMany(DutyAssignment::class);
    }

    /* ---- Scope'lar ---- */

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeToday($query)
    {
        return $query->where('date', today());
    }

    /* ---- Yardımcı Metotlar ---- */

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}

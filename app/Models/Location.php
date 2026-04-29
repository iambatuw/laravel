<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'floor',
        'description',
        'capacity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'capacity' => 'integer',
        ];
    }

    /* ---- İlişkiler ---- */

    // Bu lokasyona yapılan nöbet atamaları
    public function dutyAssignments()
    {
        return $this->hasMany(DutyAssignment::class);
    }

    /* ---- Scope'lar ---- */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'level_id',
        'capacity',
        'room_number',
        'description',
        'status'
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'section_id');
    }
} 
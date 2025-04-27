<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    protected $fillable = [
        'level_id',
        'section_id',
        'course_id',
        'professor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'type',
        'semester',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
} 
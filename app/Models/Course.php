<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
        'level_id',
        'department_id',
        'professor_id',
        'semester',
        'status',
        'max_students',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }
} 
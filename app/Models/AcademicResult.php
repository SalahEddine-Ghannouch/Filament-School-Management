<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'academic_year',
        'semester',
        'grade',
        'score',
        'remarks',
        'professor_id',
        'status'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
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
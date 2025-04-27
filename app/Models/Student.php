<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'image',
        'gender',
        'date_of_birth',
        'admission_date',
        'student_id',
        'level_id',
        'section_id',
        'parent_name',
        'parent_phone',
        'parent_email',
        'emergency_contact',
        'blood_group',
        'medical_conditions',
        'status'
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class, 'level_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class, 'section_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_student');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function academicResults(): HasMany
    {
        return $this->hasMany(AcademicResult::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

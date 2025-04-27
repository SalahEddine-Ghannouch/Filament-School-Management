<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'order',
        'status'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'level_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
} 
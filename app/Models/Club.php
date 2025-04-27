<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'professor_id',
        'meeting_schedule',
        'location',
        'max_members',
        'status',
        'requirements',
        'image'
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'club_student');
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
} 
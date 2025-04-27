<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professor extends Model
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
        'hire_date',
        'department_id',
        'specialization',
        'qualification',
        'employee_id',
        'status',
        'bio'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
} 
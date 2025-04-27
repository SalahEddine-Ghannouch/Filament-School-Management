<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'head_of_department',
        'email',
        'phone',
        'location',
        'status'
    ];

    public function professors(): HasMany
    {
        return $this->hasMany(Professor::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
} 
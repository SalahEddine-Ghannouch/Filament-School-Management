<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_students');
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->hasRole('student')) {
            return $user->student && $user->student->id === $student->id;
        }
        
        return $user->hasPermissionTo('view_students');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_students');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasPermissionTo('edit_students');
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasPermissionTo('delete_students');
    }
} 
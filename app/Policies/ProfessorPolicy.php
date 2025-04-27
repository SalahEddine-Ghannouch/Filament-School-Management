<?php

namespace App\Policies;

use App\Models\Professor;
use App\Models\User;

class ProfessorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_professors');
    }

    public function view(User $user, Professor $professor): bool
    {
        if ($user->hasRole('professor')) {
            return $user->professor && $user->professor->id === $professor->id;
        }
        
        return $user->hasPermissionTo('view_professors');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_professors');
    }

    public function update(User $user, Professor $professor): bool
    {
        if ($user->hasRole('professor')) {
            return $user->professor && $user->professor->id === $professor->id;
        }
        
        return $user->hasPermissionTo('edit_professors');
    }

    public function delete(User $user, Professor $professor): bool
    {
        return $user->hasPermissionTo('delete_professors');
    }
} 
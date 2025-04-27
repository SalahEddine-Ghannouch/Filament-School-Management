<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Assign admin role to a user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return;
        }

        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Assign admin role to user
        $user->assignRole('admin');

        $this->info("Admin role assigned to user {$email} successfully!");
    }
} 
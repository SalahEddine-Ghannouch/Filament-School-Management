<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Student management
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
        
        // Class management
        Permission::create(['name' => 'view classes']);
        Permission::create(['name' => 'create classes']);
        Permission::create(['name' => 'edit classes']);
        Permission::create(['name' => 'delete classes']);
        
        // Grade management
        Permission::create(['name' => 'view grades']);
        Permission::create(['name' => 'create grades']);
        Permission::create(['name' => 'edit grades']);
        Permission::create(['name' => 'delete grades']);
        
        // Timetable management
        Permission::create(['name' => 'view timetable']);
        Permission::create(['name' => 'create timetable']);
        Permission::create(['name' => 'edit timetable']);
        Permission::create(['name' => 'delete timetable']);

        // Create roles and assign permissions
        
        // Admin role - gets all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Professor role
        $professorRole = Role::create(['name' => 'professor']);
        $professorRole->givePermissionTo([
            'view students',
            'view classes',
            'edit classes',
            'view grades',
            'create grades',
            'edit grades',
            'view timetable',
        ]);

        // Student role
        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view grades',
            'view timetable',
        ]);
    }
} 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure Spatie tables exist
        if (!Schema::hasTable('permissions') || !Schema::hasTable('roles')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();
            });

            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->timestamps();
            });

            Schema::create('model_has_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permission_id')->constrained()->onDelete('cascade');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type']);
            });

            Schema::create('model_has_roles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type']);
            });

            Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('permission_id')->constrained()->onDelete('cascade');
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
            });
        }

        // Create permissions
        $permissions = [
            // Dashboard
            'view_dashboard',
            
            // Student management
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            'view_own_grades',
            'view_own_timetable',
            
            // Professor management
            'view_professors',
            'create_professors',
            'edit_professors',
            'delete_professors',
            'manage_own_classes',
            'manage_student_grades',
            
            // Course management
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
            
            // Department management
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',
            
            // Section management
            'view_sections',
            'create_sections',
            'edit_sections',
            'delete_sections',
            
            // Club management
            'view_clubs',
            'create_clubs',
            'edit_clubs',
            'delete_clubs',
            
            // Timetable management
            'view_timetables',
            'create_timetables',
            'edit_timetables',
            'delete_timetables',
            
            // Academic Results
            'view_results',
            'create_results',
            'edit_results',
            'delete_results',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'admin' => $permissions,
            'professor' => [
                'view_dashboard',
                'manage_own_classes',
                'manage_student_grades',
                'view_students',
                'view_own_timetable',
                'view_courses',
                'view_sections',
                'view_results',
                'create_results',
                'edit_results',
            ],
            'student' => [
                'view_dashboard',
                'view_own_grades',
                'view_own_timetable',
                'view_courses',
                'view_professors',
                'view_clubs',
            ],
        ];

        foreach ($roles as $role => $rolePermissions) {
            $createdRole = Role::create(['name' => $role]);
            $createdRole->givePermissionTo($rolePermissions);
        }
    }

    public function down(): void
    {
        // Remove all roles and permissions
        if (Schema::hasTable('roles')) {
            Role::query()->delete();
        }
        if (Schema::hasTable('permissions')) {
            Permission::query()->delete();
        }
    }
}; 
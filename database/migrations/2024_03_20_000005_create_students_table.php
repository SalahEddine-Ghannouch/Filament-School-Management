<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->date('admission_date');
            $table->foreignId('level_id')->constrained('study_levels')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('class_sections')->cascadeOnDelete();
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('professor_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('max_members')->nullable();
            $table->timestamps();
        });

        // Create pivot table for students and clubs
        Schema::create('club_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['member', 'leader'])->default('member');
            $table->date('joined_at');
            $table->timestamps();

            $table->unique(['club_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_student');
        Schema::dropIfExists('clubs');
    }
}; 
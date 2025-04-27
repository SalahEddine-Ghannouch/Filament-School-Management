<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('midterm_mark', 5, 2)->nullable();
            $table->decimal('final_mark', 5, 2)->nullable();
            $table->decimal('total_mark', 5, 2)->nullable();
            $table->string('grade')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();

            // A student can only have one result per course
            $table->unique(['student_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_results');
    }
}; 
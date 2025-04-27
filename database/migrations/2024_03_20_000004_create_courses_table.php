<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professor_id')->constrained()->cascadeOnDelete();
            $table->integer('credits');
            $table->enum('semester', ['fall', 'spring', 'summer']);
            $table->integer('hours_per_week');
            $table->enum('type', ['mandatory', 'elective'])->default('mandatory');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
}; 
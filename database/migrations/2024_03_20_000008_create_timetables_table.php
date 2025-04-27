<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('study_levels')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('class_sections')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professor_id')->constrained()->cascadeOnDelete();
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->enum('type', ['lecture', 'lab', 'tutorial'])->default('lecture');
            $table->enum('semester', ['fall', 'spring', 'summer']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Prevent scheduling conflicts
            $table->unique(['section_id', 'day_of_week', 'start_time', 'end_time'], 'schedule_conflict_check');
            $table->unique(['room', 'day_of_week', 'start_time', 'end_time'], 'room_conflict_check');
            $table->unique(['professor_id', 'day_of_week', 'start_time', 'end_time'], 'professor_conflict_check');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
}; 
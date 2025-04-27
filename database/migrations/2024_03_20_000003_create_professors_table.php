<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->date('hire_date');
            $table->string('employee_id')->unique();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('specialization');
            $table->string('qualification');
            $table->text('bio')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
}; 
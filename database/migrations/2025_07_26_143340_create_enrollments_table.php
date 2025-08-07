<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('restrict');
            $table->string('school_year')->length(9); // Format: YYYY-YYYY
            $table->integer('school_moment')->length(1); // 1: First moment, 2: Second moment, etc.
            $table->integer('degree')->lengeth(1);
            $table->string('section')->length(2);
            $table->string('classroom')->length(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};

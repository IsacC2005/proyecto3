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
        Schema::create('learning_project_qualitie_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_project_id');
            $table->foreignId('qualitie_id')->nullable();
            $table->foreignId('student_id');
            $table->string('qualitie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_project_qualitie_student');
    }
};

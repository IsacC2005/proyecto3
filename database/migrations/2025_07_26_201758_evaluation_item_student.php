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
        Schema::create('evaluation_item_student', function (Blueprint $table) {
            $table->foreignId('evaluation_item_id')->constrained('evaluation_items')->onDelete('restrict');
            $table->unsignedBigInteger('student_id');
            $table->string('note')->length(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_items_student');
    }
};

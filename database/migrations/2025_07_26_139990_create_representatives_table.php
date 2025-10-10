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
        // Schema::create('representatives', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('idcard');
        //     $table->string('phone')->length(11)->nullable();
        //     $table->string('name')->length(100);
        //     $table->string('surname')->length(100);
        //     $table->string('direction');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representatives');
    }
};

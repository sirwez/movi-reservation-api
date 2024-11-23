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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('seat');
            $table->boolean('available')->default(true); // Alterado para boolean
            $table->string('type')->nullable(); // Ex.: "VIP", "Regular"
            $table->unsignedBigInteger('show_time_id');
            $table->foreign('show_time_id')->references('id')->on('show_times')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};

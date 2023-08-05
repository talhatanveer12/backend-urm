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
        Schema::create('feedback_reviews', function (Blueprint $table) {
            $table->id();
            // $table->foreignId("urm_candidate_id")->constrained("urm_candidates")->nullable();
            // $table->foreignId("academia_id")->constrained("academias")->nullable();
            $table->text('feedback_message');
            $table->integer('rating')->nullable();
            $table->date("feedback_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_reviews');
    }
};
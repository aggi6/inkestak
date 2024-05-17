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
        Schema::create('pollAnswers', function (Blueprint $table) {
            $table->id();
            $table->ForeignId('poll_id')->require();
            $table->ForeignId('polled_id')->require();
            $table->ForeignId('question_id')->require();
            $table->string('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pollAnswers');
    }
};

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
        Schema::create('polleds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->email('email');
            $table->date('birthDate')->nullable();
            $table->string('postalCode', 5)->nullable();
            $table->string('genre', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polleds');
    }
};

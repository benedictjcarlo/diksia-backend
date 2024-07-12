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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->integer('donationAmount')->nullable();
            $table->integer('donationNeed')->nullable();
            $table->integer('deadline')->nullable();
            $table->text('description')->nullable();
            $table->text('news')->nullable();
            $table->text('donationList')->nullable();
            $table->string('types')->nullable();
            $table->text('picturePath')->nullable();
            $table->integer('fundraisers_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

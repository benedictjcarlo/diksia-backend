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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            
            $table->integer('users_id');
            $table->integer('donations_id');
            $table->string('jenis');
            $table->string('kondisi');
            $table->string('merk');
            $table->string('kendala');
            $table->string('shipment_photo_path', 2048)->nullable();
            $table->string('kurir');
            $table->string('resi');
            $table->string('status');
            $table->integer('amount');
            

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
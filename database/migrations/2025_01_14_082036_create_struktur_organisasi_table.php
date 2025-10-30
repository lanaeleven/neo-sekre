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
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users');
            $table->unsignedInteger('idAtasan');
            $table->foreign('idAtasan')->references('id')->on('users');
            $table->unsignedInteger('levelJabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasi');
    }
};

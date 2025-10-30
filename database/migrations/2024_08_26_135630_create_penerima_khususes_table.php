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
        Schema::create('penerima_khusus', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users');
            $table->unsignedInteger('bisaMenerimaDari');
            $table->foreign('bisaMenerimaDari')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_khusus');
    }
};

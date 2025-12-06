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
        Schema::create('distribusi_surat_izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idSuratIzin');
            $table->foreign('idSuratIzin')->references('id')->on('surat_izin');
            $table->unsignedInteger('idTujuanDisposisi');
            $table->foreign('idTujuanDisposisi')->references('id')->on('users');
            $table->unsignedInteger('idPengirimDisposisi');
            $table->foreign('idPengirimDisposisi')->references('id')->on('users');
            $table->datetime('tanggalDiteruskan');
            $table->string('status');
            $table->string('instruksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_surat_izin');
    }
};

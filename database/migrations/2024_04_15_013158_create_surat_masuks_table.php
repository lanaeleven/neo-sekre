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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->year('tahun');
            $table->unsignedInteger('idDireksi');
            $table->foreign('idDireksi')->references('id')->on('direksi');
            $table->unsignedInteger('idPosisiDisposisi');
            $table->foreign('idPosisiDisposisi')->references('id')->on('users');
            $table->integer('statusArsip');
            $table->string('nomorSurat');
            $table->date('tanggalAgenda');
            $table->date('tanggalSurat');
            $table->string('sifatSurat');
            $table->string('pengirim');
            $table->string('perihal');
            $table->string('lampiran');
            $table->string('status')->nullable();
            $table->string('fileName');
            $table->string('filePath');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};

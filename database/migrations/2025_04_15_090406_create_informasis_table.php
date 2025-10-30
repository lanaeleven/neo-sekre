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
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('index');
            $table->year('tahun');
            $table->unsignedInteger('idJenisInformasi');
            $table->foreign('idJenisInformasi')->references('id')->on('jenis_informasi');
            $table->date('tanggalSurat');
            $table->string('judul');
            $table->string('fileName');
            $table->string('filePath');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};

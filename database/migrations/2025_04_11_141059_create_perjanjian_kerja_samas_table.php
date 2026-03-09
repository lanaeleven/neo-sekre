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
        Schema::create('perjanjian_kerja_sama', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->year('tahun');
            $table->date('tanggalSurat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->string('keterangan')->nullable();
            $table->string('fileName');
            $table->string('filePath');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjanjian_kerja_sama');
    }
};

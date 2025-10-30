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
        Schema::create('undangan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('index');
            $table->year('tahun');
            $table->string('judul');
            $table->string('tempatKegiatan');
            $table->dateTime('waktuKegiatan');
            $table->text('isi');
            $table->string('fileName')->nullable();
            $table->string('filePath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_halaman', function (Blueprint $table) {
            $table->id('id_halaman');
            $table->string('judul', 200);
            $table->string('slug', 220)->unique();
            $table->longText('isi')->nullable();
            $table->integer('urutan')->default(0);
            $table->tinyInteger('status')->default(1); // 1=aktif, 0=nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_halaman');
    }
};

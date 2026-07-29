<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_terkait', function (Blueprint $table) {
            $table->id('id_link_terkait');
            $table->string('nama', 150);
            $table->string('gambar', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->tinyInteger('urutan')->default(1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_terkait');
    }
};

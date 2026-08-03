<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gis_target', function (Blueprint $table) {
            $table->id('id_target');
            $table->unsignedBigInteger('id_wilayah')->nullable();
            $table->unsignedBigInteger('id_jenis_diklat');
            $table->integer('tahun');
            $table->integer('target_peserta')->default(0);
            $table->integer('target_kegiatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('id_wilayah')
                ->references('id_wilayah')
                ->on('gis_wilayah')
                ->onDelete('set null');

            $table->foreign('id_jenis_diklat')
                ->references('id_jenis_diklat')
                ->on('gis_jenis_diklat')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gis_target');
    }
};

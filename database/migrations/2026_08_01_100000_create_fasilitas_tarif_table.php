<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_tarif', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->bigInteger('id_fasilitas');
            $table->string('nama', 100);
            $table->string('satuan', 30);
            $table->decimal('tarif', 15, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->tinyInteger('status')->default(1); // 1=aktif, 0=nonaktif
            $table->timestamps();

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_tarif');
    }
};

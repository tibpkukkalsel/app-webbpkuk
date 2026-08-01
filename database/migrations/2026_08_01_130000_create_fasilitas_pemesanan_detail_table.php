<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_pemesanan_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->bigInteger('id_pemesanan')->unsigned();
            $table->bigInteger('id_fasilitas');
            $table->integer('jumlah')->default(1);
            $table->decimal('tarif', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_pemesanan')
                ->references('id_pemesanan')
                ->on('fasilitas_pemesan')
                ->onDelete('cascade');

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_pemesanan_detail');
    }
};

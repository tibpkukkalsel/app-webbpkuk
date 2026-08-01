<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_riwayat', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->bigInteger('id_pemesanan')->unsigned()->nullable();
            $table->string('nomor_booking', 30)->nullable();
            $table->bigInteger('id_fasilitas')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('aktivitas', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_pemesanan')
                ->references('id_pemesanan')
                ->on('fasilitas_pemesan')
                ->onDelete('cascade');

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_riwayat');
    }
};

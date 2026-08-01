<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_pemesan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->string('nomor_booking', 30)->unique();
            $table->string('nama_pemohon', 150);
            $table->string('nik', 20)->nullable();
            $table->string('instansi', 200)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->text('keperluan')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('foto_ktp', 255)->nullable();
            $table->string('status', 30)->default('menunggu'); // menunggu, disetujui, ditolak, selesai, dibatalkan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_pemesan');
    }
};

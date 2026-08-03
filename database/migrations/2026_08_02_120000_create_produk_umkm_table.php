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
        Schema::create('produk_umkm', function (Blueprint $table) {
            $table->bigIncrements('id_produkumkm');
            $table->unsignedBigInteger('id_wilayah');
            $table->string('nama_produk', 150);
            $table->string('nama_umkm', 150);
            $table->string('ukuran', 100)->nullable();
            $table->string('ketahanan', 100)->nullable();
            $table->string('pengiriman', 150)->default('Pengiriman Seluruh Indonesia');
            $table->string('foto', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('id_wilayah')
                  ->references('id_wilayah')
                  ->on('gis_wilayah')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_umkm');
    }
};

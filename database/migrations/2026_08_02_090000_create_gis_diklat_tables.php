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
        // 1. Table gis_wilayah
        Schema::create('gis_wilayah', function (Blueprint $table) {
            $table->bigIncrements('id_wilayah');
            $table->string('kode_bps', 20)->nullable();
            $table->string('nama', 100);
            $table->enum('jenis', ['kabupaten', 'kota']);
            $table->longText('geojson')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // 2. Table gis_jenis_diklat
        Schema::create('gis_jenis_diklat', function (Blueprint $table) {
            $table->bigIncrements('id_jenis_diklat');
            $table->enum('jenis_sdm', ['sdm_koperasi', 'sdm_umkm']);
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // 3. Table gis_identifikasi
        Schema::create('gis_identifikasi', function (Blueprint $table) {
            $table->bigIncrements('id_identifikasi');
            $table->unsignedBigInteger('id_wilayah');
            $table->integer('tahun');
            $table->enum('jenis_sdm', ['sdm_koperasi', 'sdm_umkm']);
            $table->integer('jumlah_responden')->default(0);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('id_wilayah')
                  ->references('id_wilayah')
                  ->on('gis_wilayah')
                  ->onDelete('cascade');
        });

        // 4. Table gis_identifikasi_detail
        Schema::create('gis_identifikasi_detail', function (Blueprint $table) {
            $table->bigIncrements('id_detail');
            $table->unsignedBigInteger('id_identifikasi');
            $table->unsignedBigInteger('id_jenis_diklat');
            $table->integer('jumlah_responden')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_identifikasi')
                  ->references('id_identifikasi')
                  ->on('gis_identifikasi')
                  ->onDelete('cascade');

            $table->foreign('id_jenis_diklat')
                  ->references('id_jenis_diklat')
                  ->on('gis_jenis_diklat')
                  ->onDelete('cascade');
        });

        // 5. Table gis_realisasi
        Schema::create('gis_realisasi', function (Blueprint $table) {
            $table->bigIncrements('id_realisasi');
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_jenis_diklat');
            $table->integer('tahun');
            $table->integer('jumlah_peserta')->default(0);
            $table->integer('jumlah_kegiatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_wilayah')
                  ->references('id_wilayah')
                  ->on('gis_wilayah')
                  ->onDelete('cascade');

            $table->foreign('id_jenis_diklat')
                  ->references('id_jenis_diklat')
                  ->on('gis_jenis_diklat')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gis_realisasi');
        Schema::dropIfExists('gis_identifikasi_detail');
        Schema::dropIfExists('gis_identifikasi');
        Schema::dropIfExists('gis_jenis_diklat');
        Schema::dropIfExists('gis_wilayah');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            // Rename gambar -> thumbnail
            $table->renameColumn('gambar', 'thumbnail');

            // Rename keterangan -> deskripsi
            $table->renameColumn('keterangan', 'deskripsi');

            // Add new columns after nama
            $table->string('slug')->nullable()->unique()->after('nama');
            $table->string('kode', 50)->nullable()->after('slug');
            $table->integer('kapasitas')->nullable()->after('deskripsi');
            $table->string('lokasi', 255)->nullable()->after('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->renameColumn('thumbnail', 'gambar');
            $table->renameColumn('deskripsi', 'keterangan');
            $table->dropColumn(['slug', 'kode', 'kapasitas', 'lokasi']);
        });
    }
};

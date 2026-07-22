<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('identitas', function (Blueprint $table) {
            $table->id('id_identitas');
            $table->string('nama', 90);
            $table->text('keterangan');
            $table->text('link')->nullable();
            $table->string('jenis', 30);
            $table->string('status',8);
            $table->timestamps();
        });
        // Mengisi data tabel
        DB::table('identitas')->insert([
            [
                'nama' => 'Logo Website',
                'keterangan' => 'logo_1.png',
                'link' => '/',
                'jenis' => 'Identitas',
                'status' => 'file'
            ],
            [
                'nama' => 'Logo Shorcut Website',
                'keterangan' => 'favicon.png',
                'link' => '',
                'jenis' => 'Identitas',
                'status' => 'file'
            ],
            [
                'nama' => 'Logo Landing Website',
                'keterangan' => 'pre.png',
                'link' => '',
                'jenis' => 'Identitas',
                'status' => 'file'
            ],
            [
                'nama' => 'Title Website',
                'keterangan' => 'Balatkop-uk Prov. Kalsel',
                'link' => '',
                'jenis' => 'Identitas',
                'status' => 'text'
            ],
            [
                'nama' => 'Telepon',
                'keterangan' => '(0511) 4707559',
                'link' => '',
                'jenis' => 'Contact',
                'status' => 'text'
            ],
            [
                'nama' => 'Email',
                'keterangan' => 'web.balatkopuk@gmail.com',
                'link' => '',
                'jenis' => 'Contact',
                'status' => 'text'
            ],
            [
                'nama' => 'Alamat',
                'keterangan' => 'Jl. Ahmad Yani KM. 18.200 Kec. Liang Anggang Kota Banjarbaru',
                'link' => 'https://maps.app.goo.gl/FUaeDrXhwijyqEcTA',
                'jenis' => 'Contact',
                'status' => 'text'
            ],
            [
                'nama' => 'Instagram',
                'keterangan' => '@balatkop.kalselprov',
                'link' => 'https://www.instagram.com/balatkop.provkalsel/',
                'jenis' => 'Contact',
                'status' => 'text'
            ],
            [
                'nama' => 'Tombol Header',
                'keterangan' => 'Ingin Ikut Diklat ? Gabung Disini',
                'link' => '',
                'jenis' => 'Lainnya',
                'status' => 'text'
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas');
    }
};

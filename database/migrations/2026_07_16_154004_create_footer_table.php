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
        Schema::create('footer', function (Blueprint $table) {
            $table->id('id_footer');
            $table->string('nama', 90);
            $table->text('keterangan');
            $table->text('link')->nullable();
            $table->string('jenis', 30);
            $table->string('status',8);
            $table->timestamps();
        });

        DB::table('footer')->insert([
            [
                'nama' => 'Logo Website',
                'keterangan' => 'logo_1.png',
                'link' => '/',
                'jenis' => 'Logo',
                'status' => 'file'
            ],
            [
                'nama' => 'Logo 1',
                'keterangan' => 'favicon.png',
                'link' => '',
                'jenis' => 'Motto',
                'status' => 'file'
            ],
            [
                'nama' => 'Logo 2',
                'keterangan' => 'favicon.png',
                'link' => '',
                'jenis' => 'Motto',
                'status' => 'file'
            ],
            [
                'nama' => 'Nama Pembuatan',
                'keterangan' => 'BPKUK Prov. Kalsel',
                'link' => '',
                'jenis' => 'Copyright',
                'status' => 'text'
            ],
            [
                'nama' => 'Tahun Pembuatan',
                'keterangan' => '2025',
                'link' => '',
                'jenis' => 'Copyright',
                'status' => 'text'
            ],
            [
                'nama' => 'Deskripsi',
                'keterangan' => 'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel memiliki fungsi utama sebagai pusat pendidikan dan pelatihan untuk pengembangan sumber 
                daya manusia (SDM) koperasi dan pelaku usaha kecil  di Provinsi Kalimantan Selatan.',
                'link' => '',
                'jenis' => 'Tentang',
                'status' => 'text'
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer');
    }
};

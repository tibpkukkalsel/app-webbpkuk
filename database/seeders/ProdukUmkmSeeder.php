<?php

namespace Database\Seeders;

use App\Models\GisWilayah;
use App\Models\ProdukUmkm;
use Illuminate\Database\Seeder;

class ProdukUmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banjarmasin = GisWilayah::where('nama', 'like', '%Banjarmasin%')->first();
        $banjarbaru  = GisWilayah::where('nama', 'like', '%Banjarbaru%')->first();
        $banjar      = GisWilayah::where('nama', 'like', '%Kab. Banjar%')->first();
        $tanahLaut   = GisWilayah::where('nama', 'like', '%Tanah Laut%')->first();

        $wilayahId1 = $banjarmasin ? $banjarmasin->id_wilayah : 1;
        $wilayahId2 = $banjarbaru ? $banjarbaru->id_wilayah : 2;
        $wilayahId3 = $banjar ? $banjar->id_wilayah : 3;
        $wilayahId4 = $tanahLaut ? $tanahLaut->id_wilayah : 4;

        $samples = [
            [
                'id_wilayah'  => $wilayahId1,
                'nama_produk' => 'Sasirangan Motif Khas Banjar',
                'nama_umkm'   => 'UMKM Sasirangan Creative',
                'ukuran'      => '2m x 1.15m',
                'ketahanan'   => 'Tahan Lama (Warna Awet)',
                'pengiriman'  => 'Pengiriman Seluruh Indonesia',
                'foto'        => 'produk_umkm/sasirangan.png',
                'status'      => 1,
            ],
            [
                'id_wilayah'  => $wilayahId1,
                'nama_produk' => 'Kerupuk Ikan Haruan Original',
                'nama_umkm'   => 'Berkah Haruan Mandiri',
                'ukuran'      => 'Kemasan 250gr & 500gr',
                'ketahanan'   => '6 Bulan (Kemasan Kedap Udara)',
                'pengiriman'  => 'Pengiriman Seluruh Indonesia',
                'foto'        => 'produk_umkm/kerupuk_haruan.png',
                'status'      => 1,
            ],
            [
                'id_wilayah'  => $wilayahId2,
                'nama_produk' => 'Olahan Purun (Tas & Tikar Handcrafted)',
                'nama_umkm'   => 'Kelompok Pengrajin Purun Bersama',
                'ukuran'      => 'Berbagai Ukuran (Custom)',
                'ketahanan'   => 'Sangat Kuat & Ramah Lingkungan',
                'pengiriman'  => 'Pengiriman Seluruh Indonesia',
                'foto'        => 'produk_umkm/olahan_purun.png',
                'status'      => 1,
            ],
            [
                'id_wilayah'  => $wilayahId3,
                'nama_produk' => 'Sirup Batu Permata Khas Martapura',
                'nama_umkm'   => 'Martapura Herbal & Drink',
                'ukuran'      => 'Botol 500ml',
                'ketahanan'   => '12 Bulan',
                'pengiriman'  => 'Pengiriman Seluruh Indonesia',
                'foto'        => 'produk_umkm/sirup_martapura.png',
                'status'      => 1,
            ],
            [
                'id_wilayah'  => $wilayahId4,
                'nama_produk' => 'Stik Amplang Ikan Tenggiri',
                'nama_umkm'   => 'Amplang Pelaihari Jaya',
                'ukuran'      => 'Kemasan 200gr',
                'ketahanan'   => '4 Bulan',
                'pengiriman'  => 'Pengiriman Seluruh Indonesia',
                'foto'        => 'produk_umkm/amplang.png',
                'status'      => 1,
            ],
        ];

        foreach ($samples as $item) {
            ProdukUmkm::updateOrCreate(
                [
                    'nama_produk' => $item['nama_produk'],
                    'nama_umkm'   => $item['nama_umkm'],
                ],
                $item
            );
        }
    }
}

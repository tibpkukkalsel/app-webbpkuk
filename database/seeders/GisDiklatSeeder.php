<?php

namespace Database\Seeders;

use App\Models\GisWilayah;
use App\Models\GisJenisDiklat;
use App\Models\GisIdentifikasi;
use App\Models\GisIdentifikasiDetail;
use App\Models\GisRealisasi;
use Illuminate\Database\Seeder;

class GisDiklatSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed 13 Wilayah Kalimantan Selatan (Kode BPS Resmi)
        $wilayahs = [
            [
                'kode_bps'  => '6371',
                'nama'      => 'Kota Banjarmasin',
                'jenis'     => 'kota',
                'latitude'  => -3.3194,
                'longitude' => 114.5908,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6372',
                'nama'      => 'Kota Banjarbaru',
                'jenis'     => 'kota',
                'latitude'  => -3.4572,
                'longitude' => 114.8103,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6303',
                'nama'      => 'Kabupaten Banjar',
                'jenis'     => 'kabupaten',
                'latitude'  => -3.3167,
                'longitude' => 115.0833,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6301',
                'nama'      => 'Kabupaten Tanah Laut',
                'jenis'     => 'kabupaten',
                'latitude'  => -3.8000,
                'longitude' => 114.7667,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6304',
                'nama'      => 'Kabupaten Barito Kuala',
                'jenis'     => 'kabupaten',
                'latitude'  => -3.0833,
                'longitude' => 114.6167,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6305',
                'nama'      => 'Kabupaten Tapin',
                'jenis'     => 'kabupaten',
                'latitude'  => -2.9167,
                'longitude' => 115.1667,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6306',
                'nama'      => 'Kabupaten Hulu Sungai Selatan',
                'jenis'     => 'kabupaten',
                'latitude'  => -2.6833,
                'longitude' => 115.2667,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6307',
                'nama'      => 'Kabupaten Hulu Sungai Tengah',
                'jenis'     => 'kabupaten',
                'latitude'  => -2.5833,
                'longitude' => 115.4167,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6308',
                'nama'      => 'Kabupaten Hulu Sungai Utara',
                'jenis'     => 'kabupaten',
                'latitude'  => -2.4167,
                'longitude' => 115.2500,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6309',
                'nama'      => 'Kabupaten Tabalong',
                'jenis'     => 'kabupaten',
                'latitude'  => -1.8833,
                'longitude' => 115.5000,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6310',
                'nama'      => 'Kabupaten Tanah Bumbu',
                'jenis'     => 'kabupaten',
                'latitude'  => -3.4500,
                'longitude' => 115.7000,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6311',
                'nama'      => 'Kabupaten Balangan',
                'jenis'     => 'kabupaten',
                'latitude'  => -2.3333,
                'longitude' => 115.6167,
                'status'    => 1,
            ],
            [
                'kode_bps'  => '6302',
                'nama'      => 'Kabupaten Kotabaru',
                'jenis'     => 'kabupaten',
                'latitude'  => -3.2000,
                'longitude' => 116.0000,
                'status'    => 1,
            ],
        ];

        $createdWilayah = [];
        foreach ($wilayahs as $w) {
            $createdWilayah[] = GisWilayah::updateOrCreate(
                ['kode_bps' => $w['kode_bps']],
                $w
            );
        }

        // 2. Seed Jenis Diklat SDM (sdm_koperasi & sdm_umkm)
        $jenisDiklats = [
            // SDM Koperasi
            [
                'jenis_sdm' => 'sdm_koperasi',
                'nama'      => 'Diklat Manajerial & Tata Kelola Koperasi Modern',
                'deskripsi' => 'Pelatihan peningkatan kapasitas pengurus dan pengawas dalam tata kelola manajemen Koperasi modern berbasis digital.',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_koperasi',
                'nama'      => 'Diklat Akuntansi & Standar Laporan Keuangan Koperasi',
                'deskripsi' => 'Bimbingan teknis penyusunan keuangan, neraca, dan pertanggungjawaban RAT sesuai standar akuntansi koperasi (SAK EP).',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_koperasi',
                'nama'      => 'Diklat Pengawasan & Manajemen Risiko Usaha Koperasi',
                'deskripsi' => 'Pelatihan mitigasi risiko pembiayaan, audit internal, dan pengawasan operasional Usaha Simpan Pinjam (USP).',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_koperasi',
                'nama'      => 'Diklat Penilaian Kesehatan Koperasi & Digitalisasi Simpan Pinjam',
                'deskripsi' => 'Pelatihan penilaian kemandirian dan kesehatan koperasi serta implementasi aplikasi pencatatan transaksi digital.',
                'status'    => 1,
            ],
            // SDM UMKM
            [
                'jenis_sdm' => 'sdm_umkm',
                'nama'      => 'Diklat Kewirausahaan & Legalitas Berusaha UMKM (NIB/P-IRT/Halal)',
                'deskripsi' => 'Bimbingan teknis pembentukan jiwa wirausaha, kelengkapan izin berusaha (NIB, P-IRT, Sertifikasi Halal), dan legalitas merk.',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_umkm',
                'nama'      => 'Diklat Digital Marketing & Marketplace E-Commerce UMKM',
                'deskripsi' => 'Pelatihan pemasaran produk berbasis media sosial, foto produk profesional, iklan digital, dan penjualan via marketplace.',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_umkm',
                'nama'      => 'Diklat Manajemen Keuangan & Standar Harga Pokok Penjualan (HPP)',
                'deskripsi' => 'Pelatihan pembukuan sederhana usaha micro, penetapan HPP produk olahan/kerajinan, serta pengelolaan kas usaha.',
                'status'    => 1,
            ],
            [
                'jenis_sdm' => 'sdm_umkm',
                'nama'      => 'Diklat Inovasi Kemasan, Packaging Design & Ekspor Produk',
                'deskripsi' => 'Pendampingan desain kemasan produk unggulan daerah agar memenuhi standar ritel modern dan siap ekspor.',
                'status'    => 1,
            ],
        ];

        $createdJenisDiklat = [];
        foreach ($jenisDiklats as $jd) {
            $createdJenisDiklat[] = GisJenisDiklat::updateOrCreate(
                ['nama' => $jd['nama']],
                $jd
            );
        }

        // 3. Seed Identifikasi Kebutuhan Diklat & Detail
        $identifikasiSamples = [
            [
                'id_wilayah'       => $createdWilayah[0]->id_wilayah, // Kota Banjarmasin
                'tahun'            => 2026,
                'jenis_sdm'        => 'sdm_koperasi',
                'jumlah_responden' => 45,
                'keterangan'       => 'Hasil survei kebutuhan pelatihan pengurus Koperasi Simpan Pinjam Kota Banjarmasin.',
                'status'           => 1,
                'details'          => [
                    ['id_jenis_diklat' => $createdJenisDiklat[0]->id_jenis_diklat, 'jumlah_responden' => 25, 'keterangan' => 'Membutuhkan modul tata kelola digital'],
                    ['id_jenis_diklat' => $createdJenisDiklat[1]->id_jenis_diklat, 'jumlah_responden' => 20, 'keterangan' => 'Standar SAK EP terbaru'],
                ]
            ],
            [
                'id_wilayah'       => $createdWilayah[0]->id_wilayah, // Kota Banjarmasin
                'tahun'            => 2026,
                'jenis_sdm'        => 'sdm_umkm',
                'jumlah_responden' => 60,
                'keterangan'       => 'Hasil pemetaan kebutuhan UMKM sektor kuliner dan olahan khas sasirangan.',
                'status'           => 1,
                'details'          => [
                    ['id_jenis_diklat' => $createdJenisDiklat[4]->id_jenis_diklat, 'jumlah_responden' => 30, 'keterangan' => 'Kebutuhan Sertifikasi Halal gratis'],
                    ['id_jenis_diklat' => $createdJenisDiklat[5]->id_jenis_diklat, 'jumlah_responden' => 30, 'keterangan' => 'Pelatihan Shopee & TikTok Shop'],
                ]
            ],
            [
                'id_wilayah'       => $createdWilayah[1]->id_wilayah, // Kota Banjarbaru
                'tahun'            => 2026,
                'jenis_sdm'        => 'sdm_umkm',
                'jumlah_responden' => 50,
                'keterangan'       => 'Identifikasi wirausaha muda dan usaha ekonomi kreatif Banjarbaru.',
                'status'           => 1,
                'details'          => [
                    ['id_jenis_diklat' => $createdJenisDiklat[5]->id_jenis_diklat, 'jumlah_responden' => 25, 'keterangan' => 'Kebutuhan promosi medsos'],
                    ['id_jenis_diklat' => $createdJenisDiklat[7]->id_jenis_diklat, 'jumlah_responden' => 25, 'keterangan' => 'Desain kemasan Rumah Kemasan Kalsel'],
                ]
            ],
            [
                'id_wilayah'       => $createdWilayah[2]->id_wilayah, // Kab Banjar
                'tahun'            => 2026,
                'jenis_sdm'        => 'sdm_koperasi',
                'jumlah_responden' => 35,
                'keterangan'       => 'Identifikasi pengurus Koperasi Unit Desa (KUD) Martapura dan sekitarnya.',
                'status'           => 1,
                'details'          => [
                    ['id_jenis_diklat' => $createdJenisDiklat[2]->id_jenis_diklat, 'jumlah_responden' => 20, 'keterangan' => 'Pemeriksaan kesehatan koperasi'],
                    ['id_jenis_diklat' => $createdJenisDiklat[3]->id_jenis_diklat, 'jumlah_responden' => 15, 'keterangan' => 'Digitalisasi simpan pinjam'],
                ]
            ],
            [
                'id_wilayah'       => $createdWilayah[3]->id_wilayah, // Kab Tanah Laut
                'tahun'            => 2025,
                'jenis_sdm'        => 'sdm_umkm',
                'jumlah_responden' => 40,
                'keterangan'       => 'Survei kebutuhan pelaku UMKM sektor olahan hasil laut dan perikanan Pelaihari.',
                'status'           => 1,
                'details'          => [
                    ['id_jenis_diklat' => $createdJenisDiklat[6]->id_jenis_diklat, 'jumlah_responden' => 20, 'keterangan' => 'Penghitungan HPP olahan ikan'],
                    ['id_jenis_diklat' => $createdJenisDiklat[7]->id_jenis_diklat, 'jumlah_responden' => 20, 'keterangan' => 'Pengemasan produk vakum'],
                ]
            ],
        ];

        foreach ($identifikasiSamples as $data) {
            $details = $data['details'];
            unset($data['details']);

            $identifikasi = GisIdentifikasi::create($data);

            foreach ($details as $dt) {
                GisIdentifikasiDetail::create([
                    'id_identifikasi'  => $identifikasi->id_identifikasi,
                    'id_jenis_diklat'  => $dt['id_jenis_diklat'],
                    'jumlah_responden' => $dt['jumlah_responden'],
                    'keterangan'       => $dt['keterangan'],
                ]);
            }
        }

        // 4. Seed Realisasi Diklat
        $realisasiSamples = [
            // 2025
            [
                'id_wilayah'      => $createdWilayah[0]->id_wilayah, // Banjarmasin
                'id_jenis_diklat' => $createdJenisDiklat[0]->id_jenis_diklat, // Manajerial Koperasi
                'tahun'           => 2025,
                'jumlah_peserta'  => 30,
                'keterangan'      => 'Dilaksanakan di Hotel Grand Palace Banjarmasin angkatan I.',
            ],
            [
                'id_wilayah'      => $createdWilayah[0]->id_wilayah, // Banjarmasin
                'id_jenis_diklat' => $createdJenisDiklat[5]->id_jenis_diklat, // Digital Marketing UMKM
                'tahun'           => 2025,
                'jumlah_peserta'  => 60,
                'keterangan'      => 'Pelatihan digital marketing angkatan I & II di LabKom Balatkop Kalsel.',
            ],
            [
                'id_wilayah'      => $createdWilayah[1]->id_wilayah, // Banjarbaru
                'id_jenis_diklat' => $createdJenisDiklat[4]->id_jenis_diklat, // Legalitas UMKM
                'tahun'           => 2025,
                'jumlah_peserta'  => 35,
                'keterangan'      => 'Fasilitasi NIB & Sertifikasi Halal gratis kerjasama Dinas Koperasi Banjarbaru.',
            ],
            [
                'id_wilayah'      => $createdWilayah[2]->id_wilayah, // Banjar
                'id_jenis_diklat' => $createdJenisDiklat[1]->id_jenis_diklat, // Akuntansi Koperasi
                'tahun'           => 2025,
                'jumlah_peserta'  => 25,
                'keterangan'      => 'Bimtek penyusunan laporan keuangan Koperasi KUD Martapura.',
            ],
            [
                'id_wilayah'      => $createdWilayah[3]->id_wilayah, // Tanah Laut
                'id_jenis_diklat' => $createdJenisDiklat[7]->id_jenis_diklat, // Kemasan UMKM
                'tahun'           => 2025,
                'jumlah_peserta'  => 30,
                'keterangan'      => 'Pelatihan dan cetak sampel kemasan olahan kerupuk ikan.',
            ],
            [
                'id_wilayah'      => $createdWilayah[9]->id_wilayah, // Tabalong
                'id_jenis_diklat' => $createdJenisDiklat[6]->id_jenis_diklat, // HPP UMKM
                'tahun'           => 2025,
                'jumlah_peserta'  => 30,
                'keterangan'      => 'Pelatihan akuntansi sederhana dan penetapan harga jual usaha mikro.',
            ],
            // 2026 (Tahun Berjalan)
            [
                'id_wilayah'      => $createdWilayah[0]->id_wilayah, // Banjarmasin
                'id_jenis_diklat' => $createdJenisDiklat[1]->id_jenis_diklat, // Akuntansi Koperasi
                'tahun'           => 2026,
                'jumlah_peserta'  => 30,
                'keterangan'      => 'Realisasi angkatan I tahun 2026 di Balatkop Kalsel.',
            ],
            [
                'id_wilayah'      => $createdWilayah[1]->id_wilayah, // Banjarbaru
                'id_jenis_diklat' => $createdJenisDiklat[5]->id_jenis_diklat, // Digital Marketing UMKM
                'tahun'           => 2026,
                'jumlah_peserta'  => 30,
                'keterangan'      => 'Realisasi angkatan I tahun 2026 bidang digitalisasi.',
            ],
        ];

        foreach ($realisasiSamples as $r) {
            GisRealisasi::create($r);
        }
    }
}

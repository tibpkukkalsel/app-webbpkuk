<?php

namespace Database\Seeders;

use App\Models\GisJenisDiklat;
use App\Models\GisTarget;
use Illuminate\Database\Seeder;

class GisTargetSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing targets so we have exactly 10 data items for year 2026
        GisTarget::query()->delete();

        $jenisDiklats = GisJenisDiklat::all();

        if ($jenisDiklats->isEmpty()) {
            $this->command->info('Jenis Diklat kosong. Seeder dibatalkan.');
            return;
        }

        $sampleNotes = [
            'Target Anggaran DPA APBD Provinsi Kalsel T.A. 2026',
            'Target Program Prioritas Pengembangan SDM Koperasi & UMKM T.A. 2026',
            'Alokasi Diklat Kemitraan Kabupaten/Kota T.A. 2026',
            'Program Fasilitasi Sertifikasi & Kewirausahaan T.A. 2026',
            'Target Alokasi Kuota Peserta Balatkop Kalsel T.A. 2026',
        ];

        $targetPesertaValues = [30, 60, 30, 90, 60, 30, 60, 90, 30, 60];

        $count = 0;
        foreach ($jenisDiklats as $jd) {
            if ($count >= 10) {
                break;
            }

            GisTarget::create([
                'id_wilayah'      => null,
                'id_jenis_diklat' => $jd->id_jenis_diklat,
                'tahun'           => 2026,
                'target_peserta'  => $targetPesertaValues[$count % count($targetPesertaValues)],
                'keterangan'      => $sampleNotes[$count % count($sampleNotes)],
                'status'          => 1,
            ]);

            $count++;
        }

        // If jenisDiklats has fewer than 10 items, reuse items to reach exactly 10 target items
        while ($count < 10) {
            $jd = $jenisDiklats->random();
            GisTarget::create([
                'id_wilayah'      => null,
                'id_jenis_diklat' => $jd->id_jenis_diklat,
                'tahun'           => 2026,
                'target_peserta'  => $targetPesertaValues[$count % count($targetPesertaValues)],
                'keterangan'      => $sampleNotes[$count % count($sampleNotes)],
                'status'          => 1,
            ]);
            $count++;
        }
    }
}

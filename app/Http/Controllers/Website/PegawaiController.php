<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Seksi;
use App\Models\Identitas;
use App\Models\Tentang;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function view(Request $request)
    {
        $seksiParam = $request->get('seksi');
        $seksiList = Seksi::where('status', 1)->orderBy('id_seksi', 'asc')->get();

        $selectedSeksi = null;
        if ($seksiParam) {
            $selectedSeksi = Seksi::where('status', 1)
                ->where(function ($q) use ($seksiParam) {
                    $q->where('slug', $seksiParam)
                      ->orWhere('id_seksi', $seksiParam);
                })->first();
        }

        $query = Pegawai::with(['jabatan', 'seksi'])
            ->where('status', 1);

        if ($selectedSeksi) {
            $query->where('id_seksi', $selectedSeksi->id_seksi);
        }

        $allPegawai = $query->get();

        // Urutan Data Pegawai (1 - 99):
        // 1. Kelas Jabatan (Ascending 1 - 99)
        // 2. Jenis Pegawai (Ascending 1: PNS, 2: PPPK PW, 3: PPPK Paruh, 4: PJLP)
        // 3. Nama Pegawai (Ascending A - Z)
        $pegawaiList = $allPegawai->sort(function ($a, $b) {
            $rawA = preg_replace('/[^0-9]/', '', $a->jabatan->kelas ?? '');
            $rawB = preg_replace('/[^0-9]/', '', $b->jabatan->kelas ?? '');

            $kelasA = $rawA !== '' ? (int)$rawA : 9999;
            $kelasB = $rawB !== '' ? (int)$rawB : 9999;

            if ($kelasA !== $kelasB) {
                return $kelasA <=> $kelasB; // Ascending kelas 1 - 99
            }

            $jenisA = (int) ($a->jenis ?? 99);
            $jenisB = (int) ($b->jenis ?? 99);

            if ($jenisA !== $jenisB) {
                return $jenisA <=> $jenisB; // Ascending jenis 1 - 4
            }

            return strcasecmp($a->nama, $b->nama); // Ascending nama
        })->values();

        $identitas = Identitas::all();
        $tentang = Tentang::all();

        return view('websites.profile.pegawai.view', compact(
            'pegawaiList',
            'seksiList',
            'selectedSeksi',
            'seksiParam',
            'identitas',
            'tentang'
        ));
    }
}

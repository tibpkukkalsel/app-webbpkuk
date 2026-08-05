<?php

namespace App\Livewire\Website\Diklat;

use App\Models\GisIdentifikasi;
use App\Models\GisIdentifikasiDetail;
use App\Models\GisJenisDiklat;
use App\Models\GisRealisasi;
use App\Models\GisTarget;
use App\Models\GisWilayah;
use Livewire\Component;

class Dashboard extends Component
{
    public $filterTahun = '';
    public $filterJenisSdm = '';
    public $selectedWilayahId = null;

    public function selectWilayah($idWilayah)
    {
        if ($this->selectedWilayahId == $idWilayah) {
            $this->selectedWilayahId = null;
            $this->dispatch('resetMapZoom');
        } else {
            $this->selectedWilayahId = $idWilayah;

            $wilayah = GisWilayah::find($idWilayah);
            if ($wilayah && $wilayah->latitude && $wilayah->longitude) {
                $this->dispatch('focusWilayahOnMap', [
                    'id_wilayah' => (int) $wilayah->id_wilayah,
                    'latitude'   => (float) $wilayah->latitude,
                    'longitude'  => (float) $wilayah->longitude,
                    'nama'       => $wilayah->nama,
                ]);
            }
        }
    }

    public function updatedFilterTahun()
    {
        $this->selectedWilayahId = null;
    }

    public function resetFilters()
    {
        $this->filterTahun = '';
        $this->filterJenisSdm = '';
        $this->selectedWilayahId = null;

        $this->dispatch('resetMapZoom');
    }

    public function render()
    {
        // 1. Dropdown Filter Options
        $tahunOptions = GisIdentifikasi::select('tahun')
            ->union(GisTarget::select('tahun'))
            ->union(GisRealisasi::select('tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $wilayahs = GisWilayah::where('status', 1)->orderBy('nama')->get();

        // Default empty states when filterTahun is not selected
        $totalResponden = 0;
        $totalKebutuhan = 0;
        $totalTargetPeserta = 0;
        $totalPeserta = 0;

        $mapData = [];
        $selectedWilayah = null;
        $selectedWilayahResponden = 0;
        $selectedIdentifikasis = collect();
        $selectedRealisasis = collect();
        $selectedSummaryTable = collect();
        $overallSummaryTable = collect();
        $targetList = collect();

        // ONLY CALCULATE DATA WHEN filterTahun IS SELECTED
        if ($this->filterTahun) {
            // 1. Filtered Identifikasi Query
            $identifikasiQuery = GisIdentifikasi::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm));

            $totalResponden = (clone $identifikasiQuery)->sum('jumlah_responden');

            $identifikasiIds = (clone $identifikasiQuery)->pluck('id_identifikasi');
            $totalKebutuhan = GisIdentifikasiDetail::whereIn('id_identifikasi', $identifikasiIds)->sum('jumlah_responden');

            // 2. Filtered Target Query (Global target, not bound to region)
            $targetQuery = GisTarget::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)));

            $totalTargetPeserta = (clone $targetQuery)->sum('target_peserta');

            // 3. Filtered Realisasi Query
            $realisasiQuery = GisRealisasi::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)));

            $totalPeserta = (clone $realisasiQuery)->sum('jumlah_peserta');

            // 4. Wilayahs & Map Data
            foreach ($wilayahs as $w) {
                // 1) Responden IKP
                $wResp = GisIdentifikasi::where('id_wilayah', $w->id_wilayah)
                    ->where('tahun', $this->filterTahun)
                    ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                    ->sum('jumlah_responden');

                // 2) Kebutuhan (Total Usulan dari Detail IKP)
                $wIdntIds = GisIdentifikasi::where('id_wilayah', $w->id_wilayah)
                    ->where('tahun', $this->filterTahun)
                    ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                    ->pluck('id_identifikasi');
                $wKeb = GisIdentifikasiDetail::whereIn('id_identifikasi', $wIdntIds)->sum('jumlah_responden');

                // 3) Target / Kuota Peserta
                $wTrg = GisTarget::where('id_wilayah', $w->id_wilayah)
                    ->where('tahun', $this->filterTahun)
                    ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                    ->sum('target_peserta');

                // 4) Realisasi Alumni
                $wReal = GisRealisasi::where('id_wilayah', $w->id_wilayah)
                    ->where('tahun', $this->filterTahun)
                    ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                    ->sum('jumlah_peserta');

                $mapData[] = [
                    'id_wilayah' => $w->id_wilayah,
                    'kode_bps'   => $w->kode_bps,
                    'nama'       => $w->nama,
                    'jenis'      => $w->jenis,
                    'latitude'   => $w->latitude,
                    'longitude'  => $w->longitude,
                    'responden'  => $wResp,
                    'kebutuhan'  => $wKeb,
                    'target'     => $wTrg,
                    'realisasi'  => $wReal,
                    'peserta'    => $wReal,
                ];
            }

            // 5. Selected Region Detail Data & Summary Matrix
            $selectedWilayahResponden = 0;
            if ($this->selectedWilayahId) {
                $selectedWilayah = GisWilayah::find($this->selectedWilayahId);
                if ($selectedWilayah) {
                    $selectedWilayahResponden = GisIdentifikasi::where('id_wilayah', $this->selectedWilayahId)
                        ->where('tahun', $this->filterTahun)
                        ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                        ->sum('jumlah_responden');

                    $idntIds = GisIdentifikasi::where('id_wilayah', $this->selectedWilayahId)
                        ->where('tahun', $this->filterTahun)
                        ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                        ->pluck('id_identifikasi');

                    $idntDetails = GisIdentifikasiDetail::whereIn('id_identifikasi', $idntIds)
                        ->selectRaw('id_jenis_diklat, SUM(jumlah_responden) as total_responden')
                        ->groupBy('id_jenis_diklat')
                        ->pluck('total_responden', 'id_jenis_diklat');

                    $targetDetails = GisTarget::where('id_wilayah', $this->selectedWilayahId)
                        ->where('tahun', $this->filterTahun)
                        ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                        ->selectRaw('id_jenis_diklat, SUM(target_peserta) as total_target')
                        ->groupBy('id_jenis_diklat')
                        ->pluck('total_target', 'id_jenis_diklat');

                    $realDetails = GisRealisasi::where('id_wilayah', $this->selectedWilayahId)
                        ->where('tahun', $this->filterTahun)
                        ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                        ->selectRaw('id_jenis_diklat, SUM(jumlah_peserta) as total_peserta')
                        ->groupBy('id_jenis_diklat')
                        ->pluck('total_peserta', 'id_jenis_diklat');

                    $allJenisIds = $idntDetails->keys()
                        ->merge($targetDetails->keys())
                        ->merge($realDetails->keys())
                        ->unique();

                    $jenisDiklats = GisJenisDiklat::whereIn('id_jenis_diklat', $allJenisIds)->get();

                    foreach ($jenisDiklats as $jd) {
                        $keb = $idntDetails->get($jd->id_jenis_diklat, 0);
                        $trg = $targetDetails->get($jd->id_jenis_diklat, 0);
                        $alm = $realDetails->get($jd->id_jenis_diklat, 0);
                        $persen = $trg > 0 ? round(($alm / $trg) * 100) : 0;

                        $selectedSummaryTable->push([
                            'nama_diklat' => $jd->nama,
                            'jenis_sdm'   => $jd->jenis_sdm,
                            'kebutuhan'   => $keb,
                            'target'      => $trg,
                            'alumni'      => $alm,
                            'persen'      => $persen,
                        ]);
                    }
                }
            }

            // 6. OVERALL SUMMARY MATRIX CALCULATION (FOR SELECTED YEAR)
            $allIdntIds = GisIdentifikasi::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                ->pluck('id_identifikasi');

            $allIdntDetails = GisIdentifikasiDetail::whereIn('id_identifikasi', $allIdntIds)
                ->selectRaw('id_jenis_diklat, SUM(jumlah_responden) as total_kebutuhan')
                ->groupBy('id_jenis_diklat')
                ->pluck('total_kebutuhan', 'id_jenis_diklat');

            $allIdntRespMap = GisIdentifikasiDetail::whereIn('gis_identifikasi_detail.id_identifikasi', $allIdntIds)
                ->join('gis_identifikasi', 'gis_identifikasi_detail.id_identifikasi', '=', 'gis_identifikasi.id_identifikasi')
                ->selectRaw('gis_identifikasi_detail.id_jenis_diklat, SUM(gis_identifikasi.jumlah_responden) as total_resp')
                ->groupBy('gis_identifikasi_detail.id_jenis_diklat')
                ->pluck('total_resp', 'id_jenis_diklat');

            $allTrgDetails = GisTarget::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                ->selectRaw('id_jenis_diklat, SUM(target_peserta) as total_target')
                ->groupBy('id_jenis_diklat')
                ->pluck('total_target', 'id_jenis_diklat');

            $allRealDetails = GisRealisasi::query()
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                ->selectRaw('id_jenis_diklat, SUM(jumlah_peserta) as total_peserta')
                ->groupBy('id_jenis_diklat')
                ->pluck('total_peserta', 'id_jenis_diklat');

            $allJenisIds = $allIdntDetails->keys()->merge($allTrgDetails->keys())->merge($allRealDetails->keys())->unique();
            $allJenisDiklats = GisJenisDiklat::whereIn('id_jenis_diklat', $allJenisIds)->get();

            foreach ($allJenisDiklats as $jd) {
                $kebutuhan = $allIdntDetails->get($jd->id_jenis_diklat, 0);
                $responden = $allIdntRespMap->get($jd->id_jenis_diklat, $kebutuhan);
                $target    = $allTrgDetails->get($jd->id_jenis_diklat, 0);
                $alumni    = $allRealDetails->get($jd->id_jenis_diklat, 0);
                $persen    = $target > 0 ? round(($alumni / $target) * 100) : ($kebutuhan > 0 ? round(($alumni / $kebutuhan) * 100) : ($alumni > 0 ? 100 : 0));

                $overallSummaryTable->push([
                    'nama_diklat' => $jd->nama,
                    'jenis_sdm'   => $jd->jenis_sdm,
                    'kebutuhan'   => $kebutuhan,
                    'responden'   => $responden,
                    'target'      => $target,
                    'alumni'      => $alumni,
                    'persen'      => $persen,
                ]);
            }

            // 7. Target List with Realisasi & Percentage
            $realisasiMap = GisRealisasi::where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                ->selectRaw('id_jenis_diklat, SUM(jumlah_peserta) as total_alumni')
                ->groupBy('id_jenis_diklat')
                ->pluck('total_alumni', 'id_jenis_diklat');

            $targets = GisTarget::with('jenisDiklat')
                ->where('tahun', $this->filterTahun)
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                ->where('status', 1)
                ->orderBy('id_target', 'desc')
                ->get();

            foreach ($targets as $t) {
                $alumni = $realisasiMap->get($t->id_jenis_diklat, 0);
                $target = $t->target_peserta;
                $persen = $target > 0 ? round(($alumni / $target) * 100) : ($alumni > 0 ? 100 : 0);

                $targetList->push([
                    'id_target'   => $t->id_target,
                    'nama_diklat' => $t->jenisDiklat->nama ?? '-',
                    'jenis_sdm'   => $t->jenisDiklat->jenis_sdm ?? '',
                    'target'      => $target,
                    'alumni'      => $alumni,
                    'persen'      => $persen,
                ]);
            }

            if (count($mapData) > 0) {
                $this->dispatch('initGisMap', mapData: $mapData);
            }
        }

        return view('livewire.website.diklat.dashboard', compact(
            'totalResponden',
            'totalKebutuhan',
            'totalTargetPeserta',
            'totalPeserta',
            'wilayahs',
            'mapData',
            'selectedWilayah',
            'selectedWilayahResponden',
            'selectedSummaryTable',
            'overallSummaryTable',
            'tahunOptions',
            'targetList'
        ));
    }
}

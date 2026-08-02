<?php

namespace App\Livewire\Website\Diklat;

use App\Models\GisWilayah;
use App\Models\GisJenisDiklat;
use App\Models\GisIdentifikasi;
use App\Models\GisIdentifikasiDetail;
use App\Models\GisRealisasi;
use Livewire\Component;

class Dashboard extends Component
{
    public $filterTahun = '';
    public $filterJenisSdm = '';
    public $filterWilayahId = '';
    public $selectedWilayahId = null;

    public function selectWilayah($idWilayah)
    {
        if ($this->selectedWilayahId == $idWilayah) {
            $this->selectedWilayahId = null;
        } else {
            $this->selectedWilayahId = $idWilayah;
            $this->filterWilayahId = $idWilayah;

            $wilayah = GisWilayah::find($idWilayah);
            if ($wilayah && $wilayah->latitude && $wilayah->longitude) {
                $this->dispatch('focusWilayahOnMap', [
                    'id_wilayah' => $wilayah->id_wilayah,
                    'latitude'   => (float) $wilayah->latitude,
                    'longitude'  => (float) $wilayah->longitude,
                    'nama'       => $wilayah->nama,
                ]);
            }
        }
    }

    public function updatedFilterWilayahId($val)
    {
        if ($val) {
            $this->selectedWilayahId = $val;
            $wilayah = GisWilayah::find($val);
            if ($wilayah && $wilayah->latitude && $wilayah->longitude) {
                $this->dispatch('focusWilayahOnMap', [
                    'id_wilayah' => $wilayah->id_wilayah,
                    'latitude'   => (float) $wilayah->latitude,
                    'longitude'  => (float) $wilayah->longitude,
                    'nama'       => $wilayah->nama,
                ]);
            }
        } else {
            $this->selectedWilayahId = null;
        }
    }

    public function resetFilters()
    {
        $this->filterTahun = '';
        $this->filterJenisSdm = '';
        $this->filterWilayahId = '';
        $this->selectedWilayahId = null;

        $this->dispatch('resetMapZoom');
    }

    public function render()
    {
        // 1. Filtered Identifikasi Query
        $identifikasiQuery = GisIdentifikasi::query()
            ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
            ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
            ->when($this->filterWilayahId, fn($q) => $q->where('id_wilayah', $this->filterWilayahId));

        $totalResponden = (clone $identifikasiQuery)->sum('jumlah_responden');

        $identifikasiIds = (clone $identifikasiQuery)->pluck('id_identifikasi');
        $totalKebutuhan = GisIdentifikasiDetail::whereIn('id_identifikasi', $identifikasiIds)->sum('jumlah_responden');

        // 2. Filtered Realisasi Query
        $realisasiQuery = GisRealisasi::query()
            ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
            ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
            ->when($this->filterWilayahId, fn($q) => $q->where('id_wilayah', $this->filterWilayahId));

        $totalPeserta = (clone $realisasiQuery)->sum('jumlah_peserta');
        $totalKegiatan = (clone $realisasiQuery)->sum('jumlah_kegiatan');

        // 3. Wilayahs & Map Data
        $wilayahs = GisWilayah::where('status', 1)->orderBy('nama')->get();

        $mapData = [];
        foreach ($wilayahs as $w) {
            $wResp = GisIdentifikasi::where('id_wilayah', $w->id_wilayah)
                ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                ->sum('jumlah_responden');

            $wReal = GisRealisasi::where('id_wilayah', $w->id_wilayah)
                ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)));

            $wPeserta = (clone $wReal)->sum('jumlah_peserta');
            $wKegiatan = (clone $wReal)->sum('jumlah_kegiatan');

            $mapData[] = [
                'id_wilayah' => $w->id_wilayah,
                'kode_bps'   => $w->kode_bps,
                'nama'       => $w->nama,
                'jenis'      => $w->jenis,
                'latitude'   => $w->latitude,
                'longitude'  => $w->longitude,
                'responden'  => $wResp,
                'peserta'    => $wPeserta,
                'kegiatan'   => $wKegiatan,
            ];
        }

        // 4. Selected Region Detail Data & Summary Matrix
        $selectedWilayah = null;
        $selectedIdentifikasis = collect();
        $selectedRealisasis = collect();
        $selectedSummaryTable = collect();

        if ($this->selectedWilayahId) {
            $selectedWilayah = GisWilayah::find($this->selectedWilayahId);
            if ($selectedWilayah) {
                $selectedIdentifikasis = GisIdentifikasi::with(['details.jenisDiklat'])
                    ->where('id_wilayah', $this->selectedWilayahId)
                    ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                    ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                    ->orderBy('tahun', 'desc')
                    ->get();

                $selectedRealisasis = GisRealisasi::with(['jenisDiklat'])
                    ->where('id_wilayah', $this->selectedWilayahId)
                    ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                    ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                    ->orderBy('tahun', 'desc')
                    ->get();

                // SUMMARY MATRIX CALCULATION FOR SELECTED REGION
                $idntIds = GisIdentifikasi::where('id_wilayah', $this->selectedWilayahId)
                    ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                    ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
                    ->pluck('id_identifikasi');

                $idntDetails = GisIdentifikasiDetail::whereIn('id_identifikasi', $idntIds)
                    ->selectRaw('id_jenis_diklat, SUM(jumlah_responden) as total_responden')
                    ->groupBy('id_jenis_diklat')
                    ->pluck('total_responden', 'id_jenis_diklat');

                $realDetails = GisRealisasi::where('id_wilayah', $this->selectedWilayahId)
                    ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
                    ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
                    ->selectRaw('id_jenis_diklat, SUM(jumlah_peserta) as total_peserta')
                    ->groupBy('id_jenis_diklat')
                    ->pluck('total_peserta', 'id_jenis_diklat');

                $allJenisIds = $idntDetails->keys()->merge($realDetails->keys())->unique();
                $jenisDiklats = GisJenisDiklat::whereIn('id_jenis_diklat', $allJenisIds)->get();

                foreach ($jenisDiklats as $jd) {
                    $resp = $idntDetails->get($jd->id_jenis_diklat, 0);
                    $alumni = $realDetails->get($jd->id_jenis_diklat, 0);
                    $persen = $resp > 0 ? round(($alumni / $resp) * 100) : ($alumni > 0 ? 100 : 0);

                    $selectedSummaryTable->push([
                        'nama_diklat' => $jd->nama,
                        'jenis_sdm'   => $jd->jenis_sdm,
                        'responden'   => $resp,
                        'alumni'      => $alumni,
                        'persen'      => $persen,
                    ]);
                }
            }
        }

        // 5. OVERALL SUMMARY MATRIX CALCULATION (FOR ALL REGIONS / PROVINCE-WIDE)
        $overallSummaryTable = collect();

        $allIdntIds = GisIdentifikasi::query()
            ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
            ->when($this->filterJenisSdm, fn($q) => $q->where('jenis_sdm', $this->filterJenisSdm))
            ->pluck('id_identifikasi');

        $allIdntDetails = GisIdentifikasiDetail::whereIn('id_identifikasi', $allIdntIds)
            ->selectRaw('id_jenis_diklat, SUM(jumlah_responden) as total_responden')
            ->groupBy('id_jenis_diklat')
            ->pluck('total_responden', 'id_jenis_diklat');

        $allRealDetails = GisRealisasi::query()
            ->when($this->filterTahun, fn($q) => $q->where('tahun', $this->filterTahun))
            ->when($this->filterJenisSdm, fn($q) => $q->whereHas('jenisDiklat', fn($j) => $j->where('jenis_sdm', $this->filterJenisSdm)))
            ->selectRaw('id_jenis_diklat, SUM(jumlah_peserta) as total_peserta')
            ->groupBy('id_jenis_diklat')
            ->pluck('total_peserta', 'id_jenis_diklat');

        $allJenisIds = $allIdntDetails->keys()->merge($allRealDetails->keys())->unique();
        $allJenisDiklats = GisJenisDiklat::whereIn('id_jenis_diklat', $allJenisIds)->get();

        foreach ($allJenisDiklats as $jd) {
            $resp = $allIdntDetails->get($jd->id_jenis_diklat, 0);
            $alumni = $allRealDetails->get($jd->id_jenis_diklat, 0);
            $persen = $resp > 0 ? round(($alumni / $resp) * 100) : ($alumni > 0 ? 100 : 0);

            $overallSummaryTable->push([
                'nama_diklat' => $jd->nama,
                'jenis_sdm'   => $jd->jenis_sdm,
                'responden'   => $resp,
                'alumni'      => $alumni,
                'persen'      => $persen,
            ]);
        }

        // 6. Dropdown Filter Options
        $tahunOptions = GisIdentifikasi::select('tahun')->union(GisRealisasi::select('tahun'))->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('livewire.website.diklat.dashboard', compact(
            'totalResponden',
            'totalKebutuhan',
            'totalPeserta',
            'totalKegiatan',
            'wilayahs',
            'mapData',
            'selectedWilayah',
            'selectedIdentifikasis',
            'selectedRealisasis',
            'selectedSummaryTable',
            'overallSummaryTable',
            'tahunOptions'
        ));
    }
}

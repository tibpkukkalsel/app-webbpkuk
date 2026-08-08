<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Tentang;
use App\Models\Identitas;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function view(Request $request)
    {
        $search = trim($request->query('q', ''));
        $statusAgenda = trim($request->query('status_agenda', ''));
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        $tglDari = $request->query('tgl_dari');
        $tglSampai = $request->query('tgl_sampai');

        $query = Agenda::where('status', 1);

        // Filter Pencarian Kata Kunci
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        // Filter Status Agenda (Sedang Berlangsung, Akan Datang, Selesai)
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        if ($statusAgenda === 'active') {
            $query->where('tgl_awal', '<=', $today)
                  ->where(function ($q) use ($today) {
                      $q->where('tgl_akhir', '>=', $today)
                        ->orWhereNull('tgl_akhir');
                  });
        } elseif ($statusAgenda === 'upcoming') {
            $query->where('tgl_awal', '>', $today);
        } elseif ($statusAgenda === 'ended') {
            $query->where(function ($q) use ($today) {
                $q->where(function ($q2) use ($today) {
                    $q2->whereNotNull('tgl_akhir')->where('tgl_akhir', '<', $today);
                })->orWhere(function ($q2) use ($today) {
                    $q2->whereNull('tgl_akhir')->where('tgl_awal', '<', $today);
                });
            });
        }

        // Filter Bulan
        if (!empty($bulan) && is_numeric($bulan)) {
            $query->where(function ($q) use ($bulan) {
                $q->whereMonth('tgl_awal', $bulan)
                  ->orWhereMonth('tgl_akhir', $bulan);
            });
        }

        // Filter Tahun
        if (!empty($tahun) && is_numeric($tahun)) {
            $query->where(function ($q) use ($tahun) {
                $q->whereYear('tgl_awal', $tahun)
                  ->orWhereYear('tgl_akhir', $tahun);
            });
        }

        // Filter Rentang Tanggal Spesifik
        if (!empty($tglDari)) {
            $query->where(function ($q) use ($tglDari) {
                $q->where('tgl_awal', '>=', $tglDari)
                  ->orWhere('tgl_akhir', '>=', $tglDari);
            });
        }
        if (!empty($tglSampai)) {
            $query->where(function ($q) use ($tglSampai) {
                $q->where('tgl_awal', '<=', $tglSampai);
            });
        }

        $agendas = $query->orderBy('tgl_awal', 'desc')
            ->orderBy('id_agenda', 'desc')
            ->paginate(9)
            ->withQueryString();

        // Data Tahun Unik untuk Dropdown Filter
        $availableYears = Agenda::where('status', 1)
            ->selectRaw('YEAR(tgl_awal) as y')
            ->whereNotNull('tgl_awal')
            ->union(
                Agenda::where('status', 1)
                    ->selectRaw('YEAR(tgl_akhir) as y')
                    ->whereNotNull('tgl_akhir')
            )
            ->pluck('y')
            ->filter()
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        $hasActiveFilter = !empty($search) || !empty($statusAgenda) || !empty($bulan) || !empty($tahun) || !empty($tglDari) || !empty($tglSampai);

        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.agenda.view', compact(
            'agendas',
            'search',
            'statusAgenda',
            'bulan',
            'tahun',
            'tglDari',
            'tglSampai',
            'availableYears',
            'hasActiveFilter',
            'tentang',
            'identitas'
        ));
    }

    public function detail(Request $request, $slug)
    {
        $agenda = Agenda::where('status', 1)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('id_agenda', $slug);
            })
            ->firstOrFail();

        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.agenda.detail', compact(
            'agenda',
            'tentang',
            'identitas'
        ));
    }
}

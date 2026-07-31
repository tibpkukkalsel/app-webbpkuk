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
        $search = $request->query('q');

        $query = Agenda::where('status', 1);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        $agendas = $query->orderBy('id_agenda', 'desc')->paginate(9)->withQueryString();

        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.agenda.view', compact(
            'agendas',
            'search',
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

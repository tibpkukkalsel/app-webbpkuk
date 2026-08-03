<?php

namespace App\Http\Controllers;

use App\Models\FasilitasPemesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FasilitasPemesanController extends Controller
{
    public function view()
    {
        return view('admin.layanan.fasilitas_pemesan.view');
    }

    public function viewKtp(string $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $pemesan = FasilitasPemesan::findOrFail($decryptedId);
        } catch (\Exception $e) {
            abort(404, 'Data pemesan tidak ditemukan.');
        }

        if (!$pemesan->foto_ktp) {
            abort(404, 'Foto KTP tidak tersedia.');
        }

        $ktpPath = $pemesan->foto_ktp;

        // 1. Cek di disk 'local' (Private storage)
        if (Storage::disk('local')->exists($ktpPath)) {
            return Storage::disk('local')->response($ktpPath);
        }
        if (Storage::disk('local')->exists('pemesan_ktp/' . $ktpPath)) {
            return Storage::disk('local')->response('pemesan_ktp/' . $ktpPath);
        }

        // 2. Fallback untuk data lama di disk 'public'
        if (Storage::disk('public')->exists($ktpPath)) {
            return Storage::disk('public')->response($ktpPath);
        }
        if (Storage::disk('public')->exists('pemesan_ktp/' . $ktpPath)) {
            return Storage::disk('public')->response('pemesan_ktp/' . $ktpPath);
        }

        abort(404, 'File foto KTP tidak ditemukan.');
    }
}

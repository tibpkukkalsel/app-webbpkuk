<?php

namespace App\Livewire\Admin\Layanan\FasilitasPemesan;

use App\Models\FasilitasPemesan;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    protected $listeners = [
        'hapusPemesan'
    ];

    public function hapusPemesan($id_pemesanan)
    {
        $pemesan = FasilitasPemesan::findOrFail($id_pemesanan);

        if ($pemesan->foto_ktp) {
            if (Storage::disk('local')->exists($pemesan->foto_ktp)) {
                Storage::disk('local')->delete($pemesan->foto_ktp);
            } elseif (Storage::disk('local')->exists('pemesan_ktp/' . $pemesan->foto_ktp)) {
                Storage::disk('local')->delete('pemesan_ktp/' . $pemesan->foto_ktp);
            } elseif (Storage::disk('public')->exists('pemesan_ktp/' . $pemesan->foto_ktp)) {
                Storage::disk('public')->delete('pemesan_ktp/' . $pemesan->foto_ktp);
            } elseif (Storage::disk('public')->exists($pemesan->foto_ktp)) {
                Storage::disk('public')->delete($pemesan->foto_ktp);
            }
        }

        $pemesan->delete();

        $this->dispatch('pemesan-refresh');
        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data pemesan berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_pemesan.delete');
    }
}

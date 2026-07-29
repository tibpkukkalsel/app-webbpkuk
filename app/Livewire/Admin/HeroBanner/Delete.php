<?php

namespace App\Livewire\Admin\HeroBanner;

use App\Models\HeroBanner;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    public $id_hero_banner;
    public $judul;

    protected $listeners = [
        'konfirmasiHapus'
    ];

    public function konfirmasiHapus($id)
    {
        $data = HeroBanner::findOrFail($id);
        $this->id_hero_banner = $data->id_hero_banner;
        $this->judul = $data->judul;
    }

    public function hapus()
    {
        $data = HeroBanner::findOrFail($this->id_hero_banner);

        if ($data->gambar) {
            Storage::disk('public')->delete('hero-banner/' . $data->gambar);
        }

        $data->delete();

        $this->dispatch('hero-banner-refresh');
        $this->dispatch('close-modal-delete');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Hero banner berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.hero-banner.delete');
    }
}

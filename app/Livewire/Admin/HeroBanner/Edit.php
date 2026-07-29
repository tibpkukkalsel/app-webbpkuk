<?php

namespace App\Livewire\Admin\HeroBanner;

use App\Models\HeroBanner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_hero_banner;
    public $judul;
    public $gambarBaru;
    public $gambarLama;
    public $urutan;
    public $status;

    protected $listeners = [
        'editHeroBanner'
    ];

    public function editHeroBanner($id)
    {
        $data = HeroBanner::findOrFail($id);

        $this->id_hero_banner = $data->id_hero_banner;
        $this->judul          = $data->judul;
        $this->gambarLama     = $data->gambar;
        $this->gambarBaru     = null;
        $this->urutan         = $data->urutan;
        $this->status         = $data->status;
    }

    public function simpan()
    {
        $rules = [
            'judul'      => 'required|string|max:150',
            'gambarBaru' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'urutan'     => 'required|integer|min:1|max:10',
            'status'     => 'required|in:aktif,nonaktif',
        ];

        $this->validate($rules);

        $namaFile = $this->gambarLama;

        if ($this->gambarBaru) {
            if ($this->gambarLama) {
                Storage::disk('public')->delete('hero-banner/' . $this->gambarLama);
            }
            $namaFile = time() . '.' . $this->gambarBaru->getClientOriginalExtension();
            $this->gambarBaru->storeAs('hero-banner', $namaFile, 'public');
        }

        HeroBanner::where('id_hero_banner', $this->id_hero_banner)->update([
            'judul'  => $this->judul,
            'gambar' => $namaFile,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ]);

        $this->dispatch('hero-banner-refresh');
        $this->dispatch('close-modal-edit');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Hero banner berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.hero-banner.edit');
    }
}

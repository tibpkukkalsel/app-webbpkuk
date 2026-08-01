<?php

namespace App\Livewire\Admin\Layanan\FasilitasHalaman;

use App\Models\FasilitasHalaman;
use App\Models\FasilitasRiwayat;
use Livewire\Component;

class Edit extends Component
{
    public $id_halaman;
    public $judul;
    public $slug;
    public $isi;
    public $urutan;
    public $status;

    public function mount($id)
    {
        $halaman = FasilitasHalaman::findOrFail($id);
        $this->id_halaman = $halaman->id_halaman;
        $this->judul      = $halaman->judul;
        $this->slug       = $halaman->slug;
        $this->isi        = $halaman->isi;
        $this->urutan     = $halaman->urutan;
        $this->status     = $halaman->status;
    }

    public function updatedJudul($value)
    {
        $this->slug = FasilitasHalaman::generateSlug($value, $this->id_halaman);
    }

    public function update()
    {
        $this->slug = FasilitasHalaman::generateSlug($this->judul, $this->id_halaman);

        $this->validate([
            'judul'  => 'required|string|max:200',
            'slug'   => 'required|string|max:220|unique:fasilitas_halaman,slug,' . $this->id_halaman . ',id_halaman',
            'isi'    => 'nullable|string',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ], [
            'judul.required' => 'Judul halaman wajib diisi.',
        ]);

        $halaman = FasilitasHalaman::findOrFail($this->id_halaman);
        $halaman->update([
            'judul'  => $this->judul,
            'slug'   => $this->slug,
            'isi'    => $this->isi,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ]);

        FasilitasRiwayat::catatLog(
            aktivitas: 'Edit Halaman Fasilitas',
            deskripsi: "Halaman fasilitas '{$this->judul}' telah diperbarui."
        );

        session()->flash('success', 'Halaman fasilitas berhasil diperbarui!');
        return redirect()->route('fasilitas.halaman.view');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_halaman.edit');
    }
}

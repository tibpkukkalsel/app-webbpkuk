<?php

namespace App\Livewire\Admin\Layanan\FasilitasHalaman;

use App\Models\FasilitasHalaman;
use App\Models\FasilitasRiwayat;
use Livewire\Component;

class Create extends Component
{
    public $judul;
    public $slug;
    public $isi;
    public $urutan = 1;
    public $status = 1;

    public function updatedJudul($value)
    {
        $this->slug = FasilitasHalaman::generateSlug($value);
    }

    public function simpan()
    {
        $this->slug = FasilitasHalaman::generateSlug($this->judul);

        $this->validate([
            'judul'  => 'required|string|max:200',
            'slug'   => 'required|string|max:220|unique:fasilitas_halaman,slug',
            'isi'    => 'nullable|string',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ], [
            'judul.required' => 'Judul halaman wajib diisi.',
        ]);

        $halaman = FasilitasHalaman::create([
            'judul'  => $this->judul,
            'slug'   => $this->slug,
            'isi'    => $this->isi,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ]);

        FasilitasRiwayat::catatLog(
            aktivitas: 'Tambah Halaman Fasilitas',
            deskripsi: "Halaman baru '{$this->judul}' berhasil dibuat."
        );

        session()->flash('success', 'Halaman fasilitas berhasil ditambahkan!');
        return redirect()->route('fasilitas.halaman.view');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_halaman.create');
    }
}

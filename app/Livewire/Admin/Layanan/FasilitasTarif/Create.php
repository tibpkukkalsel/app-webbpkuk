<?php

namespace App\Livewire\Admin\Layanan\FasilitasTarif;

use App\Models\FasilitasTarif;
use Livewire\Component;

class Create extends Component
{
    public $id_fasilitas;
    public $nama;
    public $satuan = 'Hari';
    public $tarif;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status = 1;

    public function mount($id_fasilitas)
    {
        $this->id_fasilitas = $id_fasilitas;
        $this->tanggal_mulai = now()->toDateString();
    }

    public function simpan()
    {
        $this->validate([
            'nama'            => 'required|string|max:100',
            'satuan'          => 'required|string|max:30',
            'tarif'           => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:0,1',
        ]);

        FasilitasTarif::create([
            'id_fasilitas'    => $this->id_fasilitas,
            'nama'            => $this->nama,
            'satuan'          => $this->satuan,
            'tarif'           => $this->tarif,
            'tanggal_mulai'   => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai ?: null,
            'status'          => $this->status,
        ]);

        $this->reset(['nama', 'tarif', 'tanggal_selesai']);
        $this->satuan = 'Hari';
        $this->tanggal_mulai = now()->toDateString();
        $this->status = 1;

        $this->dispatch('tarif-refresh');
        $this->dispatch('tarif-created');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_tarif.create');
    }
}

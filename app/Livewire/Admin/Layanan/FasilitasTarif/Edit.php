<?php

namespace App\Livewire\Admin\Layanan\FasilitasTarif;

use App\Models\FasilitasTarif;
use Livewire\Component;

class Edit extends Component
{
    public $id_tarif;
    public $id_fasilitas;
    public $nama;
    public $satuan;
    public $tarif;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status;

    protected $listeners = [
        'editTarif' => 'loadData'
    ];

    public function loadData($id_tarif)
    {
        $data = FasilitasTarif::findOrFail($id_tarif);
        $this->id_tarif        = $data->id_tarif;
        $this->id_fasilitas    = $data->id_fasilitas;
        $this->nama            = $data->nama;
        $this->satuan          = $data->satuan;
        $this->tarif           = $data->tarif;
        $this->tanggal_mulai   = $data->tanggal_mulai ? $data->tanggal_mulai->format('Y-m-d') : null;
        $this->tanggal_selesai = $data->tanggal_selesai ? $data->tanggal_selesai->format('Y-m-d') : null;
        $this->status          = $data->status;
    }

    public function update()
    {
        $this->validate([
            'nama'            => 'required|string|max:100',
            'satuan'          => 'required|string|max:30',
            'tarif'           => 'required|numeric|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:0,1',
        ]);

        $tarifObj = FasilitasTarif::findOrFail($this->id_tarif);
        $tarifObj->update([
            'nama'            => $this->nama,
            'satuan'          => $this->satuan,
            'tarif'           => $this->tarif,
            'tanggal_mulai'   => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai ?: null,
            'status'          => $this->status,
        ]);

        $this->dispatch('tarif-refresh');
        $this->dispatch('close-edit-tarif-modal');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_tarif.edit');
    }
}

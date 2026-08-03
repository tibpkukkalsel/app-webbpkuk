<?php

namespace App\Livewire\Admin\Pegawai;

use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Seksi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_pegawai;
    public $nama;
    public $nip;
    public $jenis = '1';
    public $foto;
    public $fotoLama;
    public $id_jabatan;
    public $id_seksi;
    public $status = 1;

    protected $listeners = [
        'editPegawai' => 'loadPegawai'
    ];

    public function loadPegawai($id_pegawai)
    {
        $data = Pegawai::findOrFail($id_pegawai);
        $this->id_pegawai = $data->id_pegawai;
        $this->nama = $data->nama;
        $this->nip = $data->nip;
        $this->jenis = (string)($data->jenis ?? '1');
        $this->fotoLama = $data->foto;
        $this->foto = null;
        $this->id_jabatan = $data->id_jabatan;
        $this->id_seksi = $data->id_seksi;
        $this->status = $data->status;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jenis' => 'nullable|in:1,2,3,4',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'id_jabatan' => 'nullable|exists:jabatan,id_jabatan',
            'id_seksi' => 'nullable|exists:seksi,id_seksi',
            'status' => 'required|in:0,1',
        ]);

        $fotoPath = $this->fotoLama;
        if ($this->foto) {
            if ($this->fotoLama && Storage::disk('public')->exists('pegawai/' . $this->fotoLama)) {
                Storage::disk('public')->delete('pegawai/' . $this->fotoLama);
            }
            $filename = time() . '_' . uniqid() . '.' . $this->foto->getClientOriginalExtension();
            $this->foto->storeAs('pegawai', $filename, 'public');
            $fotoPath = $filename;
        }

        Pegawai::where('id_pegawai', $this->id_pegawai)->update([
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jenis' => $this->jenis ?: '1',
            'foto' => $fotoPath,
            'id_jabatan' => $this->id_jabatan ?: null,
            'id_seksi' => $this->id_seksi ?: null,
            'status' => $this->status,
        ]);

        $this->dispatch('pegawai-refresh');
        $this->dispatch('close-edit-modal');
    }

    public function render()
    {
        $jabatanList = Jabatan::where('status', 1)->get();
        $seksiList = Seksi::where('status', 1)->get();

        return view('livewire.admin.pegawai.edit', compact('jabatanList', 'seksiList'));
    }
}

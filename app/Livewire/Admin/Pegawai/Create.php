<?php

namespace App\Livewire\Admin\Pegawai;

use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Seksi;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nama;
    public $nip;
    public $jenis = '1';
    public $foto;
    public $id_jabatan;
    public $id_seksi;
    public $status = 1;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'nip' => 'nullable|string|max:50',
        'jenis' => 'nullable|in:1,2,3,4',
        'foto' => 'nullable|image|max:2048',
        'id_jabatan' => 'nullable|exists:jabatan,id_jabatan',
        'id_seksi' => 'nullable|exists:seksi,id_seksi',
        'status' => 'required|in:0,1',
    ];

    public function simpan()
    {
        $this->validate();

        $fotoPath = null;
        if ($this->foto) {
            $filename = time() . '_' . uniqid() . '.' . $this->foto->getClientOriginalExtension();
            $this->foto->storeAs('pegawai', $filename, 'public');
            $fotoPath = $filename;
        }

        Pegawai::create([
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jenis' => $this->jenis ?: '1',
            'foto' => $fotoPath,
            'id_jabatan' => $this->id_jabatan ?: null,
            'id_seksi' => $this->id_seksi ?: null,
            'status' => $this->status,
        ]);

        $this->reset(['nama', 'nip', 'jenis', 'foto', 'id_jabatan', 'id_seksi', 'status']);
        $this->jenis = '1';
        $this->dispatch('pegawai-refresh');
        $this->dispatch('pegawai-created');
    }

    public function render()
    {
        $jabatanList = Jabatan::where('status', 1)->get();
        $seksiList = Seksi::where('status', 1)->get();

        return view('livewire.admin.pegawai.create', compact('jabatanList', 'seksiList'));
    }
}

<?php

namespace App\Livewire\Admin\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;

class Edit extends Component
{
    public $id_jabatan;
    public $jabatan;
    public $kelas;
    public $status = 1;

    protected $listeners = [
        'editJabatan' => 'loadJabatan'
    ];

    public function loadJabatan($id_jabatan)
    {
        $data = Jabatan::findOrFail($id_jabatan);
        $this->id_jabatan = $data->id_jabatan;
        $this->jabatan = $data->jabatan;
        $this->kelas = $data->kelas;
        $this->status = $data->status;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate([
            'jabatan' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
        ]);

        Jabatan::where('id_jabatan', $this->id_jabatan)->update([
            'jabatan' => $this->jabatan,
            'kelas' => $this->kelas,
            'status' => $this->status,
        ]);

        $this->dispatch('jabatan-refresh');
        $this->dispatch('close-edit-modal');
    }

    public function render()
    {
        return view('livewire.admin.jabatan.edit');
    }
}

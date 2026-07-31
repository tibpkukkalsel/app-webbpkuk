<?php

namespace App\Livewire\Admin\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;

class Create extends Component
{
    public $jabatan;
    public $kelas;
    public $status = 1;

    protected $rules = [
        'jabatan' => 'required|string|max:255',
        'kelas' => 'nullable|string|max:100',
        'status' => 'required|in:0,1',
    ];

    public function simpan()
    {
        $this->validate();

        Jabatan::create([
            'jabatan' => $this->jabatan,
            'kelas' => $this->kelas,
            'status' => $this->status,
        ]);

        $this->reset(['jabatan', 'kelas', 'status']);
        $this->dispatch('jabatan-refresh');
        $this->dispatch('jabatan-created');
    }

    public function render()
    {
        return view('livewire.admin.jabatan.create');
    }
}

<?php

namespace App\Livewire\Admin\Seksi;

use App\Models\Seksi;
use Livewire\Component;

class Create extends Component
{
    public $seksi;
    public $status = 1;

    protected $rules = [
        'seksi' => 'required|string|max:255',
        'status' => 'required|in:0,1',
    ];

    public function simpan()
    {
        $this->validate();

        Seksi::create([
            'seksi' => $this->seksi,
            'status' => $this->status,
        ]);

        $this->reset(['seksi', 'status']);
        $this->dispatch('seksi-refresh');
        $this->dispatch('seksi-created');
    }

    public function render()
    {
        return view('livewire.admin.seksi.create');
    }
}

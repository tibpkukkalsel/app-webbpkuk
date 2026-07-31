<?php

namespace App\Livewire\Admin\Seksi;

use App\Models\Seksi;
use Livewire\Component;

class Edit extends Component
{
    public $id_seksi;
    public $seksi;
    public $status = 1;

    protected $listeners = [
        'editSeksi' => 'loadSeksi'
    ];

    public function loadSeksi($id_seksi)
    {
        $data = Seksi::findOrFail($id_seksi);
        $this->id_seksi = $data->id_seksi;
        $this->seksi = $data->seksi;
        $this->status = $data->status;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->validate([
            'seksi' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        Seksi::where('id_seksi', $this->id_seksi)->update([
            'seksi' => $this->seksi,
            'status' => $this->status,
        ]);

        $this->dispatch('seksi-refresh');
        $this->dispatch('close-edit-modal');
    }

    public function render()
    {
        return view('livewire.admin.seksi.edit');
    }
}

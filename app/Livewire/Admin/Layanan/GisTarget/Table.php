<?php

namespace App\Livewire\Admin\Layanan\GisTarget;

use App\Models\GisTarget;
use App\Models\GisWilayah;
use App\Models\GisJenisDiklat;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterTahun = '';
    public $filterJenisSdm = '';
    public $perPage = 10;

    // Form Modal Properties
    public $showModal = false;
    public $isEdit = false;
    public $id_target;
    public $id_jenis_diklat;
    public $tahun;
    public $target_peserta = 30;
    public $keterangan;
    public $status = 1;

    // Confirm Delete Modal
    public $showDeleteModal = false;
    public $deleteId;

    public function mount()
    {
        $this->tahun = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTahun()
    {
        $this->resetPage();
    }

    public function updatingFilterJenisSdm()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $target = GisTarget::findOrFail($id);
        $this->id_target       = $target->id_target;
        $this->id_jenis_diklat = $target->id_jenis_diklat;
        $this->tahun           = $target->tahun;
        $this->target_peserta  = $target->target_peserta;
        $this->keterangan      = $target->keterangan;
        $this->status          = $target->status ? 1 : 0;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'id_jenis_diklat' => 'required|exists:gis_jenis_diklat,id_jenis_diklat',
            'tahun'           => 'required|integer|min:2010|max:2050',
            'target_peserta'  => 'required|integer|min:0',
            'keterangan'      => 'nullable|string',
            'status'          => 'required|boolean',
        ], [
            'id_jenis_diklat.required' => 'Pilih jenis diklat.',
            'tahun.required'           => 'Isi tahun anggaran.',
            'target_peserta.min'       => 'Target peserta minimal 0.',
        ]);

        GisTarget::updateOrCreate(
            ['id_target' => $this->id_target],
            [
                'id_jenis_diklat' => $this->id_jenis_diklat,
                'tahun'           => $this->tahun,
                'target_peserta'  => $this->target_peserta,
                'keterangan'      => $this->keterangan,
                'status'          => $this->status,
            ]
        );

        $msg = $this->isEdit ? 'Data target diklat berhasil diperbarui.' : 'Data target diklat baru berhasil disimpan.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus($id)
    {
        $target = GisTarget::findOrFail($id);
        $target->status = !$target->status;
        $target->save();

        $msg = 'Status target diklat berhasil diubah.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            GisTarget::destroy($this->deleteId);
            $msg = 'Data target diklat berhasil dihapus.';
            session()->flash('success', $msg);
            $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    private function resetForm()
    {
        $this->reset(['id_target', 'id_jenis_diklat', 'tahun', 'target_peserta', 'keterangan', 'status']);
        $this->tahun = date('Y');
        $this->target_peserta = 30;
        $this->status = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $targets = GisTarget::with(['jenisDiklat'])
            ->when($this->search, function ($q) {
                $q->whereHas('jenisDiklat', function ($j) {
                    $j->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterTahun, function ($q) {
                $q->where('tahun', $this->filterTahun);
            })
            ->when($this->filterJenisSdm, function ($q) {
                $q->whereHas('jenisDiklat', function ($j) {
                    $j->where('jenis_sdm', $this->filterJenisSdm);
                });
            })
            ->orderBy('tahun', 'desc')
            ->orderBy('id_target', 'desc')
            ->paginate($this->perPage);

        $jenisDiklatOptions = GisJenisDiklat::where('status', 1)->orderBy('jenis_sdm')->orderBy('nama')->get();

        return view('livewire.admin.layanan.gis_target.table', compact('targets', 'jenisDiklatOptions'));
    }
}

<?php

namespace App\Livewire\Admin\Layanan\GisJenisDiklat;

use App\Models\GisJenisDiklat;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterJenisSdm = '';
    public $perPage = 10;

    // Form Modal Properties
    public $showModal = false;
    public $isEdit = false;
    public $id_jenis_diklat;
    public $jenis_sdm = 'sdm_koperasi';
    public $nama;
    public $deskripsi;
    public $status = 1;

    // Confirm Delete Modal
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteNama;

    protected $rules = [
        'jenis_sdm' => 'required|in:sdm_koperasi,sdm_umkm',
        'nama'      => 'required|string|max:150',
        'deskripsi' => 'nullable|string',
        'status'    => 'required|boolean',
    ];

    public function updatingSearch()
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
        $data = GisJenisDiklat::findOrFail($id);
        $this->id_jenis_diklat = $data->id_jenis_diklat;
        $this->jenis_sdm       = $data->jenis_sdm;
        $this->nama            = $data->nama;
        $this->deskripsi       = $data->deskripsi;
        $this->status          = $data->status;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        GisJenisDiklat::updateOrCreate(
            ['id_jenis_diklat' => $this->id_jenis_diklat],
            [
                'jenis_sdm' => $this->jenis_sdm,
                'nama'      => $this->nama,
                'deskripsi' => $this->deskripsi,
                'status'    => $this->status,
            ]
        );

        $msg = $this->isEdit ? 'Jenis diklat berhasil diperbarui.' : 'Jenis diklat baru berhasil ditambahkan.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus($id)
    {
        $data = GisJenisDiklat::findOrFail($id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        $msg = 'Status jenis diklat ' . $data->nama . ' berhasil diubah.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);
    }

    public function confirmDelete($id)
    {
        $data = GisJenisDiklat::findOrFail($id);
        $this->deleteId   = $data->id_jenis_diklat;
        $this->deleteNama = $data->nama;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            GisJenisDiklat::destroy($this->deleteId);
            $msg = 'Jenis diklat ' . $this->deleteNama . ' berhasil dihapus.';
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
        $this->reset(['id_jenis_diklat', 'jenis_sdm', 'nama', 'deskripsi', 'status']);
        $this->jenis_sdm = 'sdm_koperasi';
        $this->status = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $jenisDiklats = GisJenisDiklat::when($this->search, function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterJenisSdm, function ($q) {
                $q->where('jenis_sdm', $this->filterJenisSdm);
            })
            ->orderBy('id_jenis_diklat', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.gis_jenis_diklat.table', compact('jenisDiklats'));
    }
}

<?php

namespace App\Livewire\Admin\Layanan\GisWilayah;

use App\Models\GisWilayah;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterJenis = '';
    public $perPage = 10;

    // Form Modal Properties
    public $showModal = false;
    public $isEdit = false;
    public $id_wilayah;
    public $kode_bps;
    public $nama;
    public $jenis = 'kabupaten';
    public $geojson;
    public $latitude;
    public $longitude;
    public $status = 1;

    // Confirm Delete Modal
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteNama;

    protected $rules = [
        'nama'      => 'required|string|max:100',
        'jenis'     => 'required|in:kabupaten,kota',
        'kode_bps'  => 'nullable|string|max:20',
        'latitude'  => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'geojson'   => 'nullable|string',
        'status'    => 'required|boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterJenis()
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
        $wilayah = GisWilayah::findOrFail($id);
        $this->id_wilayah = $wilayah->id_wilayah;
        $this->kode_bps   = $wilayah->kode_bps;
        $this->nama       = $wilayah->nama;
        $this->jenis      = $wilayah->jenis;
        $this->geojson    = $wilayah->geojson;
        $this->latitude   = $wilayah->latitude;
        $this->longitude  = $wilayah->longitude;
        $this->status     = $wilayah->status;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        GisWilayah::updateOrCreate(
            ['id_wilayah' => $this->id_wilayah],
            [
                'kode_bps'  => $this->kode_bps,
                'nama'      => $this->nama,
                'jenis'     => $this->jenis,
                'geojson'   => $this->geojson,
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
                'status'    => $this->status,
            ]
        );

        $msg = $this->isEdit ? 'Data wilayah berhasil diperbarui.' : 'Data wilayah baru berhasil ditambahkan.';
        session()->flash('success', $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus($id)
    {
        $wilayah = GisWilayah::findOrFail($id);
        $wilayah->status = $wilayah->status == 1 ? 0 : 1;
        $wilayah->save();

        session()->flash('success', 'Status wilayah ' . $wilayah->nama . ' berhasil diubah.');
    }

    public function confirmDelete($id)
    {
        $wilayah = GisWilayah::findOrFail($id);
        $this->deleteId   = $wilayah->id_wilayah;
        $this->deleteNama = $wilayah->nama;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            GisWilayah::destroy($this->deleteId);
            session()->flash('success', 'Wilayah ' . $this->deleteNama . ' berhasil dihapus.');
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
        $this->reset(['id_wilayah', 'kode_bps', 'nama', 'jenis', 'geojson', 'latitude', 'longitude', 'status']);
        $this->jenis = 'kabupaten';
        $this->status = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $wilayahs = GisWilayah::when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('kode_bps', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterJenis, function ($q) {
                $q->where('jenis', $this->filterJenis);
            })
            ->orderBy('id_wilayah', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.gis_wilayah.table', compact('wilayahs'));
    }
}

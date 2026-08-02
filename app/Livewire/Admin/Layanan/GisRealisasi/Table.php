<?php

namespace App\Livewire\Admin\Layanan\GisRealisasi;

use App\Models\GisRealisasi;
use App\Models\GisWilayah;
use App\Models\GisJenisDiklat;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterWilayah = '';
    public $filterTahun = '';
    public $filterJenisSdm = '';
    public $perPage = 10;

    // Form Modal Properties
    public $showModal = false;
    public $isEdit = false;
    public $id_realisasi;
    public $id_wilayah;
    public $id_jenis_diklat;
    public $tahun;
    public $jumlah_peserta = 0;
    public $jumlah_kegiatan = 1;
    public $keterangan;

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

    public function updatingFilterWilayah()
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
        $realisasi = GisRealisasi::findOrFail($id);
        $this->id_realisasi     = $realisasi->id_realisasi;
        $this->id_wilayah       = $realisasi->id_wilayah;
        $this->id_jenis_diklat  = $realisasi->id_jenis_diklat;
        $this->tahun            = $realisasi->tahun;
        $this->jumlah_peserta   = $realisasi->jumlah_peserta;
        $this->jumlah_kegiatan  = $realisasi->jumlah_kegiatan;
        $this->keterangan       = $realisasi->keterangan;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'id_wilayah'      => 'required|exists:gis_wilayah,id_wilayah',
            'id_jenis_diklat' => 'required|exists:gis_jenis_diklat,id_jenis_diklat',
            'tahun'           => 'required|integer|min:2010|max:2050',
            'jumlah_peserta'  => 'required|integer|min:0',
            'jumlah_kegiatan' => 'required|integer|min:1',
            'keterangan'      => 'nullable|string',
        ], [
            'id_wilayah.required'      => 'Pilih wilayah kabupaten/kota.',
            'id_jenis_diklat.required' => 'Pilih jenis diklat.',
            'tahun.required'           => 'Isi tahun pelaksanaan.',
            'jumlah_peserta.min'       => 'Jumlah peserta minimal 0.',
            'jumlah_kegiatan.min'      => 'Jumlah kegiatan minimal 1.',
        ]);

        GisRealisasi::updateOrCreate(
            ['id_realisasi' => $this->id_realisasi],
            [
                'id_wilayah'      => $this->id_wilayah,
                'id_jenis_diklat' => $this->id_jenis_diklat,
                'tahun'           => $this->tahun,
                'jumlah_peserta'  => $this->jumlah_peserta,
                'jumlah_kegiatan' => $this->jumlah_kegiatan,
                'keterangan'      => $this->keterangan,
            ]
        );

        $msg = $this->isEdit ? 'Data realisasi diklat berhasil diperbarui.' : 'Data realisasi diklat baru berhasil disimpan.';
        session()->flash('success', $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            GisRealisasi::destroy($this->deleteId);
            session()->flash('success', 'Data realisasi diklat berhasil dihapus.');
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
        $this->reset(['id_realisasi', 'id_wilayah', 'id_jenis_diklat', 'tahun', 'jumlah_peserta', 'jumlah_kegiatan', 'keterangan']);
        $this->tahun = date('Y');
        $this->jumlah_kegiatan = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $realisasis = GisRealisasi::with(['wilayah', 'jenisDiklat'])
            ->when($this->search, function ($q) {
                $q->whereHas('wilayah', function ($w) {
                    $w->where('nama', 'like', '%' . $this->search . '%');
                })->orWhereHas('jenisDiklat', function ($j) {
                    $j->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterWilayah, function ($q) {
                $q->where('id_wilayah', $this->filterWilayah);
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
            ->orderBy('id_realisasi', 'desc')
            ->paginate($this->perPage);

        $wilayahOptions = GisWilayah::where('status', 1)->orderBy('nama')->get();
        $jenisDiklatOptions = GisJenisDiklat::where('status', 1)->orderBy('jenis_sdm')->orderBy('nama')->get();

        return view('livewire.admin.layanan.gis_realisasi.table', compact('realisasis', 'wilayahOptions', 'jenisDiklatOptions'));
    }
}

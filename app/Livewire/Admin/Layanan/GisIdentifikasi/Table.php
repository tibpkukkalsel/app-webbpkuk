<?php

namespace App\Livewire\Admin\Layanan\GisIdentifikasi;

use App\Models\GisIdentifikasi;
use App\Models\GisIdentifikasiDetail;
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
    public $id_identifikasi;
    public $id_wilayah;
    public $tahun;
    public $jenis_sdm = 'sdm_koperasi';
    public $jumlah_responden = 0;
    public $keterangan;
    public $status = 1;

    // Multi-Item Detail breakdown
    public $items = []; // [['id_jenis_diklat' => '', 'jumlah_responden' => 0, 'keterangan' => '']]

    // Detail View Modal
    public $showDetailModal = false;
    public $viewIdentifikasi;

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

    public function updatedJenisSdm()
    {
        // Reset item options when SDM category changes
        $this->items = [];
        $this->tambahItem();
    }

    public function tambahItem()
    {
        $this->items[] = [
            'id_jenis_diklat'  => '',
            'jumlah_responden' => 0,
            'keterangan'       => '',
        ];
    }

    public function hapusItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
        $this->tambahItem();
    }

    public function edit($id)
    {
        $identifikasi = GisIdentifikasi::with('details')->findOrFail($id);
        $this->id_identifikasi  = $identifikasi->id_identifikasi;
        $this->id_wilayah       = $identifikasi->id_wilayah;
        $this->tahun            = $identifikasi->tahun;
        $this->jenis_sdm        = $identifikasi->jenis_sdm;
        $this->jumlah_responden = $identifikasi->jumlah_responden;
        $this->keterangan       = $identifikasi->keterangan;
        $this->status           = $identifikasi->status;

        $this->items = [];
        foreach ($identifikasi->details as $dt) {
            $this->items[] = [
                'id_jenis_diklat'  => $dt->id_jenis_diklat,
                'jumlah_responden' => $dt->jumlah_responden,
                'keterangan'       => $dt->keterangan,
            ];
        }

        if (empty($this->items)) {
            $this->tambahItem();
        }

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'id_wilayah'       => 'required|exists:gis_wilayah,id_wilayah',
            'tahun'            => 'required|integer|min:2010|max:2050',
            'jenis_sdm'        => 'required|in:sdm_koperasi,sdm_umkm',
            'jumlah_responden' => 'required|integer|min:1',
            'items'            => 'required|array|min:1',
            'items.*.id_jenis_diklat'  => 'required|exists:gis_jenis_diklat,id_jenis_diklat',
            'items.*.jumlah_responden' => 'required|integer|min:0',
        ], [
            'id_wilayah.required'       => 'Wilayah kabupaten/kota wajib dipilih.',
            'tahun.required'            => 'Tahun kegiatan wajib diisi.',
            'jumlah_responden.required' => 'Jumlah responden fisik (orang) wajib diisi.',
            'jumlah_responden.min'      => 'Jumlah responden fisik minimal 1 orang.',
            'items.min'                 => 'Minimal tambahkan 1 detail rincian jenis diklat.',
            'items.*.id_jenis_diklat.required' => 'Pilih jenis diklat pada setiap baris.',
        ]);

        $identifikasi = GisIdentifikasi::updateOrCreate(
            ['id_identifikasi' => $this->id_identifikasi],
            [
                'id_wilayah'       => $this->id_wilayah,
                'tahun'            => $this->tahun,
                'jenis_sdm'        => $this->jenis_sdm,
                'jumlah_responden' => $this->jumlah_responden,
                'keterangan'       => $this->keterangan,
                'status'           => $this->status,
            ]
        );

        // Delete existing details and recreate
        GisIdentifikasiDetail::where('id_identifikasi', $identifikasi->id_identifikasi)->delete();

        foreach ($this->items as $it) {
            GisIdentifikasiDetail::create([
                'id_identifikasi'  => $identifikasi->id_identifikasi,
                'id_jenis_diklat'  => $it['id_jenis_diklat'],
                'jumlah_responden' => $it['jumlah_responden'] ?? 0,
                'keterangan'       => $it['keterangan'] ?? '',
            ]);
        }

        $msg = $this->isEdit ? 'Data identifikasi berhasil diperbarui.' : 'Data identifikasi kebutuhan diklat baru berhasil disimpan.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function viewDetail($id)
    {
        $this->viewIdentifikasi = GisIdentifikasi::with(['wilayah', 'details.jenisDiklat'])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function toggleStatus($id)
    {
        $data = GisIdentifikasi::findOrFail($id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        $msg = 'Status identifikasi berhasil diubah.';
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
            GisIdentifikasi::destroy($this->deleteId);
            $msg = 'Data identifikasi berhasil dihapus.';
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

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->viewIdentifikasi = null;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    private function resetForm()
    {
        $this->reset(['id_identifikasi', 'id_wilayah', 'tahun', 'jenis_sdm', 'jumlah_responden', 'keterangan', 'status', 'items']);
        $this->tahun = date('Y');
        $this->jenis_sdm = 'sdm_koperasi';
        $this->status = 1;
        $this->items = [];
        $this->resetErrorBag();
    }

    public function render()
    {
        $identifikasis = GisIdentifikasi::with(['wilayah', 'details.jenisDiklat'])
            ->when($this->search, function ($q) {
                $q->whereHas('wilayah', function ($w) {
                    $w->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterWilayah, function ($q) {
                $q->where('id_wilayah', $this->filterWilayah);
            })
            ->when($this->filterTahun, function ($q) {
                $q->where('tahun', $this->filterTahun);
            })
            ->when($this->filterJenisSdm, function ($q) {
                $q->where('jenis_sdm', $this->filterJenisSdm);
            })
            ->orderBy('tahun', 'desc')
            ->orderBy('id_identifikasi', 'desc')
            ->paginate($this->perPage);

        $wilayahOptions = GisWilayah::where('status', 1)->orderBy('nama')->get();
        $jenisDiklatOptions = GisJenisDiklat::where('jenis_sdm', $this->jenis_sdm)
            ->where('status', 1)
            ->orderBy('nama')
            ->get();

        return view('livewire.admin.layanan.gis_identifikasi.table', compact('identifikasis', 'wilayahOptions', 'jenisDiklatOptions'));
    }
}

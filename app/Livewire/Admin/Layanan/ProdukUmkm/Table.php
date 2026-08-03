<?php

namespace App\Livewire\Admin\Layanan\ProdukUmkm;

use App\Models\GisWilayah;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterWilayah = '';
    public $filterStatus = '';
    public $perPage = 10;

    // Form Modal Properties
    public $showModal = false;
    public $isEdit = false;
    public $id_produkumkm;
    public $id_wilayah;
    public $nama_produk;
    public $nama_umkm;
    public $ukuran;
    public $ketahanan;
    public $pengiriman = 'Pengiriman Seluruh Indonesia';
    public $foto;
    public $oldFoto;
    public $status = 1;

    // Confirm Delete Modal
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteNama;

    protected function rules()
    {
        return [
            'id_wilayah'  => 'required|exists:gis_wilayah,id_wilayah',
            'nama_produk' => 'required|string|max:150',
            'nama_umkm'   => 'required|string|max:150',
            'ukuran'      => 'nullable|string|max:100',
            'ketahanan'   => 'nullable|string|max:100',
            'pengiriman'  => 'nullable|string|max:150',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|boolean',
        ];
    }

    protected $messages = [
        'id_wilayah.required'  => 'Pilih wilayah kabupaten/kota.',
        'id_wilayah.exists'    => 'Wilayah tidak valid.',
        'nama_produk.required' => 'Nama produk wajib diisi.',
        'nama_produk.max'      => 'Nama produk maksimal 150 karakter.',
        'nama_umkm.required'   => 'Nama UMKM wajib diisi.',
        'nama_umkm.max'        => 'Nama UMKM maksimal 150 karakter.',
        'ukuran.max'           => 'Ukuran maksimal 100 karakter.',
        'ketahanan.max'        => 'Ketahanan maksimal 100 karakter.',
        'pengiriman.max'       => 'Pengiriman maksimal 150 karakter.',
        'foto.image'           => 'File harus berupa gambar (jpg, jpeg, png, webp).',
        'foto.max'             => 'Ukuran foto maksimal 2MB.',
        'status.required'      => 'Status wajib dipilih.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterWilayah()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
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
        $produk = ProdukUmkm::findOrFail($id);
        $this->id_produkumkm = $produk->id_produkumkm;
        $this->id_wilayah    = $produk->id_wilayah;
        $this->nama_produk   = $produk->nama_produk;
        $this->nama_umkm     = $produk->nama_umkm;
        $this->ukuran        = $produk->ukuran;
        $this->ketahanan     = $produk->ketahanan;
        $this->pengiriman    = $produk->pengiriman ?: 'Pengiriman Seluruh Indonesia';
        $this->oldFoto       = $produk->foto;
        $this->foto          = null;
        $this->status        = $produk->status;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $fotoPath = $this->oldFoto;

        if ($this->foto) {
            // Store new photo in public storage under 'produk_umkm' directory
            $filename = time() . '_' . uniqid() . '.' . $this->foto->getClientOriginalExtension();
            $this->foto->storeAs('produk_umkm', $filename, 'public');
            $fotoPath = 'produk_umkm/' . $filename;

            // Delete old photo if replacing
            if ($this->isEdit && $this->oldFoto && Storage::disk('public')->exists($this->oldFoto)) {
                Storage::disk('public')->delete($this->oldFoto);
            }
        }

        ProdukUmkm::updateOrCreate(
            ['id_produkumkm' => $this->id_produkumkm],
            [
                'id_wilayah'  => $this->id_wilayah,
                'nama_produk' => $this->nama_produk,
                'nama_umkm'   => $this->nama_umkm,
                'ukuran'      => $this->ukuran,
                'ketahanan'   => $this->ketahanan,
                'pengiriman'  => $this->pengiriman ?: 'Pengiriman Seluruh Indonesia',
                'foto'        => $fotoPath,
                'status'      => $this->status,
            ]
        );

        $msg = $this->isEdit ? 'Data produk UMKM berhasil diperbarui.' : 'Data produk UMKM baru berhasil ditambahkan.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $produk->status = $produk->status == 1 ? 0 : 1;
        $produk->save();

        $msg = 'Status produk ' . $produk->nama_produk . ' berhasil diubah.';
        session()->flash('success', $msg);
        $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);
    }

    public function confirmDelete($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $this->deleteId   = $produk->id_produkumkm;
        $this->deleteNama = $produk->nama_produk;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $produk = ProdukUmkm::find($this->deleteId);
            if ($produk) {
                if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                    Storage::disk('public')->delete($produk->foto);
                }
                $produk->delete();
            }
            $msg = 'Produk UMKM ' . $this->deleteNama . ' berhasil dihapus.';
            session()->flash('success', $msg);
            $this->dispatch('show-swal', icon: 'success', title: 'Berhasil!', text: $msg);
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteNama = null;
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
        $this->reset([
            'id_produkumkm',
            'id_wilayah',
            'nama_produk',
            'nama_umkm',
            'ukuran',
            'ketahanan',
            'foto',
            'oldFoto',
            'status',
        ]);
        $this->pengiriman = 'Pengiriman Seluruh Indonesia';
        $this->status = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $produkUmkms = ProdukUmkm::with('wilayah')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('nama_produk', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_umkm', 'like', '%' . $this->search . '%')
                        ->orWhere('ukuran', 'like', '%' . $this->search . '%')
                        ->orWhere('ketahanan', 'like', '%' . $this->search . '%')
                        ->orWhere('pengiriman', 'like', '%' . $this->search . '%')
                        ->orWhereHas('wilayah', function ($w) {
                            $w->where('nama', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterWilayah, function ($q) {
                $q->where('id_wilayah', $this->filterWilayah);
            })
            ->when($this->filterStatus !== '', function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy('id_produkumkm', 'desc')
            ->paginate($this->perPage);

        $wilayahOptions = GisWilayah::where('status', 1)->orderBy('nama')->get();

        return view('livewire.admin.layanan.produk_umkm.table', compact('produkUmkms', 'wilayahOptions'));
    }
}

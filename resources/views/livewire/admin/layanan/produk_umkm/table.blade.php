<div>
    <!-- FLASH MESSAGE / SWEETALERT NOTIFICATION -->
    @if (session()->has('success'))
        <script>
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4 shadow-lg'
                    }
                });
            }
        </script>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="ti ti-check-circle me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-swal', (data) => {
                if (typeof Swal !== 'undefined') {
                    const evt = Array.isArray(data) ? data[0] : data;
                    Swal.fire({
                        title: evt.title || 'Berhasil!',
                        text: evt.text || 'Data berhasil diproses.',
                        icon: evt.icon || 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-4 shadow-lg'
                        }
                    });
                }
            });
        });
    </script>

    <!-- TOP CONTROLS -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-3">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ms-2">entries</span>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex align-items-center justify-content-end gap-2 flex-wrap">
                <select class="form-select form-select-sm w-auto" wire:model.live="filterWilayah">
                    <option value="">-- Semua Wilayah --</option>
                    @foreach ($wilayahOptions as $wOpt)
                        <option value="{{ $wOpt->id_wilayah }}">{{ $wOpt->nama }}</option>
                    @endforeach
                </select>

                <select class="form-select form-select-sm w-auto" wire:model.live="filterStatus">
                    <option value="">-- Semua Status --</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>

                <input type="text" class="form-control form-control-sm w-auto" placeholder="Cari produk / UMKM..."
                    wire:model.live.debounce.300ms="search">

                <button type="button" class="btn btn-sm btn-primary text-nowrap" wire:click="create">
                    <i class="ti ti-plus me-1"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE TABLE CONTAINER -->
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered align-middle mb-0" style="min-width: 1100px;">
            <thead>
                <tr>
                    <th width="45" class="text-center text-nowrap">No.</th>
                    <th width="70" class="text-center text-nowrap">Foto</th>
                    <th width="200" class="text-center text-nowrap">Nama Produk</th>
                    <th width="180" class="text-center text-nowrap">Nama UMKM</th>
                    <th width="160" class="text-center text-nowrap">Kabupaten / Kota</th>
                    <th width="120" class="text-center text-nowrap">Ukuran</th>
                    <th width="140" class="text-center text-nowrap">Ketahanan</th>
                    <th width="220" class="text-center text-nowrap">Pengiriman</th>
                    <th width="100" class="text-center text-nowrap">Status</th>
                    <th width="120" class="text-center text-nowrap" style="min-width: 110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produkUmkms as $p)
                    <tr wire:key="produk-{{ $p->id_produkumkm }}">
                        <td class="text-center">{{ $produkUmkms->firstItem() + $loop->index }}</td>
                        <td class="text-center">
                            @if ($p->foto && Storage::disk('public')->exists($p->foto))
                                <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama_produk }}"
                                    class="rounded shadow-sm object-fit-cover" width="48" height="48">
                            @else
                                <div class="bg-light text-muted rounded d-inline-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="ti ti-photo fs-4"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $p->nama_produk }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-secondary">{{ $p->nama_umkm }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $p->wilayah->nama ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-dark fw-normal">{{ $p->ukuran ?: '-' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info-subtle text-info fw-normal">{{ $p->ketahanan ?: '-' }}</span>
                        </td>
                        <td class="small text-muted">
                            {{ $p->pengiriman ?: 'Pengiriman Seluruh Indonesia' }}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link p-0 text-decoration-none"
                                wire:click="toggleStatus({{ $p->id_produkumkm }})" title="Klik untuk mengubah status">
                                @if ($p->status == 1)
                                    <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                                @endif
                            </button>
                        </td>
                        <td class="text-center text-nowrap" style="min-width: 110px;">
                            <button type="button" title="Edit" wire:click="edit({{ $p->id_produkumkm }})"
                                class="btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1 border-0">
                                <i class="fs-5 ti ti-pencil"></i>
                            </button>
                            <button type="button" title="Hapus" wire:click="confirmDelete({{ $p->id_produkumkm }})"
                                class="btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center border-0">
                                <i class="fs-5 ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">Tidak ada data produk UMKM.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center text-nowrap">No.</th>
                    <th class="text-center text-nowrap">Foto</th>
                    <th class="text-center text-nowrap">Nama Produk</th>
                    <th class="text-center text-nowrap">Nama UMKM</th>
                    <th class="text-center text-nowrap">Kabupaten / Kota</th>
                    <th class="text-center text-nowrap">Ukuran</th>
                    <th class="text-center text-nowrap">Ketahanan</th>
                    <th class="text-center text-nowrap">Pengiriman</th>
                    <th class="text-center text-nowrap">Status</th>
                    <th class="text-center text-nowrap">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $produkUmkms->firstItem() ?? 0 }} sampai {{ $produkUmkms->lastItem() ?? 0 }} dari
                {{ $produkUmkms->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $produkUmkms->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Data Produk UMKM' : 'Tambah Data Produk UMKM' }}
                        </h4>
                        <button type="button" class="btn-close" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Wilayah Kabupaten / Kota <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('id_wilayah') is-invalid @enderror"
                                        wire:model="id_wilayah">
                                        <option value="">-- Pilih Wilayah Kalsel --</option>
                                        @foreach ($wilayahOptions as $wOpt)
                                            <option value="{{ $wOpt->id_wilayah }}">{{ $wOpt->nama }}
                                                ({{ ucfirst($wOpt->jenis) }})</option>
                                        @endforeach
                                    </select>
                                    @error('id_wilayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                        wire:model="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Produk <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_produk') is-invalid @enderror"
                                        placeholder="Contoh: Sasirangan Motif Khas Banjar" wire:model="nama_produk">
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama UMKM <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_umkm') is-invalid @enderror"
                                        placeholder="Contoh: UMKM Sasirangan Creative" wire:model="nama_umkm">
                                    @error('nama_umkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ukuran</label>
                                    <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                        placeholder="Contoh: 2m x 1.15m / Kemasan 250gr" wire:model="ukuran">
                                    @error('ukuran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ketahanan</label>
                                    <input type="text"
                                        class="form-control @error('ketahanan') is-invalid @enderror"
                                        placeholder="Contoh: 6 Bulan / Tahan Lama" wire:model="ketahanan">
                                    @error('ketahanan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Pengiriman <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('pengiriman') is-invalid @enderror"
                                        placeholder="Pengiriman Seluruh Indonesia" wire:model="pengiriman">
                                    @error('pengiriman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Foto Produk</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        wire:model="foto" accept="image/*">
                                    <div wire:loading wire:target="foto" class="text-primary small mt-1">
                                        <i class="ti ti-loader me-1"></i> Uploading gambar...
                                    </div>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- PREVIEW PHOTO -->
                                    <div class="mt-2">
                                        @if ($foto)
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $foto->temporaryUrl() }}"
                                                    class="rounded shadow-sm object-fit-cover" width="80"
                                                    height="80" alt="Preview Foto">
                                                <small class="text-success fw-semibold">Foto baru terpilih</small>
                                            </div>
                                        @elseif ($oldFoto && Storage::disk('public')->exists($oldFoto))
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('storage/' . $oldFoto) }}"
                                                    class="rounded shadow-sm object-fit-cover" width="80"
                                                    height="80" alt="Foto Saat Ini">
                                                <small class="text-muted">Foto saat ini</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- CONFIRM DELETE MODAL -->
    @if ($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger fw-semibold">
                            <i class="ti ti-alert-circle me-1"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDeleteModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data produk UMKM <strong>"{{ $deleteNama }}"</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="closeDeleteModal">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">
                            <i class="ti ti-trash me-1"></i> Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

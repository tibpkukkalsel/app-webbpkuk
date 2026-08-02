<div>
    <!-- FLASH MESSAGE -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="ti ti-check-circle me-2 fs-5"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TOP CONTROLS (DEFAULT LAYOUT) -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-4">
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

        <div class="col-md-8">
            <div class="d-flex align-items-center justify-content-end gap-2">
                <select class="form-select form-select-sm w-auto" wire:model.live="filterJenis">
                    <option value="">-- Semua Jenis Wilayah --</option>
                    <option value="kabupaten">Kabupaten</option>
                    <option value="kota">Kota</option>
                </select>

                <input type="text" class="form-control form-control-sm w-50" placeholder="Cari wilayah / kode BPS..." wire:model.live.debounce.300ms="search">

                <button type="button" class="btn btn-sm btn-primary text-nowrap" wire:click="create">
                    <i class="ti ti-plus me-1"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- DEFAULT TABLE -->
    <table class="table table-striped table-bordered align-middle mb-0">
        <thead>
            <tr>
                <th width="60" class="text-center">No.</th>
                <th width="110" class="text-center">Kode BPS</th>
                <th class="text-center">Nama Wilayah</th>
                <th width="120" class="text-center">Jenis</th>
                <th class="text-center">Koordinat (Lat, Long)</th>
                <th width="110" class="text-center">Status</th>
                <th width="120" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wilayahs as $w)
                <tr wire:key="wilayah-{{ $w->id_wilayah }}">
                    <td class="text-center">{{ $wilayahs->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        @if($w->kode_bps)
                            <span class="badge bg-info-subtle text-info fw-semibold">{{ $w->kode_bps }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $w->nama }}</div>
                    </td>
                    <td class="text-center">
                        @if($w->jenis === 'kota')
                            <span class="badge bg-info-subtle text-info fw-semibold">Kota</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-semibold">Kabupaten</span>
                        @endif
                    </td>
                    <td class="text-center small">
                        @if($w->latitude && $w->longitude)
                            <code>{{ number_format($w->latitude, 4) }}, {{ number_format($w->longitude, 4) }}</code>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" wire:click="toggleStatus({{ $w->id_wilayah }})">
                            @if ($w->status == 1)
                                <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                            @endif
                        </a>
                    </td>
                    <td class="text-center">
                        <a title="Edit" wire:click="edit({{ $w->id_wilayah }})" class="edit btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-pencil"></i>
                        </a>
                        <a title="Hapus" wire:click="confirmDelete({{ $w->id_wilayah }})" class="hapus btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                            <i class="fs-5 ti ti-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Kode BPS</th>
                <th class="text-center">Nama Wilayah</th>
                <th class="text-center">Jenis</th>
                <th class="text-center">Koordinat (Lat, Long)</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <!-- DEFAULT PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $wilayahs->firstItem() ?? 0 }} sampai {{ $wilayahs->lastItem() ?? 0 }} dari {{ $wilayahs->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $wilayahs->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Data Wilayah' : 'Tambah Data Wilayah' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kode BPS</label>
                                    <input type="text" class="form-control @error('kode_bps') is-invalid @enderror"
                                        placeholder="Contoh: 6371" wire:model="kode_bps">
                                    @error('kode_bps') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Wilayah <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis') is-invalid @enderror" wire:model="jenis">
                                        <option value="kabupaten">Kabupaten</option>
                                        <option value="kota">Kota</option>
                                    </select>
                                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Wilayah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: Kota Banjarmasin" wire:model="nama">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Latitude</label>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        placeholder="-3.3194" wire:model="latitude">
                                    @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        placeholder="114.5908" wire:model="longitude">
                                    @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Status Data</label>
                                    <select class="form-select" wire:model="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- DELETE CONFIRMATION MODAL -->
    @if($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center p-4">
                        <i class="ti ti-alert-circle text-danger display-5 mb-3 d-block"></i>
                        <h5 class="fw-semibold mb-2">Hapus Data?</h5>
                        <p class="text-muted small mb-4">Apakah Anda yakin ingin menghapus <strong>{{ $deleteNama }}</strong>?</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light w-50" wire:click="closeDeleteModal">Batal</button>
                            <button type="button" class="btn btn-danger w-50" wire:click="delete">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

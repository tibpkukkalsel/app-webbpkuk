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
                <select class="form-select form-select-sm w-auto" wire:model.live="filterJenisSdm">
                    <option value="">-- Semua Kategori SDM --</option>
                    <option value="sdm_koperasi">SDM Koperasi</option>
                    <option value="sdm_umkm">SDM UMKM</option>
                </select>

                <input type="text" class="form-control form-control-sm w-50" placeholder="Cari jenis diklat..." wire:model.live.debounce.300ms="search">

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
                <th width="150" class="text-center">Kategori SDM</th>
                <th class="text-center">Nama Program Diklat</th>
                <th class="text-center">Deskripsi Ringkas</th>
                <th width="110" class="text-center">Status</th>
                <th width="120" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenisDiklats as $jd)
                <tr wire:key="jenis-diklat-{{ $jd->id_jenis_diklat }}">
                    <td class="text-center">{{ $jenisDiklats->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        @if($jd->jenis_sdm === 'sdm_koperasi')
                            <span class="badge bg-primary-subtle text-primary fw-semibold">SDM Koperasi</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-semibold">SDM UMKM</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $jd->nama }}</div>
                    </td>
                    <td class="small text-muted">
                        {{ Str::limit($jd->deskripsi, 90) ?: '-' }}
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" wire:click="toggleStatus({{ $jd->id_jenis_diklat }})">
                            @if ($jd->status == 1)
                                <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                            @endif
                        </a>
                    </td>
                    <td class="text-center">
                        <a title="Edit" wire:click="edit({{ $jd->id_jenis_diklat }})" class="edit btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-pencil"></i>
                        </a>
                        <a title="Hapus" wire:click="confirmDelete({{ $jd->id_jenis_diklat }})" class="hapus btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                            <i class="fs-5 ti ti-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Kategori SDM</th>
                <th class="text-center">Nama Program Diklat</th>
                <th class="text-center">Deskripsi Ringkas</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <!-- DEFAULT PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $jenisDiklats->firstItem() ?? 0 }} sampai {{ $jenisDiklats->lastItem() ?? 0 }} dari {{ $jenisDiklats->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $jenisDiklats->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Jenis Diklat' : 'Tambah Jenis Diklat' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Kategori SDM <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_sdm') is-invalid @enderror" wire:model="jenis_sdm">
                                        <option value="sdm_koperasi">SDM Koperasi</option>
                                        <option value="sdm_umkm">SDM UMKM</option>
                                    </select>
                                    @error('jenis_sdm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Program Diklat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: Diklat Manajerial Koperasi Modern" wire:model="nama">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi Ringkas</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                        placeholder="Jelaskan secara singkat target dan materi pelatihan..." wire:model="deskripsi"></textarea>
                                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Status Program</label>
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

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
                    @foreach($wilayahOptions as $wOpt)
                        <option value="{{ $wOpt->id_wilayah }}">{{ $wOpt->nama }}</option>
                    @endforeach
                </select>

                <select class="form-select form-select-sm w-auto" wire:model.live="filterTahun">
                    <option value="">-- Semua Tahun --</option>
                    @foreach(range(date('Y') + 1, 2023) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>

                <select class="form-select form-select-sm w-auto" wire:model.live="filterJenisSdm">
                    <option value="">-- Semua SDM --</option>
                    <option value="sdm_koperasi">SDM Koperasi</option>
                    <option value="sdm_umkm">SDM UMKM</option>
                </select>

                <input type="text" class="form-control form-control-sm w-auto" placeholder="Cari realisasi..." wire:model.live.debounce.300ms="search">

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
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Program Jenis Diklat</th>
                <th width="120" class="text-center">Kategori SDM</th>
                <th width="90" class="text-center">Tahun</th>
                <th width="150" class="text-center">Jumlah Peserta</th>
                <th class="text-center">Keterangan Pelaksanaan</th>
                <th width="120" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($realisasis as $r)
                <tr wire:key="realisasi-{{ $r->id_realisasi }}">
                    <td class="text-center">{{ $realisasis->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $r->wilayah->nama ?? '-' }}</div>
                        <small class="text-muted">{{ ucfirst($r->wilayah->jenis ?? '') }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $r->jenisDiklat->nama ?? '-' }}</div>
                    </td>
                    <td class="text-center">
                        @if(($r->jenisDiklat->jenis_sdm ?? '') === 'sdm_koperasi')
                            <span class="badge bg-primary-subtle text-primary fw-semibold">Koperasi</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-semibold">UMKM</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info-subtle text-info fw-semibold">{{ $r->tahun }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success fw-bold">
                            {{ number_format($r->jumlah_peserta) }} Orang
                        </span>
                    </td>
                    <td class="small text-muted">
                        {{ Str::limit($r->keterangan, 80) ?: '-' }}
                    </td>
                    <td class="text-center">
                        <a title="Edit" wire:click="edit({{ $r->id_realisasi }})" class="edit btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-pencil"></i>
                        </a>
                        <a title="Hapus" wire:click="confirmDelete({{ $r->id_realisasi }})" class="hapus btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                            <i class="fs-5 ti ti-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Kabupaten / Kota</th>
                <th class="text-center">Program Jenis Diklat</th>
                <th class="text-center">Kategori SDM</th>
                <th class="text-center">Tahun</th>
                <th class="text-center">Jumlah Peserta</th>
                <th class="text-center">Keterangan Pelaksanaan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <!-- DEFAULT PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $realisasis->firstItem() ?? 0 }} sampai {{ $realisasis->lastItem() ?? 0 }} dari {{ $realisasis->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $realisasis->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Data Realisasi' : 'Tambah Data Realisasi' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Wilayah Kabupaten / Kota <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_wilayah') is-invalid @enderror" wire:model="id_wilayah">
                                        <option value="">-- Pilih Wilayah Kalsel --</option>
                                        @foreach($wilayahOptions as $wOpt)
                                            <option value="{{ $wOpt->id_wilayah }}">{{ $wOpt->nama }} ({{ ucfirst($wOpt->jenis) }})</option>
                                        @endforeach
                                    </select>
                                    @error('id_wilayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Program Jenis Diklat <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_jenis_diklat') is-invalid @enderror" wire:model="id_jenis_diklat">
                                        <option value="">-- Pilih Jenis Diklat --</option>
                                        @foreach($jenisDiklatOptions as $jdOpt)
                                            <option value="{{ $jdOpt->id_jenis_diklat }}">
                                                [{{ $jdOpt->jenis_sdm === 'sdm_koperasi' ? 'Koperasi' : 'UMKM' }}] {{ $jdOpt->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_jenis_diklat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                        placeholder="2026" wire:model="tahun">
                                    @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jumlah Peserta <span class="text-danger">*</span></label>
                                    <input type="number" min="0" class="form-control text-center fw-bold @error('jumlah_peserta') is-invalid @enderror"
                                        placeholder="30" wire:model="jumlah_peserta">
                                    @error('jumlah_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Keterangan / Lokasi Pelaksanaan</label>
                                    <textarea class="form-control" rows="3" placeholder="Contoh: Dilaksanakan di Hotel Grand Palace Banjarmasin..." wire:model="keterangan"></textarea>
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
                        <p class="text-muted small mb-4">Apakah Anda yakin ingin menghapus data realisasi ini?</p>
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

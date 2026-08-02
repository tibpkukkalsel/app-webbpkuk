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

                <input type="text" class="form-control form-control-sm w-auto" placeholder="Cari data..." wire:model.live.debounce.300ms="search">

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
                <th width="90" class="text-center">Tahun</th>
                <th width="140" class="text-center">Kategori SDM</th>
                <th width="130" class="text-center">Total Responden</th>
                <th class="text-center">Program Diklat Dibutuhkan</th>
                <th width="100" class="text-center">Status</th>
                <th width="130" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($identifikasis as $idnt)
                <tr wire:key="identifikasi-{{ $idnt->id_identifikasi }}">
                    <td class="text-center">{{ $identifikasis->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $idnt->wilayah ? $idnt->wilayah->nama : '-' }}</div>
                        <small class="text-muted">{{ ucfirst($idnt->wilayah->jenis ?? '') }}</small>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info-subtle text-info fw-semibold">{{ $idnt->tahun }}</span>
                    </td>
                    <td class="text-center">
                        @if($idnt->jenis_sdm === 'sdm_koperasi')
                            <span class="badge bg-primary-subtle text-primary fw-semibold">SDM Koperasi</span>
                        @else
                            <span class="badge bg-success-subtle text-success fw-semibold">SDM UMKM</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-secondary-subtle text-dark fw-bold">
                            {{ number_format($idnt->jumlah_responden) }} Orang
                        </span>
                    </td>
                    <td>
                        <ul class="list-unstyled mb-0 small">
                            @forelse($idnt->details->take(2) as $dt)
                                <li class="mb-1">
                                    <i class="ti ti-point text-primary me-1"></i>
                                    <strong>{{ $dt->jenisDiklat->nama ?? 'Diklat' }}</strong>
                                    <span class="text-muted ms-1">({{ $dt->jumlah_responden }} responden)</span>
                                </li>
                            @empty
                                <li class="text-muted">- Belum ada rincian -</li>
                            @endforelse
                            @if($idnt->details->count() > 2)
                                <li class="text-primary fw-semibold">+{{ $idnt->details->count() - 2 }} program lainnya</li>
                            @endif
                        </ul>
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" wire:click="toggleStatus({{ $idnt->id_identifikasi }})">
                            @if ($idnt->status == 1)
                                <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                            @endif
                        </a>
                    </td>
                    <td class="text-center">
                        <a title="Lihat Detail" wire:click="viewDetail({{ $idnt->id_identifikasi }})" class="btn mb-1 bg-info-subtle text-info rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-eye"></i>
                        </a>
                        <a title="Edit" wire:click="edit({{ $idnt->id_identifikasi }})" class="edit btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-pencil"></i>
                        </a>
                        <a title="Hapus" wire:click="confirmDelete({{ $idnt->id_identifikasi }})" class="hapus btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
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
                <th class="text-center">Tahun</th>
                <th class="text-center">Kategori SDM</th>
                <th class="text-center">Total Responden</th>
                <th class="text-center">Program Diklat Dibutuhkan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <!-- DEFAULT PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $identifikasis->firstItem() ?? 0 }} sampai {{ $identifikasis->lastItem() ?? 0 }} dari {{ $identifikasis->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $identifikasis->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Data Identifikasi' : 'Tambah Data Identifikasi' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                            <!-- HEADER INFORMATION -->
                            <div class="row g-3 mb-4 p-3 bg-light rounded border">
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Wilayah Kabupaten / Kota <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_wilayah') is-invalid @enderror" wire:model="id_wilayah">
                                        <option value="">-- Pilih Wilayah --</option>
                                        @foreach($wilayahOptions as $wOpt)
                                            <option value="{{ $wOpt->id_wilayah }}">{{ $wOpt->nama }} ({{ ucfirst($wOpt->jenis) }})</option>
                                        @endforeach
                                    </select>
                                    @error('id_wilayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Tahun Kegiatan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                        placeholder="2026" wire:model="tahun">
                                    @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kategori SDM <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_sdm') is-invalid @enderror" wire:model.live="jenis_sdm">
                                        <option value="sdm_koperasi">SDM Koperasi</option>
                                        <option value="sdm_umkm">SDM UMKM</option>
                                    </select>
                                    @error('jenis_sdm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Keterangan / Catatan Survei</label>
                                    <textarea class="form-control" rows="2" placeholder="Catatan umum mengenai hasil identifikasi di wilayah tersebut..." wire:model="keterangan"></textarea>
                                </div>
                            </div>

                            <!-- MULTI-ITEM DETAIL BREAKDOWN -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-primary"><i class="ti ti-list-check me-1"></i> Rincian Program Diklat yang Dibutuhkan</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="tambahItem">
                                    <i class="ti ti-plus me-1"></i> Tambah Program
                                </button>
                            </div>

                            @error('items')
                                <div class="alert alert-danger py-2 small mb-3">{{ $message }}</div>
                            @enderror

                            <div class="table-responsive border rounded mb-3">
                                <table class="table table-bordered table-sm align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Program Jenis Diklat <span class="text-danger">*</span></th>
                                            <th style="width: 140px;">Jumlah Responden <span class="text-danger">*</span></th>
                                            <th>Keterangan Kebutuhan</th>
                                            <th class="text-center" style="width: 50px;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $idx => $item)
                                            <tr wire:key="item-row-{{ $idx }}">
                                                <td>
                                                    <select class="form-select form-select-sm @error("items.{$idx}.id_jenis_diklat") is-invalid @enderror"
                                                        wire:model.live="items.{{ $idx }}.id_jenis_diklat">
                                                        <option value="">-- Pilih Jenis Diklat --</option>
                                                        @foreach($jenisDiklatOptions as $jdOpt)
                                                            <option value="{{ $jdOpt->id_jenis_diklat }}">{{ $jdOpt->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control form-control-sm text-center fw-bold @error("items.{$idx}.jumlah_responden") is-invalid @enderror"
                                                        wire:model.live="items.{{ $idx }}.jumlah_responden">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" placeholder="Catatan rincian..."
                                                        wire:model="items.{{ $idx }}.keterangan">
                                                </td>
                                                <td class="text-center">
                                                    @if(count($items) > 1)
                                                        <button type="button" class="btn btn-sm btn-light-danger text-danger p-1" wire:click="hapusItem({{ $idx }})">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th class="text-end">Total Akumulasi Responden:</th>
                                            <th class="text-center text-primary font-monospace fw-bold fs-4">
                                                {{ number_format($jumlah_responden) }}
                                            </th>
                                            <th colspan="2">Orang</th>
                                        </tr>
                                    </tfoot>
                                </table>
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

    <!-- DETAIL VIEW MODAL -->
    @if($showDetailModal && $viewIdentifikasi)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">Rincian Identifikasi Kebutuhan Diklat</h4>
                        <button type="button" class="btn-close" wire:click="closeDetailModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <span class="text-muted small d-block">Wilayah</span>
                                <h6 class="fw-bold text-dark mb-0">{{ $viewIdentifikasi->wilayah->nama ?? '-' }}</h6>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Tahun</span>
                                <h6 class="fw-bold text-dark mb-0">{{ $viewIdentifikasi->tahun }}</h6>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Kategori SDM</span>
                                <span class="badge {{ $viewIdentifikasi->jenis_sdm === 'sdm_koperasi' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} fw-bold">
                                    {{ $viewIdentifikasi->jenis_sdm === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                </span>
                            </div>
                            <div class="col-12">
                                <span class="text-muted small d-block">Keterangan Umum</span>
                                <p class="mb-0 text-dark small bg-light p-2 rounded border">{{ $viewIdentifikasi->keterangan ?: 'Tidak ada catatan khusus.' }}</p>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Rincian Program Diklat yang Dibutuhkan</h6>
                        <table class="table table-striped table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th>Program Jenis Diklat</th>
                                    <th class="text-center">Jumlah Responden</th>
                                    <th>Catatan Kebutuhan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($viewIdentifikasi->details as $idx => $dt)
                                    <tr>
                                        <td class="text-center">{{ $idx + 1 }}</td>
                                        <td><strong>{{ $dt->jenisDiklat->nama ?? '-' }}</strong></td>
                                        <td class="text-center text-primary font-monospace fw-bold">{{ number_format($dt->jumlah_responden) }} Orang</td>
                                        <td class="small text-muted">{{ $dt->keterangan ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada rincian program.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
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
                        <p class="text-muted small mb-4">Apakah Anda yakin ingin menghapus data ini?</p>
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

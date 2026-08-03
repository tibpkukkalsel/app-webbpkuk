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

    <!-- TOP CONTROLS & FILTERS -->
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
                <select class="form-select form-select-sm w-auto" wire:model.live="filterTahun">
                    <option value="">-- Semua Tahun --</option>
                    @for ($y = date('Y') + 1; $y >= 2020; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>

                <select class="form-select form-select-sm w-auto" wire:model.live="filterJenisSdm">
                    <option value="">-- Semua Kategori SDM --</option>
                    <option value="sdm_koperasi">SDM Koperasi</option>
                    <option value="sdm_umkm">SDM UMKM</option>
                </select>

                <input type="text" class="form-control form-control-sm w-auto" placeholder="Cari target diklat..."
                    wire:model.live.debounce.300ms="search">

                <button type="button" class="btn btn-sm btn-primary text-nowrap" wire:click="create">
                    <i class="ti ti-plus me-1"></i> Tambah Target
                </button>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE TABLE -->
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered align-middle mb-0" style="min-width: 1000px;">
            <thead>
                <tr>
                    <th width="45" class="text-center text-nowrap">No.</th>
                    <th width="80" class="text-center text-nowrap">Tahun</th>
                    <th width="120" class="text-center text-nowrap">Kategori SDM</th>
                    <th width="240" class="text-center text-nowrap">Jenis Diklat Target</th>
                    <th width="140" class="text-center text-nowrap">Target Peserta</th>
                    <th width="100" class="text-center text-nowrap">Status</th>
                    <th width="120" class="text-center text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($targets as $t)
                    <tr wire:key="target-{{ $t->id_target }}">
                        <td class="text-center">{{ $targets->firstItem() + $loop->index }}</td>
                        <td class="text-center fw-bold text-primary">{{ $t->tahun }}</td>
                        <td class="text-center">
                            @if ($t->jenisDiklat && $t->jenisDiklat->jenis_sdm === 'sdm_koperasi')
                                <span class="badge bg-primary-subtle text-primary fw-semibold">SDM Koperasi</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning fw-semibold">SDM UMKM</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $t->jenisDiklat->nama ?? '-' }}</div>
                            @if ($t->keterangan)
                                <small class="text-muted d-block">{{ Str::limit($t->keterangan, 50) }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info-subtle text-info fs-3 px-3 py-2 fw-bold">
                                <i class="ti ti-users me-1"></i>{{ number_format($t->target_peserta) }} Orang
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link p-0 text-decoration-none"
                                wire:click="toggleStatus({{ $t->id_target }})" title="Klik untuk mengubah status">
                                @if ($t->status)
                                    <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                                @endif
                            </button>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button" title="Edit" wire:click="edit({{ $t->id_target }})"
                                class="btn mb-1 bg-primary-subtle text-primary rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1 border-0">
                                <i class="fs-5 ti ti-pencil"></i>
                            </button>
                            <button type="button" title="Hapus" wire:click="confirmDelete({{ $t->id_target }})"
                                class="btn mb-1 bg-danger-subtle text-danger rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center border-0">
                                <i class="fs-5 ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data target diklat.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center text-nowrap">No.</th>
                    <th class="text-center text-nowrap">Tahun</th>
                    <th class="text-center text-nowrap">Kategori SDM</th>
                    <th class="text-center text-nowrap">Jenis Diklat Target</th>
                    <th class="text-center text-nowrap">Target Peserta</th>
                    <th class="text-center text-nowrap">Status</th>
                    <th class="text-center text-nowrap">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- PAGINATION BOTTOM ROW -->
    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $targets->firstItem() ?? 0 }} sampai {{ $targets->lastItem() ?? 0 }} dari
                {{ $targets->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $targets->links() }}
        </div>
    </div>

    <!-- FORM MODAL (CREATE / EDIT) -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">{{ $isEdit ? 'Edit Target Diklat' : 'Tambah Target Diklat Baru' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Tahun Anggaran <span class="text-danger">*</span></label>
                                    <input type="number" min="2010" max="2050"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        placeholder="Contoh: {{ date('Y') }}" wire:model="tahun">
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Jenis Diklat Target <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_jenis_diklat') is-invalid @enderror" wire:model="id_jenis_diklat">
                                        <option value="">-- Pilih Jenis Diklat --</option>
                                        @foreach ($jenisDiklatOptions as $jOpt)
                                            <option value="{{ $jOpt->id_jenis_diklat }}">
                                                [{{ $jOpt->jenis_sdm === 'sdm_koperasi' ? 'Koperasi' : 'UMKM' }}] {{ $jOpt->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_jenis_diklat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Target Jumlah Peserta (Orang) <span class="text-danger">*</span></label>
                                    <input type="number" min="0"
                                        class="form-control @error('target_peserta') is-invalid @enderror"
                                        placeholder="Contoh: 30" wire:model="target_peserta">
                                    @error('target_peserta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status Target</label>
                                    <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Keterangan / Catatan Tambahan</label>
                                    <textarea rows="2" class="form-control @error('keterangan') is-invalid @enderror"
                                        placeholder="Catatan mengenai alokasi anggaran, tempat, dll..." wire:model="keterangan"></textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Target
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
                            <i class="ti ti-alert-circle me-1"></i> Konfirmasi Hapus Target
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDeleteModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data target diklat ini?
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

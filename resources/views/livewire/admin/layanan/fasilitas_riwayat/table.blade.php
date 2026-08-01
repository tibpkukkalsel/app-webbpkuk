<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
                <span class="ms-2">entries</span>
            </div>
        </div>

        <div class="col-md-6">
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari log / booking / deskripsi..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="55" class="text-center">No.</th>
                    <th width="170" class="text-center">Waktu Log</th>
                    <th width="140" class="text-center">No. Booking</th>
                    <th class="text-center">Aktivitas</th>
                    <th class="text-center">Rincian Deskripsi</th>
                    <th width="140" class="text-center">Pengguna / Admin</th>
                </tr>
            </thead>

            <tbody>
                @forelse($riwayats as $d)
                    <tr wire:key="log-{{ $d->id_riwayat }}">
                        <td class="text-center">{{ $riwayats->firstItem() + $loop->index }}</td>
                        <td class="text-center">
                            <div class="fw-semibold text-dark">{{ $d->created_at ? $d->created_at->format('d-m-Y H:i:s') : '-' }}</div>
                            <small class="text-muted">{{ $d->created_at ? $d->created_at->diffForHumans() : '' }}</small>
                        </td>
                        <td class="text-center">
                            @if($d->nomor_booking)
                                <code class="fw-bold text-primary fs-3">{{ $d->nomor_booking }}</code>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if(str_contains(strtolower($d->aktivitas), 'setuju') || str_contains(strtolower($d->aktivitas), 'disetujui'))
                                <span class="badge bg-success-subtle text-success fw-semibold"><i class="ti ti-check me-1"></i>{{ $d->aktivitas }}</span>
                            @elseif(str_contains(strtolower($d->aktivitas), 'tolak') || str_contains(strtolower($d->aktivitas), 'ditolak'))
                                <span class="badge bg-danger-subtle text-danger fw-semibold"><i class="ti ti-x me-1"></i>{{ $d->aktivitas }}</span>
                            @elseif(str_contains(strtolower($d->aktivitas), 'pengajuan') || str_contains(strtolower($d->aktivitas), 'tambah'))
                                <span class="badge bg-info-subtle text-info fw-semibold"><i class="ti ti-plus me-1"></i>{{ $d->aktivitas }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $d->aktivitas }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-dark">{{ $d->deskripsi }}</div>
                        </td>
                        <td class="text-center">
                            @if($d->user)
                                <span class="fw-semibold text-dark"><i class="ti ti-user me-1"></i>{{ $d->user->name ?? $d->user->username }}</span>
                            @elseif(str_contains(strtolower($d->aktivitas ?? ''), 'online'))
                                <span class="badge bg-info-subtle text-info fw-normal"><i class="ti ti-world me-1"></i> Pemohon Online (Tamu)</span>
                            @else
                                <span class="badge bg-light text-muted fw-normal"><i class="ti ti-robot me-1"></i> Sistem Otomatis</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada catatan log riwayat fasilitas.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Waktu Log</th>
                    <th class="text-center">No. Booking</th>
                    <th class="text-center">Aktivitas</th>
                    <th class="text-center">Rincian Deskripsi</th>
                    <th class="text-center">Pengguna / Admin</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $riwayats->firstItem() ?? 0 }} sampai {{ $riwayats->lastItem() ?? 0 }} dari
                {{ $riwayats->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $riwayats->links() }}
        </div>
    </div>
</div>

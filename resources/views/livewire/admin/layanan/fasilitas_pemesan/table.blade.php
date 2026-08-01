<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 mb-2 mb-md-0">
            <div class="d-flex align-items-center">
                <span class="me-2">Show</span>
                <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="ms-2">entries</span>
            </div>
        </div>

        <div class="col-md-4 mb-2 mb-md-0">
            <select class="form-select form-select-sm" wire:model.live="filterStatus">
                <option value="">-- Semua Status --</option>
                <option value="menunggu">Menunggu Verifikasi</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" placeholder="Cari booking/nama/instansi/hp..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="55" class="text-center">No.</th>
                    <th class="text-center">No. Booking & Tanggal</th>
                    <th class="text-center">Pemohon & Instansi</th>
                    <th class="text-center">Fasilitas yang Dipesan</th>
                    <th class="text-center">Total Biaya</th>
                    <th width="120" class="text-center">Status</th>
                    <th width="100" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pemesanans as $d)
                    <tr wire:key="pemesan-{{ $d->id_pemesanan }}">
                        <td class="text-center">{{ $pemesanans->firstItem() + $loop->index }}</td>
                        <td>
                            <code class="fw-bold text-primary fs-3">{{ $d->nomor_booking }}</code>
                            <div class="small text-muted mt-1">
                                <i class="ti ti-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($d->tanggal_mulai)->format('d/m/Y') }}
                                @if($d->tanggal_mulai != $d->tanggal_selesai)
                                    s.d {{ \Carbon\Carbon::parse($d->tanggal_selesai)->format('d/m/Y') }}
                                @endif
                            </div>
                            @if($d->jam_mulai)
                                <div class="small text-muted">
                                    <i class="ti ti-clock me-1"></i> {{ $d->jam_mulai }} - {{ $d->jam_selesai ?? 'Selesai' }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $d->nama_pemohon }}</div>
                            @if($d->instansi)
                                <small class="text-muted"><i class="ti ti-building me-1"></i>{{ $d->instansi }}</small>
                            @endif
                            @if($d->no_hp)
                                <div class="small text-muted"><i class="ti ti-phone me-1 text-success"></i>{{ $d->no_hp }}</div>
                            @endif
                            @if ($d->foto_ktp && Storage::disk('public')->exists($d->foto_ktp))
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $d->foto_ktp) }}" target="_blank" class="badge bg-info-subtle text-info text-decoration-none border border-info-subtle">
                                        <i class="ti ti-id me-1"></i> Lihat Foto KTP
                                    </a>
                                </div>
                            @else
                                <div class="mt-1">
                                    <span class="badge bg-light text-muted fw-normal border"><i class="ti ti-id-off me-1"></i> KTP: Belum Diunggah</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @forelse($d->details as $det)
                                    <li class="mb-1">
                                        <i class="ti ti-building text-primary me-1"></i>
                                        <strong>{{ $det->fasilitas->nama ?? 'Fasilitas' }}</strong>
                                        <span class="badge bg-light text-dark ms-1">{{ $det->jumlah }} unit</span>
                                        <span class="text-muted ms-1">(Rp {{ number_format($det->subtotal, 0, ',', '.') }})</span>
                                    </li>
                                @empty
                                    <li class="text-muted">- Belum ada item -</li>
                                @endforelse
                            </ul>
                        </td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($d->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if ($d->status == 'disetujui')
                                <span class="badge bg-success-subtle text-success fw-semibold">Disetujui</span>
                            @elseif ($d->status == 'menunggu')
                                <span class="badge bg-warning-subtle text-warning fw-semibold">Menunggu</span>
                            @elseif ($d->status == 'ditolak')
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Ditolak</span>
                            @elseif ($d->status == 'selesai')
                                <span class="badge bg-info-subtle text-info fw-semibold">Selesai</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ ucfirst($d->status) }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light-primary text-primary dropdown-toggle rounded-pill px-3"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical me-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 edit-pemesan"
                                            data-id="{{ $d->id_pemesanan }}" href="javascript:void(0)">
                                            <i class="ti ti-eye text-primary fs-5"></i> Verifikasi / Edit
                                        </a>
                                    </li>
                                    @if ($d->foto_ktp && Storage::disk('public')->exists($d->foto_ktp))
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ asset('storage/' . $d->foto_ktp) }}" target="_blank">
                                                <i class="ti ti-id text-info fs-5"></i> Lihat Foto KTP
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 hapus-pemesan text-danger"
                                            data-id="{{ $d->id_pemesanan }}" href="javascript:void(0)">
                                            <i class="ti ti-trash fs-5"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pemesan fasilitas.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">No. Booking & Tanggal</th>
                    <th class="text-center">Pemohon & Instansi</th>
                    <th class="text-center">Fasilitas yang Dipesan</th>
                    <th class="text-center">Total Biaya</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $pemesanans->firstItem() ?? 0 }} sampai {{ $pemesanans->lastItem() ?? 0 }} dari
                {{ $pemesanans->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $pemesanans->links() }}
        </div>
    </div>
</div>

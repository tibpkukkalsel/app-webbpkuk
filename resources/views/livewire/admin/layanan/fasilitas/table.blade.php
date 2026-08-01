<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
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

        <div class="col-md-6">
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari fasilitas..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="55" class="text-center">No.</th>
                <th width="100" class="text-center">Thumbnail</th>
                <th class="text-center">Nama Fasilitas</th>
                <th width="90" class="text-center">Kode</th>
                <th width="90" class="text-center">Kapasitas</th>
                <th width="90" class="text-center">Jumlah</th>
                <th class="text-center">Lokasi</th>
                <th width="100" class="text-center">Status</th>
                <th width="110" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($fasilitas as $d)
                <tr wire:key="fas-{{ $d->id_fasilitas }}">
                    <td class="text-center">{{ $fasilitas->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        @if ($d->thumbnail && Storage::disk('public')->exists('fasilitas/' . $d->thumbnail))
                            <img src="{{ asset('storage/fasilitas/' . $d->thumbnail) }}" class="img-thumbnail rounded"
                                style="height:60px;width:80px;object-fit:cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto text-muted"
                                style="height:60px;width:80px;font-size:1.4rem;">
                                <i class="ti ti-photo"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $d->nama }}</div>
                        @if ($d->deskripsi)
                            <small class="text-muted">{{ Str::limit($d->deskripsi, 60) }}</small>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($d->kode)
                            <span class="badge bg-info-subtle text-info fw-semibold">{{ $d->kode }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($d->kapasitas)
                            <span class="badge bg-primary-subtle text-primary fw-semibold">{{ $d->kapasitas }}
                                org</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($d->jumlah)
                            <span class="badge bg-warning-subtle text-warning fw-semibold">{{ $d->jumlah }}
                                buah</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $d->lokasi ?? '-' }}</td>
                    <td class="text-center">
                        @if ($d->status == 1)
                            <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
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
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ Route('fasilitas.foto.view', $d->id_fasilitas) }}">
                                        <i class="ti ti-photo text-success fs-5"></i> Kelola Foto
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ Route('fasilitas.tarif.view', $d->id_fasilitas) }}">
                                        <i class="ti ti-cash text-warning fs-5"></i> Kelola Tarif
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 edit"
                                        data-id="{{ $d->id_fasilitas }}" href="javascript:void(0)">
                                        <i class="ti ti-pencil text-primary fs-5"></i> Edit Fasilitas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 hapus text-danger"
                                        data-id="{{ $d->id_fasilitas }}" href="javascript:void(0)">
                                        <i class="ti ti-trash fs-5"></i> Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Thumbnail</th>
                <th class="text-center">Nama Fasilitas</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Kapasitas</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $fasilitas->firstItem() ?? 0 }} sampai {{ $fasilitas->lastItem() ?? 0 }} dari
                {{ $fasilitas->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $fasilitas->links() }}
        </div>
    </div>
</div>

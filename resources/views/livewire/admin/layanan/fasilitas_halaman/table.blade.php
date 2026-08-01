<div>
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
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

        <div class="col-md-6">
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari judul/slug..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="55" class="text-center">No.</th>
                    <th class="text-center">Judul Halaman</th>
                    <th class="text-center">URL Slug</th>
                    <th width="90" class="text-center">Urutan</th>
                    <th width="110" class="text-center">Status</th>
                    <th width="100" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($halamans as $d)
                    <tr wire:key="hal-{{ $d->id_halaman }}">
                        <td class="text-center">{{ $halamans->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $d->judul }}</div>
                            @if($d->isi)
                                <small class="text-muted">{{ Str::limit(strip_tags($d->isi), 80) }}</small>
                            @endif
                        </td>
                        <td>
                            <code class="text-primary">{{ $d->slug }}</code>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $d->urutan }}</span>
                        </td>
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
                                            href="{{ route('fasilitas.halaman.edit', $d->id_halaman) }}">
                                            <i class="ti ti-pencil text-primary fs-5"></i> Edit Halaman
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 hapus-halaman text-danger"
                                            data-id="{{ $d->id_halaman }}" href="javascript:void(0)">
                                            <i class="ti ti-trash fs-5"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data halaman fasilitas.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Judul Halaman</th>
                    <th class="text-center">URL Slug</th>
                    <th class="text-center">Urutan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $halamans->firstItem() ?? 0 }} sampai {{ $halamans->lastItem() ?? 0 }} dari
                {{ $halamans->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $halamans->links() }}
        </div>
    </div>
</div>

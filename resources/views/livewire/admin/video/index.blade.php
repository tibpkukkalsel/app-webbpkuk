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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari Judul..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="40" class="text-center">No.</th>
                    <th width="120" class="text-center">Thumbnail</th>
                    <th width="200" class="text-center">Judul</th>
                    <th width="250" class="text-center">Ringkasan</th>
                    <th width="120" class="text-center">Tanggal</th>
                    <th width="120" class="text-center">Kategori</th>
                    <th width="120" class="text-center">Penulis</th>
                    <th width="100" class="text-center">Status</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($videos as $d)
                <tr wire:key="video-{{ md5($d->id_video) }}">
                    <td class="text-center">{{ $videos->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        @if($d->youtube_id)
                            <a href="https://www.youtube.com/watch?v={{ $d->youtube_id }}" target="_blank">
                                <img src="https://img.youtube.com/vi/{{ $d->youtube_id }}/hqdefault.jpg" class="img-thumbnail" style="height:80px; width:120px; object-fit:cover;">
                            </a>
                        @else
                            <span class="text-muted">No Video</span>
                        @endif
                    </td>
                    <td><b>{{ $d->judul }}</b></td>
                    <td>{{ \Illuminate\Support\Str::limit($d->ringkasan, 70, '...') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $d->kategori?->kategori ?? '-' }}</td>
                    <td class="text-center">{{ $d->user?->name ?? '-' }}</td>
                    <td class="text-center">
                        @if ($d->status == 0)
                            <span class="mb-1 badge text-bg-warning">Draft</span>
                        @elseif ($d->status == 1)
                            <span class="mb-1 badge text-bg-info">Terkirim</span>
                        @elseif ($d->status == 2)
                            <span class="mb-1 badge text-bg-success">Publish</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('video.edit', $d->id_video) }}" title="Lihat Detail / Edit" class="btn mb-1 bg-info-subtle text-info rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                            <i class="fs-5 ti ti-eye"></i>
                        </a>
                        @if (auth()->id() == $d->id_user || auth()->user()->hasRole('Superadmin'))
                            <a href="{{ route('video.edit', $d->id_video) }}" title="Edit" class="btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center me-1">
                                <i class="fs-5 ti ti-pencil"></i>
                            </a>
                            <button type="button" data-id="{{ $d->id_video }}" title="Hapus" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                                <i class="fs-5 ti ti-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data video.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-6">
            <small>Menampilkan {{ $videos->firstItem() ?? 0 }} sampai {{ $videos->lastItem() ?? 0 }} dari {{ $videos->total() }} data</small>
        </div>
        <div class="col-md-6 text-end">
            {{ $videos->links() }}
        </div>
    </div>
</div>

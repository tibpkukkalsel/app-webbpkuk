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

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="40" class="text-center">No.</th>
                <th width="100" class="text-center">Thumbnail</th>
                <th width="200" class="text-center">Judul</th>
                <th width="300" class="text-center">Ringkasan</th>
                <th width="150" class="text-center">Tanggal</th>
                <th width="150" class="text-center">Kategori</th>
                <th width="150" class="text-center">Penulis</th>
                <th width="150" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($post as $d)
            <tr wire:key="berita-{{ md5($d->id_post) }}">
                <td class="text-center">{{ $post->firstItem() + $loop->index }}</td>
                <td style="text-align: center">
                    <img src="{{ asset('storage/berita/'.$d->thumbnail) }}" class="img-thumbnail" style="height:100px;object-fit:cover;">
                </td>
                <td><b>{{ $d->judul }}</b></td>
                <td>{{ \Illuminate\Support\Str::limit($d->ringkasan, 70, '...') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $d->kategori?->kategori ?? '-' }}</td>
                <td class="text-center">{{ $d->user?->name ?? '-' }}</td>
                @if ($d->status == 0)
                    <td style="text-align:center;"><span class="mb-1 badge text-bg-warning">Draft</span></td>
                @elseif ($d->status == 1)
                    <td style="text-align:center;"><span class="mb-1 badge text-bg-info">Terkirim</span></td>
                @elseif ($d->status == 2)
                    <td style="text-align:center;"><span class="mb-1 badge text-bg-success">Publish</span></td>
                @endif
                <td class="text-center">
                @if ($d->status < 2)
                    <a href="{{ route('berita.edit',$d->id_post) }}" class="btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                        <i class="fs-5 ti ti-pencil"></i>
                    </a>
                    <a title="Hapus" data-id="{{ $d->id_post }}" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                        <i class="fs-5 ti ti-trash"></i>
                    </a>
                @endif
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
                <th class="text-center">Judul</th>
                <th class="text-center">Ringkasan</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Penulis</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-8">
            <small>Menampilkan {{ $post->firstItem() ?? 0 }} sampai {{ $post->lastItem() ?? 0 }} dari {{ $post->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $post->links() }}
        </div>
    </div>

</div>
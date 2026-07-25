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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari hashtag..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="100" class="text-center">No.</th>
                <th class="text-center">Hashtag</th>
                <th width="200" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($hashtag as $d)
            <tr wire:key="hashtag-{{ md5($d->id_hashtag) }}">
                <td class="text-center">{{ $hashtag->firstItem() + $loop->index }}</td>
                <td>{{ $d->hashtag }}</td>
                <td class="text-center">
                    <a title="Edit" data-id="{{ $d->id_hashtag }}" class="edit btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-pencil"></i></a>
                    <a title="Hapus" data-id="{{ $d->id_hashtag }}" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-trash"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Hashtag</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $hashtag->firstItem() ?? 0 }} sampai {{ $hashtag->lastItem() ?? 0 }} dari {{ $hashtag->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $hashtag->links() }}
        </div>
    </div>

</div>
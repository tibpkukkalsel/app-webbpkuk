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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari seksi..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="100" class="text-center">No.</th>
                <th class="text-center">Nama Seksi</th>
                <th width="120" class="text-center">Status</th>
                <th width="200" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($seksi as $d)
            <tr wire:key="seksi-{{ md5($d->id_seksi) }}">
                <td class="text-center">{{ $seksi->firstItem() + $loop->index }}</td>
                <td>{{ $d->seksi }}</td>
                <td class="text-center">
                    @if($d->status == 1)
                        <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <a title="Edit" data-id="{{ $d->id_seksi }}" class="edit btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-pencil"></i></a>
                    <a title="Hapus" data-id="{{ $d->id_seksi }}" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-trash"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama Seksi</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $seksi->firstItem() ?? 0 }} sampai {{ $seksi->lastItem() ?? 0 }} dari {{ $seksi->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $seksi->links() }}
        </div>
    </div>
</div>

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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari fasilitas..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="40" class="text-center">No.</th>
                <th width="200" class="text-center">Nama Fasilitas</th>
                <th width="500" class="text-center">Keterangan</th>
                <th width="200" class="text-center">Gambar</th>
                <th width="150" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($fasilitas as $d)
            <tr>
                <td class="text-center">{{ $fasilitas->firstItem() + $loop->index }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->keterangan }}</td>
                <td style="text-align: center">
                    <img src="{{ asset('storage/fasilitas/'.$d->gambar) }}" class="img-thumbnail" style="height:100px;object-fit:cover;">
                </td>
                <td class="text-center">
                    <a title="Edit" data-id="{{ $d->id_fasilitas }}" class="edit btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-pencil"></i></a>
                    <a title="Hapus" data-id="{{ $d->id_fasilitas }}" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-trash"></i></a>
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
                <th width="40" class="text-center">No.</th>
                <th width="200" class="text-center">Nama Fasilitas</th>
                <th class="text-center">Keterangan</th>
                <th width="200" class="text-center">Gambar</th>
                <th width="100" class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $fasilitas->firstItem() ?? 0 }} sampai {{ $fasilitas->lastItem() ?? 0 }} dari {{ $fasilitas->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $fasilitas->links() }}
        </div>
    </div>

</div>
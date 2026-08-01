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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari nama/satuan tarif..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="55" class="text-center">No.</th>
                    <th class="text-center">Nama Jenis Tarif</th>
                    <th width="120" class="text-center">Satuan</th>
                    <th width="150" class="text-center">Nilai Tarif (Rp)</th>
                    <th width="140" class="text-center">Mulai Berlaku</th>
                    <th width="140" class="text-center">Akhir Berlaku</th>
                    <th width="110" class="text-center">Status</th>
                    <th width="100" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tarifs as $d)
                    <tr wire:key="tarif-{{ $d->id_tarif }}">
                        <td class="text-center">{{ $tarifs->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $d->nama }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ $d->satuan }}</span>
                        </td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($d->tarif, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            {{ $d->tanggal_mulai ? \Carbon\Carbon::parse($d->tanggal_mulai)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="text-center">
                            @if($d->tanggal_selesai)
                                {{ \Carbon\Carbon::parse($d->tanggal_selesai)->format('d-m-Y') }}
                            @else
                                <span class="badge bg-light text-muted fw-normal">Seterusnya</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($d->status == 1)
                                <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a title="Edit Tarif" data-id="{{ $d->id_tarif }}"
                                class="edit-tarif btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i
                                    class="fs-5 ti ti-pencil"></i></a>
                            <a title="Hapus Tarif" data-id="{{ $d->id_tarif }}"
                                class="hapus-tarif btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i
                                    class="fs-5 ti ti-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data tarif untuk fasilitas ini.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama Jenis Tarif</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Nilai Tarif (Rp)</th>
                    <th class="text-center">Mulai Berlaku</th>
                    <th class="text-center">Akhir Berlaku</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $tarifs->firstItem() ?? 0 }} sampai {{ $tarifs->lastItem() ?? 0 }} dari
                {{ $tarifs->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $tarifs->links() }}
        </div>
    </div>
</div>

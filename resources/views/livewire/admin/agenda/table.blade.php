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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari agenda..."
                wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="50" class="text-center">No.</th>
                <th class="text-center">Nama Agenda</th>
                <th width="210" class="text-center">Tanggal / Jam</th>
                <th class="text-center">Tempat</th>
                <th class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($agenda as $d)
                <tr>
                    <td class="text-center">{{ $agenda->firstItem() + $loop->index }}</td>
                    <td>{{ $d->nama }}<br></td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($d->tgl_awal)->format('d/m/Y') }}
                        - {{ \Carbon\Carbon::parse($d->tgl_akhir)->format('d/m/Y') }}<br>
                        {{ \Carbon\Carbon::parse($d->jam_mulai)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($d->jam_akhir)->format('H:i') }} WITA
                    </td>
                    <td>{{ $d->tempat }}</td>

                    @if ($d->status == '1')
                        <td style="text-align:center;"><span class="badge bg-success">Publish</span></td>
                    @elseif ($d->status == '0')
                        <td style="text-align:center;"><span class="badge bg-warning">Draft</span></td>
                    @endif
                    <td class="text-center">
                        <a title="Edit" data-id="{{ $d->id_agenda }}"
                            class="edit btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i
                                class="fs-5 ti ti-pencil"></i></a>
                        <a title="Hapus" data-id="{{ $d->id_agenda }}"
                            class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i
                                class="fs-5 ti ti-trash"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th width="50" class="text-center">No.</th>
                <th class="text-center">Nama Agenda</th>
                <th class="text-center">Tanggal / Jam</th>
                <th class="text-center">Tempat</th>
                <th width="60" class="text-center">Status</th>
                <th width="100" class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $agenda->firstItem() ?? 0 }} sampai {{ $agenda->lastItem() ?? 0 }} dari
                {{ $agenda->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $agenda->links() }}
        </div>
    </div>

</div>

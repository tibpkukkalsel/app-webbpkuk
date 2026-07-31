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
            <input type="text" class="form-control form-control-sm w-50 float-end" placeholder="Cari pegawai..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th width="70" class="text-center">No.</th>
                <th width="70" class="text-center">Foto</th>
                <th class="text-center">Nama & NIP</th>
                <th width="150" class="text-center">Jenis Pegawai</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Seksi</th>
                <th width="110" class="text-center">Status</th>
                <th width="160" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pegawai as $d)
            <tr wire:key="pegawai-{{ md5($d->id_pegawai) }}">
                <td class="text-center">{{ $pegawai->firstItem() + $loop->index }}</td>
                <td class="text-center">
                    @if ($d->foto && Storage::disk('public')->exists('pegawai/' . $d->foto))
                        <img src="{{ asset('storage/pegawai/' . $d->foto) }}" alt="{{ $d->nama }}"
                            class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center border mx-auto"
                            style="width: 40px; height: 40px; font-weight: bold; font-size: 0.9rem;">
                            {{ strtoupper(substr($d->nama, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td>
                    <div class="fw-semibold text-dark">{{ $d->nama }}</div>
                    <small class="text-muted">NIP: {{ $d->nip ?? '-' }}</small>
                </td>
                <td class="text-center">
                    @if($d->jenis == '1')
                        <span class="badge bg-info-subtle text-info fw-semibold">PNS</span>
                    @elseif($d->jenis == '2')
                        <span class="badge bg-success-subtle text-success fw-semibold">PPPK Penuh Waktu</span>
                    @elseif($d->jenis == '3')
                        <span class="badge bg-warning-subtle text-warning fw-semibold">PPPK Paruh Waktu</span>
                    @elseif($d->jenis == '4')
                        <span class="badge bg-secondary-subtle text-secondary fw-semibold">PJLP</span>
                    @else
                        <span class="badge bg-light text-dark">-</span>
                    @endif
                </td>
                <td>{{ $d->jabatan?->jabatan ?? '-' }}</td>
                <td>{{ $d->seksi?->seksi ?? '-' }}</td>
                <td class="text-center">
                    @if($d->status == 1)
                        <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger fw-semibold">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <a title="Edit" data-id="{{ $d->id_pegawai }}" class="edit btn mb-1 bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-pencil"></i></a>
                    <a title="Hapus" data-id="{{ $d->id_pegawai }}" class="hapus btn mb-1 bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center"><i class="fs-5 ti ti-trash"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Nama & NIP</th>
                <th class="text-center">Jenis Pegawai</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Seksi</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3 align-items-center">
        <div class="col-md-7">
            <small>Menampilkan {{ $pegawai->firstItem() ?? 0 }} sampai {{ $pegawai->lastItem() ?? 0 }} dari {{ $pegawai->total() }} data</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $pegawai->links() }}
        </div>
    </div>
</div>

<div>
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Gambar Preview</th>
                <th>Judul</th>
                <th width="80" class="text-center">Urutan</th>
                <th width="100" class="text-center">Status</th>
                <th width="110" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($heroBanners as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($d->gambar)
                        <img src="{{ asset('storage/hero-banner/' . $d->gambar) }}"
                             class="img-thumbnail rounded"
                             style="height:80px;width:130px;object-fit:cover;">
                    @else
                        <span class="badge bg-warning-subtle text-warning">Belum ada gambar</span>
                    @endif
                </td>
                <td><strong>{{ $d->judul }}</strong></td>
                <td class="text-center">
                    <span class="badge bg-primary-subtle text-primary fw-bold fs-6">{{ $d->urutan }}</span>
                </td>
                <td class="text-center">
                    @if($d->status === 'aktif')
                        <span class="badge bg-success-subtle text-success">Aktif</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger">Nonaktif</span>
                    @endif
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary btn-edit-hero"
                            data-id="{{ $d->id_hero_banner }}" type="button"
                            title="Edit">
                        <i class="ti ti-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-hapus-hero"
                            data-id="{{ $d->id_hero_banner }}" type="button"
                            title="Hapus">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="ti ti-photo-off fs-3 d-block mb-2"></i>
                    Belum ada gambar hero banner. Klik tombol <strong>+ Tambah Gambar</strong>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $heroBanners->links() }}
    </div>
</div>

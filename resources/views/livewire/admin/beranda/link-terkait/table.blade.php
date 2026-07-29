<div>
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Icon / Logo Website</th>
                <th>Nama Website & Target Link</th>
                <th width="80" class="text-center">Urutan</th>
                <th width="100" class="text-center">Status</th>
                <th width="110" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($linkTerkaitList as $index => $item)
                <tr>
                    <td>{{ $linkTerkaitList->firstItem() + $index }}</td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/link-terkait/' . $item->gambar) }}" alt="{{ $item->nama }}" 
                                 class="img-thumbnail rounded" style="height:60px;width:100px;object-fit:contain;">
                        @else
                            <span class="badge bg-warning-subtle text-warning">Belum ada icon</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->nama }}</strong>
                        @if($item->url)
                            <small class="text-muted d-block mt-1"><i class="ti ti-link me-1"></i><a href="{{ $item->url }}" target="_blank" class="text-primary">{{ $item->url }}</a></small>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary-subtle text-primary fw-bold fs-6">{{ $item->urutan }}</span>
                    </td>
                    <td class="text-center">
                        @if($item->status === 'aktif')
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-edit-link-terkait"
                                data-id="{{ $item->id_link_terkait }}" type="button"
                                title="Edit">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-hapus-link-terkait"
                                data-id="{{ $item->id_link_terkait }}" type="button"
                                title="Hapus">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="ti ti-link-off fs-3 d-block mb-2"></i>
                        Belum ada data link terkait. Klik tombol <strong>+ Tambah Link Terkait</strong>.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $linkTerkaitList->links() }}
    </div>
</div>

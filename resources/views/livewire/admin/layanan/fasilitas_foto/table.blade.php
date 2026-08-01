<div>
    <div class="row g-3">
        @forelse($fotos as $f)
            <div class="col-6 col-md-4 col-lg-3" wire:key="foto-{{ $f->id_foto }}">
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative" style="height: 160px; overflow: hidden; border-radius: 8px 8px 0 0;">
                        @if(Storage::disk('public')->exists('fasilitas_foto/' . $f->foto))
                            <img src="{{ asset('storage/fasilitas_foto/' . $f->foto) }}"
                                 alt="Foto {{ $f->id_foto }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="ti ti-photo fs-2"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 start-0 p-2">
                            <span class="badge bg-dark bg-opacity-60">Urutan #{{ $f->urutan }}</span>
                        </div>
                        <div class="position-absolute top-0 end-0 p-2">
                            @if($f->status == 1)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body py-2 px-3 d-flex justify-content-center gap-2">
                        <a title="Edit" data-id="{{ $f->id_foto }}"
                           class="edit-foto btn bg-primary-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                            <i class="fs-5 ti ti-pencil"></i>
                        </a>
                        <a title="Hapus" data-id="{{ $f->id_foto }}"
                           class="hapus-foto btn bg-danger-subtle rounded-circle round-40 btn-sm d-inline-flex align-items-center justify-content-center">
                            <i class="fs-5 ti ti-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center text-muted py-5">
                    <i class="ti ti-photo-off fs-1 mb-2 d-block"></i>
                    <p>Belum ada foto yang diunggah.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-3">
        <div class="col-md-7">
            <small>Menampilkan {{ $fotos->firstItem() ?? 0 }} sampai {{ $fotos->lastItem() ?? 0 }} dari {{ $fotos->total() }} foto</small>
        </div>
        <div class="col-md-5 text-end">
            {{ $fotos->links() }}
        </div>
    </div>
</div>

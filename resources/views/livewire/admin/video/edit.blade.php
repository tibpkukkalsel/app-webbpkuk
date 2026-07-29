<form wire:submit.prevent="simpan">
    @if($lastSavedAt)
        <div class="alert customize-alert alert-dismissible alert-light-success bg-success-subtle text-success fade show remove-close-icon" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="d-flex align-items-center me-3 me-md-0">
                <i class="ti ti-alert-circle fs-5 me-2 text-success"></i>
                ✓ Draft tersimpan otomatis pukul {{ $lastSavedAt }}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Judul Video :</label>
                        <input type="text" class="form-control" wire:model="judul" oninput="jadwalAutoSave()" placeholder="Masukkan judul video...">
                        @error('judul')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">URL YouTube :</label>
                        <input type="text" class="form-control" wire:model.live.debounce.500ms="url_youtube" oninput="jadwalAutoSave()" placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxxxx atau https://youtu.be/xxxxxxxx">
                        @error('url_youtube')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori :</label>
                        <select class="form-select" wire:model="id_kategori" onchange="jadwalAutoSave()">
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}">
                                    {{ $k->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ringkasan / Deskripsi :</label>
                        <textarea rows="5" class="form-control" wire:model="ringkasan" oninput="jadwalAutoSave()" placeholder="Masukkan ringkasan video..."></textarea>
                        @error('ringkasan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Preview Video & Thumbnail</h5>
                </div>
                <div class="card-body">
                    @if($youtube_id)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Thumbnail Otomatis:</label>
                            <img src="https://img.youtube.com/vi/{{ $youtube_id }}/hqdefault.jpg" class="img-fluid rounded border mb-2" style="height:200px; width:100%; object-fit:cover;">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Embed Preview:</label>
                            <div class="ratio ratio-16x9 rounded overflow-hidden border">
                                <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}" title="YouTube video player" allowfullscreen></iframe>
                            </div>
                        </div>
                    @else
                        <div class="text-center p-4 border rounded bg-light">
                            <i class="ti ti-brand-youtube fs-9 text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tempel URL YouTube untuk melihat preview thumbnail dan player video.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select wire:model="status" class="form-select">
                            <option value="2">Publish</option>
                            <option value="0">Draft</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Website / Instansi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" wire:model="nama" placeholder="Contoh: KEMENTERIAN KOPERASI DAN UKM RI">
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Target URL / Link Website <span class="text-danger">*</span></label>
            <input type="url" class="form-control" wire:model="url" placeholder="https://kemenkopukm.go.id">
            @error('url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Urutan Tampil <span class="text-danger">*</span></label>
                <input type="number" class="form-control" wire:model="urutan" min="1" max="20">
                @error('urutan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select class="form-select" wire:model="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Icon / Logo Website (Opsional)</label>
            <input type="file" class="form-control" wire:model="gambar" accept="image/png,image/jpeg,image/webp,image/svg+xml">
            <small class="text-muted d-block mt-1">Format: PNG, JPG, WEBP, SVG. Maksimal: 2MB.</small>
            @error('gambar') <small class="text-danger">{{ $message }}</small> @enderror

            <div wire:loading wire:target="gambar" class="mt-2">
                <small class="text-primary"><i class="ti ti-loader animate-spin me-1"></i> Mengunggah logo...</small>
            </div>

            @if ($gambar)
                <div class="mt-3">
                    <span class="d-block mb-1 text-muted fs-2">Pratinjau Icon Logo:</span>
                    <img src="{{ $gambar->temporaryUrl() }}" class="img-fluid rounded border p-2" style="max-height: 100px; object-fit: contain;">
                </div>
            @endif
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <i class="ti ti-device-floppy me-1"></i> Simpan
        </button>
    </div>
</form>

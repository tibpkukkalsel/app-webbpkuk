<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Gambar <span class="text-danger">*</span></label>
            <input type="text" class="form-control" wire:model="judul"
                   placeholder="Contoh: Hero Banner 1 – Koperasi Kalsel">
            @error('judul')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Ganti Gambar
                <small class="text-muted fw-normal">(kosongkan jika tidak ingin mengganti)</small>
            </label>
            @if($gambarBaru)
                <div class="text-center mb-2">
                    <img src="{{ $gambarBaru->temporaryUrl() }}" class="img-thumbnail rounded"
                         style="max-height:180px;width:100%;object-fit:cover;">
                </div>
            @elseif($gambarLama)
                <div class="text-center mb-2">
                    <img src="{{ asset('storage/hero-banner/' . $gambarLama) }}" class="img-thumbnail rounded"
                         style="max-height:180px;width:100%;object-fit:cover;">
                </div>
            @endif
            <input type="file" class="form-control" wire:model="gambarBaru" accept="image/*">
            @error('gambarBaru')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div wire:loading wire:target="gambarBaru" class="text-primary mt-2">
                <small><i class="ti ti-loader"></i> Mengupload gambar...</small>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label class="form-label fw-semibold">Urutan <span class="text-danger">*</span></label>
                <input type="number" class="form-control" wire:model="urutan" min="1" max="10">
                @error('urutan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select class="form-select" wire:model="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary"
                wire:loading.attr="disabled" wire:target="simpan">
            <span wire:loading.remove wire:target="simpan">Simpan Perubahan</span>
            <span wire:loading wire:target="simpan">Menyimpan...</span>
        </button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>

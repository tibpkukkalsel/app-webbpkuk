<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" class="form-control" wire:model="foto" accept="image/*">
            @error('foto')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div wire:loading wire:target="foto" class="text-primary mt-1">
                <small>Mengupload foto...</small>
            </div>
            @if($foto)
                <div class="text-center mt-2">
                    <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail rounded" style="max-height:150px;">
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Urutan <small class="text-muted">(0 = pertama)</small></label>
            <input type="number" class="form-control" wire:model="urutan" min="0" placeholder="0">
            @error('urutan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" wire:model="status">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>

<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <h5>{{ $nama }}</h5>
        </div>
        <div class="mb-3">
            <textarea class="form-control" rows="4" wire:model="keterangan"></textarea>
            @error('keterangan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Caption</label>
            <input type="text" class="form-control" wire:model="caption">
        </div>
        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="text" class="form-control" wire:model="link">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
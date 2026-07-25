<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Hashtag</label>
            <input type="text" class="form-control" wire:model="hashtag">
            @error('hashtag')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
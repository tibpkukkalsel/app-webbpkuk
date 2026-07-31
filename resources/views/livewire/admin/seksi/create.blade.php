<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama Seksi</label>
            <input type="text" class="form-control" wire:model="seksi" placeholder="Masukkan nama seksi...">
            @error('seksi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" wire:model="status">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>

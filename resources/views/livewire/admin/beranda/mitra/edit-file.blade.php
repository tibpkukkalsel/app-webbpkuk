<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" wire:model="nama">
        </div>
        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="text" class="form-control" wire:model="link">
             @error('link')
                <small class="text-danger">{{ $message }}</small>
             @enderror
        </div>

        @if($gambar)
            <div class="text-center mb-3">
                <img src="{{ $gambar->temporaryUrl() }}" class="img-thumbnail" style="max-height:150px;">
            </div>
        @elseif($gambarLama)
            <div class="text-center mb-3">
                <img src="{{ asset('storage/beranda/'.$gambarLama) }}" class="img-thumbnail" style="max-height:150px;">
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Pilih Gambar</label>
            <input type="file" class="form-control" wire:model="gambar" accept="image/*">

            @error('gambar')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div wire:loading wire:target="gambar" class="text-primary mt-2">
                Uploading...
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
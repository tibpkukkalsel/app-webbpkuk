<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Thumbnail / Gambar</label>
            <input type="file" class="form-control" wire:model="thumbnail" accept="image/*">
            @error('thumbnail')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div wire:loading wire:target="thumbnail" class="text-primary mt-1">
                <small>Mengupload gambar...</small>
            </div>
            @if($thumbnail)
                <div class="text-center mt-2">
                    <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail rounded" style="max-height:130px;">
                </div>
            @elseif($thumbnailLama)
                <div class="text-center mt-2">
                    <img src="{{ asset('storage/fasilitas/'.$thumbnailLama) }}" class="img-thumbnail rounded" style="max-height:130px;">
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Fasilitas</label>
            <input type="text" class="form-control" wire:model="nama" placeholder="Nama gedung / ruangan...">
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Kode Fasilitas</label>
            <input type="text" class="form-control" wire:model="kode" placeholder="Contoh: GD-01, RG-02...">
            @error('kode')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas <small class="text-muted">(orang/kursi)</small></label>
            <input type="number" class="form-control" wire:model="kapasitas" min="0" placeholder="0">
            @error('kapasitas')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah <small class="text-muted">(gedung/ruangan)</small></label>
            <input type="number" class="form-control" wire:model="jumlah" min="0" placeholder="1">
            @error('jumlah')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" class="form-control" wire:model="lokasi" placeholder="Contoh: Lantai 1 Gedung Utama...">
            @error('lokasi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" rows="4" wire:model="deskripsi" placeholder="Keterangan singkat fasilitas..."></textarea>
            @error('deskripsi')
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
<form wire:submit="simpan">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Layanan :</label>
                        <input type="text" class="form-control" wire:model="nama">
                            @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi :</label>
                        <div wire:ignore>
                            <div id="editor">
                            </div>
                            <hr>
                            <p>{{ $deskripsi }}</p>
                        </div>
                        @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thumbnail</h5>
                </div>
                <div class="card-body">
                    @if($gambar)
                        <img src="{{ $gambar->temporaryUrl() }}" class="img-fluid rounded border mb-3" style="height:220px;width:100%;object-fit:cover;">
                    @else
                        <img src="{{ asset('admins/images/no-image.png') }}" class="img-fluid rounded border mb-3" style="height:220px;width:100%;object-fit:cover;">
                    @endif
                    <input type="file" class="form-control" wire:model="gambar" accept="image/png,image/jpeg,image/webp">
                    @error('gambar')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div wire:loading wire:target="gambar">
                        <small class="text-primary">Uploading...</small>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select wire:model="status" class="form-select">
                            <option value="1">Publish</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ Route('layanan.view') }}" class="btn btn-warning">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

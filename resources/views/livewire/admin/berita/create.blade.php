
<form wire:submit="simpan">
@if($lastSavedAt)
    <div class="alert customize-alert alert-dismissible alert-light-success bg-success-subtle text-success fade show remove-close-icon" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="d-flex align-items-center  me-3 me-md-0">
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
                        <label class="form-label fw-semibold">Judul :</label>
                        <input type="text" class="form-control" wire:model="judul" oninput="jadwalAutoSave()">
                            @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" wire:model="id_kategori" oninput="jadwalAutoSave()">>
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
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Berita :</label>
                        <div wire:ignore>
                            <div id="editor">
                            </div>
                            <hr>
                            <p></p>
                        </div>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ringkasan :</label>
                        <textarea
                            rows="5" class="form-control" wire:model="ringkasan">
                        </textarea>
                        @error('ringkasan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="mt-2">
                            <button
                                type="button" class="btn btn-primary" wire:click="buatRingkasan" wire:loading.attr="disabled" wire:target="buatRingkasan">
                                <i class="ti ti-refresh"></i> Buat Ringkasan AI
                            </button>
                            <span
                                wire:loading wire:target="buatRingkasan" class="ms-2">
                                AI sedang membuat ringkasan...
                            </span>
                        </div>
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
                            <option value="2">Publish</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ Route('berita.view') }}" class="btn btn-warning">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

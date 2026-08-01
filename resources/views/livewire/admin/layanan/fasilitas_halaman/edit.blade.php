<form wire:submit.prevent="update">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold mb-0">Form Konten Halaman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                            placeholder="Contoh: Ketentuan Umum Pemanfaatan Fasilitas"
                            wire:model="judul">
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Isi Konten Halaman <span class="text-danger">*</span></label>
                        <div wire:ignore>
                            <div id="editor" style="min-height: 320px;">{!! $isi !!}</div>
                        </div>
                        @error('isi') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold mb-0">Pengaturan Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Menu <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control @error('urutan') is-invalid @enderror"
                            wire:model="urutan">
                        <small class="text-muted">Menentukan posisi tampilan menu di sidebar website (dimulai dari 1).</small>
                        @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status Tampil <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                            <option value="1">Aktif (Tampil di Website)</option>
                            <option value="0">Nonaktif (Sembunyikan)</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('fasilitas.halaman.view') }}" class="btn btn-light w-50">Batal</a>
                        <button type="submit" class="btn btn-primary w-50" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="ti ti-device-floppy me-1"></i> Update</span>
                            <span wire:loading><i class="ti ti-spinner icon-spin me-1"></i> Mengupdate...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

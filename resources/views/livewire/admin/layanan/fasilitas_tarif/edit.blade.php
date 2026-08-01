<form wire:submit.prevent="update">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Jenis Tarif <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                placeholder="Contoh: Tarif Reguler, Tarif Akhir Pekan, Sewa Per Hari" wire:model="nama">
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                    placeholder="Jam / Hari / Kegiatan / Orang" wire:model="satuan">
                @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nilai Tarif (Rp) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('tarif') is-invalid @enderror"
                    placeholder="0" wire:model="tarif">
                @error('tarif') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Mulai Berlaku <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                    wire:model="tanggal_mulai">
                @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Akhir Berlaku</label>
                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                    wire:model="tanggal_selesai">
                <small class="text-muted">Kosongkan jika berlaku seterusnya</small>
                @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
            <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Update</span>
            <span wire:loading><i class="ti ti-spinner icon-spin me-1"></i> Mengupdate...</span>
        </button>
    </div>
</form>

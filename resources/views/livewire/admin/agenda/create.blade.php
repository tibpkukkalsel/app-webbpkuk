<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama Agenda</label>
            <input type="text" class="form-control" wire:model="nama">
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" rows="2" wire:model="deskripsi"></textarea>
            @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="row col-12"> 
            <div class="mb-3 col-6">
                <label class="form-label">Tanggal Dimulai</label>
                <input type="date" class="form-control" wire:model="tglAwal">
                @error('tglMulai')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3 col-6">
                <label class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" wire:model="tglAkhir">
                @error('tglAkhir')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row col-12"> 
            <div class="mb-3 col-6">
                <label class="form-label">Jam Dimulai</label>
                <input type="time" class="form-control" wire:model="jamMulai">
                @error('jamMulai')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3 col-6">
                <label class="form-label">Jam Berakhir</label>
                <input type="time" class="form-control" wire:model="jamAkhir">
                @error('jamAkhir')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row col-12">
            <div class="mb-3 col-8">
                <label class="form-label">Tempat</label>
                <input type="text" class="form-control" wire:model="tempat">
                @error('tempat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3 col-4">
                <label class="form-label">Status</label>
                <select wire:model="status" class="form-select">
                    <option value="1">Publish</option>
                    <option value="0">Draft</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn bg-primary-subtle text-primary">Simpan</button>
        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
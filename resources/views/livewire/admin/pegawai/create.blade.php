<form wire:submit="simpan">
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" wire:model="nama" placeholder="Masukkan nama pegawai...">
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" class="form-control" wire:model="nip" placeholder="Masukkan NIP pegawai...">
            @error('nip')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Pegawai</label>
            <select class="form-select" wire:model="jenis">
                <option value="1">PNS</option>
                <option value="2">PPPK Penuh Waktu</option>
                <option value="3">PPPK Paruh Waktu</option>
                <option value="4">PJLP</option>
            </select>
            @error('jenis')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select class="form-select" wire:model="id_jabatan">
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatanList as $j)
                    <option value="{{ $j->id_jabatan }}">{{ $j->jabatan }}</option>
                @endforeach
            </select>
            @error('id_jabatan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Seksi / Subbagian</label>
            <select class="form-select" wire:model="id_seksi">
                <option value="">-- Pilih Seksi --</option>
                @foreach($seksiList as $s)
                    <option value="{{ $s->id_seksi }}">{{ $s->seksi }}</option>
                @endforeach
            </select>
            @error('id_seksi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Pegawai</label>
            <input type="file" class="form-control" wire:model="foto" accept="image/*">
            @error('foto')
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

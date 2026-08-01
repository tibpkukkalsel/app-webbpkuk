<form wire:submit.prevent="update">
    <div class="modal-body">
        <div class="alert alert-info d-flex align-items-center mb-3">
            <i class="ti ti-info-circle fs-6 me-2"></i>
            <div>
                <strong>Nomor Booking:</strong> <code class="fs-4 fw-bold text-primary">{{ $nomor_booking }}</code>
            </div>
        </div>

        <div class="card bg-light border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="ti ti-user me-2"></i>Data Pemohon</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Pemohon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror"
                            placeholder="Nama lengkap pemohon" wire:model="nama_pemohon">
                        @error('nama_pemohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                            placeholder="Nomor Induk Kependudukan" wire:model="nik">
                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Instansi / Organisasi</label>
                        <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                            placeholder="Contoh: PT. ABC / Pribadi" wire:model="instansi">
                        @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="email@example.com" wire:model="email">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="0812xxxxxxx" wire:model="no_hp">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            wire:model="tanggal_mulai">
                        @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            wire:model="tanggal_selesai">
                        @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror"
                            wire:model="jam_mulai">
                        @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror"
                            wire:model="jam_selesai">
                        @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Pemohon</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" rows="2"
                        placeholder="Alamat lengkap..." wire:model="alamat"></textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keperluan / Tujuan Pemanfaatan</label>
                    <textarea class="form-control @error('keperluan') is-invalid @enderror" rows="2"
                        placeholder="Penjelasan kegiatan atau acara..." wire:model="keperluan"></textarea>
                    @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Dynamic Items Rincian Fasilitas yang Dipesan --}}
        <div class="card border mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="ti ti-building me-2"></i>Rincian Fasilitas yang Dipesan</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addItem">
                    <i class="ti ti-plus me-1"></i> Tambah Fasilitas
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fasilitas / Gedung <span class="text-danger">*</span></th>
                                <th width="100">Jumlah</th>
                                <th width="160">Tarif per Unit (Rp)</th>
                                <th width="170">Subtotal (Rp)</th>
                                <th width="60" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                <tr>
                                    <td>
                                        <select class="form-select @error('items.'.$index.'.id_fasilitas') is-invalid @enderror"
                                            wire:change="selectFasilitas({{ $index }}, $event.target.value)">
                                            <option value="">-- Pilih Fasilitas --</option>
                                            @foreach($fasilitasOptions as $f)
                                                <option value="{{ $f->id_fasilitas }}" {{ ($item['id_fasilitas'] == $f->id_fasilitas) ? 'selected' : '' }}>
                                                    {{ $f->nama }} (Kapasitas: {{ $f->kapasitas ?? '-' }} org)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('items.'.$index.'.id_fasilitas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <input type="number" min="1" class="form-control"
                                            value="{{ $item['jumlah'] }}"
                                            wire:change="updateJumlah({{ $index }}, $event.target.value)">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            value="{{ $item['tarif'] }}"
                                            wire:change="updateTarif({{ $index }}, $event.target.value)">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control fw-bold bg-light text-end"
                                            value="Rp {{ number_format($item['subtotal'], 0, ',', '.') }}" readonly>
                                    </td>
                                    <td class="text-center">
                                        @if(count($items) > 1)
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1"
                                                wire:click="removeItem({{ $index }})">
                                                <i class="ti ti-trash fs-5"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end fw-bold">Total Keseluruhan:</th>
                                <th class="text-end fw-bold text-success fs-5">
                                    Rp {{ number_format($this->totalKeseluruhan, 0, ',', '.') }}
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Foto KTP</label>
                @if ($fotoKtpLama && Storage::disk('public')->exists($fotoKtpLama))
                    <div class="mb-2 p-2 border rounded bg-light text-center">
                        <a href="{{ asset('storage/' . $fotoKtpLama) }}" target="_blank">
                            <img src="{{ asset('storage/' . $fotoKtpLama) }}" class="img-fluid rounded border shadow-sm" style="max-height: 120px; object-fit: cover;">
                        </a>
                        <div class="mt-1">
                            <a href="{{ asset('storage/' . $fotoKtpLama) }}" target="_blank" class="btn btn-xs btn-outline-info">
                                <i class="ti ti-file-search me-1"></i> Buka Foto KTP Ukuran Penuh
                            </a>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('foto_ktp') is-invalid @enderror" wire:model="foto_ktp">
                <small class="text-muted">Pilih berkas baru jika ingin mengganti KTP</small>
                @error('foto_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status Pengajuan <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                    <option value="menunggu">Menunggu Verifikasi</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan Admin</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" rows="2"
                placeholder="Catatan verifikasi atau keterangan khusus..." wire:model="catatan"></textarea>
            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Update & Verifikasi</span>
            <span wire:loading><i class="ti ti-spinner icon-spin me-1"></i> Mengupdate...</span>
        </button>
    </div>
</form>

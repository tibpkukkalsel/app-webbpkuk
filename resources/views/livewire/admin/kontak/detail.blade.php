<div class="card card-body p-4">
    @if(!$kontak)
        <div class="text-center py-5 my-4 text-muted">
            <i class="ti ti-mail-opened fs-9 text-primary mb-3 d-block"></i>
            <h5 class="fw-semibold text-dark mb-1">Detail Pesan Kontak</h5>
            <p class="fs-3 mb-0">Pilih salah satu pesan dari daftar di sebelah kiri untuk melihat isi pesan dan mengirim balasan email.</p>
        </div>
    @else
        {{-- Header Pesan --}}
        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
            <div>
                <h5 class="fw-bold mb-1 text-dark">{{ $kontak->subjek }}</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-2 text-muted"><i class="ti ti-calendar me-1"></i>{{ $kontak->created_at->format('d M Y, H:i') }} WIB</span>
                    @if($kontak->status === 'unread')
                        <span class="badge bg-danger">Belum Dibaca</span>
                    @elseif($kontak->status === 'read')
                        <span class="badge bg-warning text-dark">Sudah Dibaca</span>
                    @else
                        <span class="badge bg-success">Sudah Dibalas</span>
                    @endif
                </div>
            </div>
            <button wire:click="resetKontak" class="btn btn-sm btn-outline-secondary">
                <i class="ti ti-x me-1"></i>Tutup
            </button>
        </div>

        {{-- Alert Notifikasi --}}
        @if (session()->has('success'))
            <script>
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Berhasil Dibalas!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            </script>
            <div class="alert alert-success alert-dismissible fade show text-sm py-2 px-3 mb-3" role="alert">
                <i class="ti ti-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show text-sm py-2 px-3 mb-3" role="alert">
                <i class="ti ti-alert-triangle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Profil Pengirim --}}
        <div class="bg-light p-3 rounded-3 mb-4">
            <div class="row g-2 fs-3">
                <div class="col-md-6">
                    <span class="text-muted d-block">Pengirim:</span>
                    <strong class="text-dark"><i class="ti ti-user me-1"></i>{{ $kontak->nama }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block">Email:</span>
                    <strong class="text-dark"><i class="ti ti-mail me-1"></i><a href="mailto:{{ $kontak->email }}">{{ $kontak->email }}</a></strong>
                </div>
                @if($kontak->telepon)
                    <div class="col-md-6 mt-2">
                        <span class="text-muted d-block">No. Telepon / WA:</span>
                        <strong class="text-dark"><i class="ti ti-phone me-1"></i>{{ $kontak->telepon }}</strong>
                    </div>
                @endif
                @if($kontak->ip_address)
                    <div class="col-md-6 mt-2">
                        <span class="text-muted d-block">IP Address:</span>
                        <span class="badge bg-secondary fs-1">{{ $kontak->ip_address }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Isi Pesan Pengunjung --}}
        <div class="mb-4">
            <h6 class="fw-semibold text-dark mb-2"><i class="ti ti-message-dots me-1 text-primary"></i>Isi Pesan Pengunjung:</h6>
            <div class="p-3 bg-light-primary text-dark rounded-3 border border-primary-subtle fs-3" style="white-space: pre-line;">{{ $kontak->pesan }}</div>
        </div>

        {{-- Riwayat Balasan Admin (Tabel/Thread Balasan) --}}
        @if($kontak->balasan && $kontak->balasan->count() > 0)
            <div class="mb-4">
                <h6 class="fw-semibold text-dark mb-3"><i class="ti ti-history me-1 text-success"></i>Riwayat Balasan Admin ({{ $kontak->balasan->count() }}):</h6>
                <div class="d-flex flex-column gap-3">
                    @foreach($kontak->balasan as $item)
                        <div class="card card-body p-3 mb-0 bg-light-success border border-success-subtle">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fs-2 text-muted">
                                    <strong class="text-dark"><i class="ti ti-user-check me-1"></i>{{ $item->user ? $item->user->name : 'Admin' }}</strong>
                                    membalas pada {{ $item->created_at->format('d M Y H:i') }} WIB
                                </div>
                                <span class="badge bg-success fs-1"><i class="ti ti-send me-1"></i>Terkirim</span>
                            </div>
                            <div class="fw-semibold text-dark fs-3 mb-1">Subjek: {{ $item->subjek_balasan }}</div>
                            <div class="text-dark fs-3" style="white-space: pre-line;">{{ $item->pesan_balasan }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Form Balasan Email --}}
        @can('kontak.reply')
            <div class="border-top pt-4">
                <h6 class="fw-semibold text-dark mb-3"><i class="ti ti-send me-1 text-primary"></i>Kirim Balasan Email</h6>
                <form wire:submit.prevent="sendReply">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark fs-2">Subjek Email Balasan</label>
                        <input type="text" wire:model="subjek_balasan" class="form-control @error('subjek_balasan') is-invalid @enderror" placeholder="Re: {{ $kontak->subjek }}">
                        @error('subjek_balasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark fs-2">Pesan Balasan</label>
                        <textarea wire:model="pesan_balasan" rows="5" class="form-control @error('pesan_balasan') is-invalid @enderror" placeholder="Tuliskan jawaban atau informasi respon untuk pengunjung di sini..."></textarea>
                        @error('pesan_balasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="sendReply">
                                <i class="ti ti-send me-1"></i> Kirim Email Balasan
                            </span>
                            <span wire:loading wire:target="sendReply">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span> Mengirim Email...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endcan
    @endif
</div>

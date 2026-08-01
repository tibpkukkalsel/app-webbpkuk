@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tarif Fasilitas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('fasilitas.view') }}">Fasilitas</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Tarif &mdash; {{ $fasilitas->nama }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admins/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Fasilitas Card --}}
    <div class="card shadow-none border mb-4">
        <div class="card-body d-flex align-items-center gap-3">
            @if ($fasilitas->thumbnail && Storage::disk('public')->exists('fasilitas/' . $fasilitas->thumbnail))
                <img src="{{ asset('storage/fasilitas/' . $fasilitas->thumbnail) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    <i class="ti ti-building"></i>
                </div>
            @endif
            <div>
                <h5 class="mb-0 fw-bold">{{ $fasilitas->nama }}</h5>
                <small class="text-muted">
                    {{ $fasilitas->kode ? 'Kode: ' . $fasilitas->kode : '' }}
                    @if($fasilitas->kode) &nbsp;|&nbsp; @endif
                    Kapasitas: {{ $fasilitas->kapasitas ?? '-' }} orang &nbsp;|&nbsp;
                    Lokasi: {{ $fasilitas->lokasi ?? '-' }}
                </small>
            </div>
            <div class="ms-auto">
                <a href="{{ Route('fasilitas.view') }}" class="btn btn-sm bg-secondary-subtle text-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Kembali ke Fasilitas
                </a>
            </div>
        </div>
    </div>

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-1">Kelola Histori & Tarif Fasilitas</h4>
                        <p class="card-subtitle text-muted mb-0">Atur skema tarif fasilitas dan periode berlakunya tanpa mengubah riwayat pemesanan lama.</p>
                    </div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-tarif-modal">
                        <i class="ti ti-plus me-1"></i> Tambah Tarif
                    </a>
                </div>

                {{-- Modal Tambah Tarif --}}
                <div class="modal fade" id="tambah-tarif-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title">Tambah Tarif Fasilitas</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <livewire:admin.layanan.fasilitas-tarif.create :id_fasilitas="$fasilitas->id_fasilitas" />
                        </div>
                    </div>
                </div>
                {{-- End Modal Tambah --}}

                <livewire:admin.layanan.fasilitas-tarif.table :id_fasilitas="$fasilitas->id_fasilitas" />
                <livewire:admin.layanan.fasilitas-tarif.delete />

                {{-- Modal Edit Tarif --}}
                <div class="modal fade" id="edit-tarif-modal" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title">Edit Tarif Fasilitas</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <livewire:admin.layanan.fasilitas-tarif.edit />
                        </div>
                    </div>
                </div>
                {{-- End Modal Edit --}}
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script>
$(document).on('click', '.edit-tarif', function () {
    let id = $(this).data('id');
    Livewire.dispatch('editTarif', { id_tarif: id });
    new bootstrap.Modal(document.getElementById('edit-tarif-modal')).show();
});
</script>

<script>
$(document).on('click', '.hapus-tarif', function () {
    let id = $(this).data('id');
    Swal.fire({
        title: 'Hapus tarif ini?',
        text: 'Data tarif yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('hapusTarif', { id_tarif: id });
            Swal.fire({ title: 'Berhasil!', text: 'Tarif berhasil dihapus.', icon: 'success', timer: 1500, showConfirmButton: false });
        }
    });
});
</script>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('tarif-created', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambah-tarif-modal'));
        if (modal) modal.hide();
        Swal.fire({ title: 'Berhasil!', text: 'Tarif berhasil ditambahkan.', icon: 'success', timer: 1500, showConfirmButton: false });
    });

    Livewire.on('close-edit-tarif-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('edit-tarif-modal'));
        if (modal) modal.hide();
        Swal.fire({ title: 'Berhasil!', text: 'Tarif berhasil diperbarui.', icon: 'success', timer: 1500, showConfirmButton: false });
    });
});
</script>
@endpush

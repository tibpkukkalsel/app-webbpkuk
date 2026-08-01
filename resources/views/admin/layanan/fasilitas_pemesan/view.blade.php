@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kelola Data Pemesan Fasilitas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('fasilitas.view') }}">Fasilitas</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Data Pemesan</li>
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

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-1">Daftar Pengajuan & Booking Pemesan</h4>
                        <p class="card-subtitle text-muted mb-0">Verifikasi status pengajuan pemanfaatan fasilitas dan kelola data booking.</p>
                    </div>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-pemesan-modal">
                        <i class="ti ti-plus me-1"></i> Input Booking Manual
                    </a>
                </div>

                {{-- Modal Tambah Pemesan --}}
                <div class="modal fade" id="tambah-pemesan-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title">Input Pemesanan Manual</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <livewire:admin.layanan.fasilitas-pemesan.create />
                        </div>
                    </div>
                </div>
                {{-- End Modal Tambah --}}

                <livewire:admin.layanan.fasilitas-pemesan.table />
                <livewire:admin.layanan.fasilitas-pemesan.delete />

                {{-- Modal Edit Pemesan --}}
                <div class="modal fade" id="edit-pemesan-modal" tabindex="-1" wire:ignore.self>
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title">Verifikasi & Detail Pemesanan</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <livewire:admin.layanan.fasilitas-pemesan.edit />
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
$(document).on('click', '.edit-pemesan', function () {
    let id = $(this).data('id');
    Livewire.dispatch('editPemesan', { id_pemesanan: id });
    new bootstrap.Modal(document.getElementById('edit-pemesan-modal')).show();
});
</script>

<script>
$(document).on('click', '.hapus-pemesan', function () {
    let id = $(this).data('id');
    Swal.fire({
        title: 'Hapus data pemesan ini?',
        text: 'Data booking yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('hapusPemesan', { id_pemesanan: id });
            Swal.fire({ title: 'Berhasil!', text: 'Data pemesan berhasil dihapus.', icon: 'success', timer: 1500, showConfirmButton: false });
        }
    });
});
</script>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('pemesan-created', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('tambah-pemesan-modal'));
        if (modal) modal.hide();
        Swal.fire({ title: 'Berhasil!', text: 'Pemesanan berhasil disimpan.', icon: 'success', timer: 1500, showConfirmButton: false });
    });

    Livewire.on('close-edit-pemesan-modal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('edit-pemesan-modal'));
        if (modal) modal.hide();
        Swal.fire({ title: 'Berhasil!', text: 'Data pemesanan berhasil diperbarui.', icon: 'success', timer: 1500, showConfirmButton: false });
    });
});
</script>
@endpush

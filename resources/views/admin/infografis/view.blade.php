@extends('layouts.admins')

@section('content')
    {{-- Page Header --}}
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Infografis</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Infografis Slider</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admins/images/breadcrumb/ChatBc.png') }}" alt="infografis" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-semibold mb-0">Kelola Infografis Slider Carousel</h5>
                    <small class="text-muted">Gambar infografis yang aktif akan tampil pada Slider Carousel di halaman utama website.</small>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2" id="btn-tambah-infografis">
                    <i class="ti ti-plus"></i> Tambah Infografis
                </button>
            </div>

            {{-- Livewire Table Infografis --}}
            <div class="table-responsive">
                <livewire:admin.infografis.table />
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalCreateInfografis" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-photo-plus me-2"></i>Tambah Infografis</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.infografis.create />
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="modalEditInfografis" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-pencil me-2"></i>Edit Infografis</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.infografis.edit />
                    </div>
                </div>
            </div>

            {{-- Modal Hapus --}}
            <div class="modal fade" id="modalDeleteInfografis" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.infografis.delete />
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('myscript')
<script>
    document.getElementById('btn-tambah-infografis').addEventListener('click', function () {
        new bootstrap.Modal(document.getElementById('modalCreateInfografis')).show();
    });

    $(document).on('click', '.btn-edit-infografis', function () {
        let id = $(this).attr('data-id');
        Livewire.dispatch('editInfografis', { id: id });
        new bootstrap.Modal(document.getElementById('modalEditInfografis')).show();
    });

    $(document).on('click', '.btn-hapus-infografis', function () {
        let id = $(this).attr('data-id');
        Livewire.dispatch('konfirmasiHapusInfografis', { id: id });
        new bootstrap.Modal(document.getElementById('modalDeleteInfografis')).show();
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('close-modal-create', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalCreateInfografis'))?.hide();
        });
        Livewire.on('close-modal-edit', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalEditInfografis'))?.hide();
        });
        Livewire.on('close-modal-delete-infografis', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalDeleteInfografis'))?.hide();
        });
    });
</script>
@endpush

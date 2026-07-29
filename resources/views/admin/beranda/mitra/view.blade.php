@extends('layouts.admins')

@section('content')
    {{-- Page Header --}}
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Link Terkait</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Link Terkait</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admins/images/breadcrumb/ChatBc.png') }}" alt="link-terkait" class="img-fluid mb-n4" />
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
                    <h4 class="card-title mb-0">Kelola Link Terkait Website</h4>
                    <small class="text-muted">Daftar logo icon dan link website instansi / mitra terkait yang tampil di halaman beranda.</small>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2" id="btn-tambah-link-terkait">
                    <i class="ti ti-plus"></i> Tambah Link Terkait
                </button>
            </div>

            {{-- Livewire Table Link Terkait --}}
            <div class="table-responsive">
                <livewire:admin.beranda.link-terkait.table />
            </div>

            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalCreateLink" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-link me-2"></i>Tambah Link Terkait</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.beranda.link-terkait.create />
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="modalEditLink" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-pencil me-2"></i>Edit Link Terkait</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.beranda.link-terkait.edit />
                    </div>
                </div>
            </div>

            {{-- Modal Hapus --}}
            <div class="modal fade" id="modalDeleteLink" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.beranda.link-terkait.delete />
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('myscript')
<script>
    document.getElementById('btn-tambah-link-terkait').addEventListener('click', function () {
        new bootstrap.Modal(document.getElementById('modalCreateLink')).show();
    });

    $(document).on('click', '.btn-edit-link-terkait', function () {
        let id = $(this).attr('data-id');
        Livewire.dispatch('editLinkTerkait', { id: id });
        new bootstrap.Modal(document.getElementById('modalEditLink')).show();
    });

    $(document).on('click', '.btn-hapus-link-terkait', function () {
        let id = $(this).attr('data-id');
        Livewire.dispatch('konfirmasiHapusLinkTerkait', { id: id });
        new bootstrap.Modal(document.getElementById('modalDeleteLink')).show();
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('close-modal-create-link', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalCreateLink'))?.hide();
        });
        Livewire.on('close-modal-edit-link', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalEditLink'))?.hide();
        });
        Livewire.on('close-modal-delete-link', () => {
            bootstrap.Modal.getInstance(document.getElementById('modalDeleteLink'))?.hide();
        });
    });
</script>
@endpush
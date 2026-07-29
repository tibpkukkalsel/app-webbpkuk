@extends('layouts.admins')

@section('content')
    {{-- Page Header --}}
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Hero Banner</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Hero Banner</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admins/images/breadcrumb/ChatBc.png') }}" alt="banner"
                            class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Container Card --}}
    <div class="card">
        <div class="card-header bg-transparent border-bottom">
            <ul class="nav nav-pills card-header-pills fs-4" id="bannerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="hero-banner-tab" data-bs-toggle="tab"
                        data-bs-target="#hero-banner-pane" type="button" role="tab">
                        <i class="ti ti-slideshow me-1"></i> Background (Slideshow)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="banner-utama-tab" data-bs-toggle="tab"
                        data-bs-target="#banner-utama-pane" type="button" role="tab">
                        <i class="ti ti-layout-board-split me-1"></i> Teks
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="bannerTabsContent">

                {{-- TAB 1: HERO BANNER --}}
                <div class="tab-pane fade show active" id="hero-banner-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-semibold mb-0">Kelola Gambar Hero Banner</h5>
                            <small class="text-muted">Gambar yang aktif akan tampil sebagai latar belakang slideshow pada
                                halaman utama website.</small>
                        </div>
                        <button class="btn btn-primary d-flex align-items-center gap-2" id="btn-tambah-hero">
                            <i class="ti ti-plus"></i> Tambah Gambar
                        </button>
                    </div>

                    {{-- Livewire Table Hero Banner --}}
                    <div class="table-responsive">
                        <livewire:admin.hero-banner.table />
                    </div>
                </div>

                {{-- TAB 2: BANNER UTAMA --}}
                <div class="tab-pane fade" id="banner-utama-pane" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-semibold mb-0">Kelola Konten Hero Banner</h5>
                            <small class="text-muted">Pengaturan teks judul, deskripsi, dan file pendukung Banner Utama di
                                beranda.</small>
                        </div>
                    </div>

                    {{-- Livewire Table Banner Utama --}}
                    <div class="table-responsive">
                        <livewire:admin.beranda.bannerutama.table />
                    </div>
                </div>

            </div>

            {{-- Modals for Hero Banner --}}
            <div class="modal fade" id="modalCreate" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-photo-plus me-2"></i>Tambah Hero Banner</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.hero-banner.create />
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEdit" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title"><i class="ti ti-pencil me-2"></i>Edit Hero Banner</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.hero-banner.edit />
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDelete" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Konfirmasi Hapus
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.hero-banner.delete />
                    </div>
                </div>
            </div>

            {{-- Modals for Banner Utama --}}
            <div class="modal fade" id="editdata" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title">Edit Banner Utama</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.beranda.bannerutama.edit-text />
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editfile" tabindex="-1" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title">Upload Gambar</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <livewire:admin.beranda.bannerutama.edit-file />
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('myscript')
    <script>
        // Hero Banner Scripts
        document.getElementById('btn-tambah-hero').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('modalCreate')).show();
        });

        $(document).on('click', '.btn-edit-hero', function() {
            let id = $(this).attr('data-id');
            Livewire.dispatch('editHeroBanner', {
                id: id
            });
            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        });

        $(document).on('click', '.btn-hapus-hero', function() {
            let id = $(this).attr('data-id');
            Livewire.dispatch('konfirmasiHapus', {
                id: id
            });
            new bootstrap.Modal(document.getElementById('modalDelete')).show();
        });

        // Banner Utama Scripts
        $(document).on('click', '.edit-text', function() {
            let id = $(this).attr('data-id');
            Livewire.dispatch('editText', {
                id_beranda: id
            });
            new bootstrap.Modal(document.getElementById('editdata')).show();
        });

        $(document).on('click', '.edit-file', function() {
            let id = $(this).attr('data-id');
            Livewire.dispatch('editFile', {
                id_beranda: id
            });
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editfile')).show();
        });

        // Close Modal Listeners
        document.addEventListener('livewire:init', () => {
            Livewire.on('close-modal-create', () => {
                bootstrap.Modal.getInstance(document.getElementById('modalCreate'))?.hide();
            });
            Livewire.on('close-modal-edit', () => {
                bootstrap.Modal.getInstance(document.getElementById('modalEdit'))?.hide();
            });
            Livewire.on('close-modal-delete', () => {
                bootstrap.Modal.getInstance(document.getElementById('modalDelete'))?.hide();
            });
            Livewire.on('close-edit-text', () => {
                bootstrap.Modal.getInstance(document.getElementById('editdata'))?.hide();
            });
            Livewire.on('close-edit-file', () => {
                bootstrap.Modal.getInstance(document.getElementById('editfile'))?.hide();
            });
        });
    </script>
@endpush

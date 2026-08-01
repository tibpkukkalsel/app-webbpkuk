@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kelola Halaman Fasilitas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('fasilitas.view') }}">Fasilitas</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Kelola Halaman</li>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-1">Daftar Halaman Fasilitas Website</h4>
                        <p class="card-subtitle text-muted mb-0">Kelola konten informasi, ketentuan sewa, dan alur prosedur pemanfaatan fasilitas.</p>
                    </div>
                    <a href="{{ route('fasilitas.halaman.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Halaman
                    </a>
                </div>

                <livewire:admin.layanan.fasilitas-halaman.table />
            </div>
        </div>
    </div>
@endsection

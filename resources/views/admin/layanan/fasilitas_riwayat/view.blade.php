@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Riwayat Log Fasilitas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('fasilitas.view') }}">Fasilitas</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Riwayat Log</li>
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
                <div class="mb-3">
                    <h4 class="card-title mb-1">Daftar Log Aktivitas Fasilitas & Pemesanan</h4>
                    <p class="card-subtitle text-muted mb-0">Lacak riwayat perubahan status booking, tarif, dan aktivitas pengolahan data fasilitas secara real-time.</p>
                </div>

                <livewire:admin.layanan.fasilitas-riwayat.table />
            </div>
        </div>
    </div>
@endsection

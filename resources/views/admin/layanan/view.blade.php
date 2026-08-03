@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">
                        @if ($tab === 'wilayah')
                            Data Wilayah Kalsel
                        @elseif ($tab === 'jenis_diklat')
                            Jenis Diklat SDM
                        @elseif ($tab === 'identifikasi')
                            Identifikasi Kebutuhan Diklat
                        @elseif ($tab === 'target')
                            Target Diklat
                        @elseif ($tab === 'realisasi')
                            Realisasi Diklat
                        @else
                            Dashboard Diklat
                        @endif
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-muted" aria-current="page">Layanan</li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Diklat</li>
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
                    <h4 class="card-title mb-0">
                        @if ($tab === 'wilayah')
                            Data Wilayah Kalsel
                        @elseif ($tab === 'jenis_diklat')
                            Jenis Diklat SDM (Koperasi & UMKM)
                        @elseif ($tab === 'identifikasi')
                            Identifikasi Kebutuhan Diklat (Responden)
                        @elseif ($tab === 'target')
                            Target Diklat (Tahun Anggaran)
                        @elseif ($tab === 'realisasi')
                            Realisasi Diklat
                        @else
                            Data
                        @endif
                    </h4>
                </div>

                <div class="table-responsive">
                    @if ($tab === 'wilayah')
                        <livewire:admin.layanan.gis-wilayah.table />
                    @elseif ($tab === 'jenis_diklat')
                        <livewire:admin.layanan.gis-jenis-diklat.table />
                    @elseif ($tab === 'identifikasi')
                        <livewire:admin.layanan.gis-identifikasi.table />
                    @elseif ($tab === 'target')
                        <livewire:admin.layanan.gis-target.table />
                    @elseif ($tab === 'realisasi')
                        <livewire:admin.layanan.gis-realisasi.table />
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-swal', (data) => {
                const evt = Array.isArray(data) ? data[0] : data;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: evt.title || 'Berhasil!',
                        text: evt.text || 'Data berhasil diproses.',
                        icon: evt.icon || 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-4 shadow-lg'
                        }
                    });
                }
            });
        });
    </script>
@endpush
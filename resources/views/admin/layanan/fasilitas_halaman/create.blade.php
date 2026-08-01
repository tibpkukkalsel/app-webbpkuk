@extends('layouts.admins')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tambah Halaman Fasilitas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ Route('fasilitas.halaman.view') }}">Kelola Halaman</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Buat Baru</li>
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

    <livewire:admin.layanan.fasilitas-halaman.create />
@endsection

@push('myscript')
    <script src="{{ asset('admins/libs/quill/dist/quill.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:navigated', initQuill);
        document.addEventListener('livewire:initialized', initQuill);

        function initQuill() {
            if (window.quill) return;
            const editorEl = document.querySelector('#editor');
            if (!editorEl) return;

            window.quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tuliskan isi konten halaman ketentuan/informasi fasilitas...'
            });

            window.quill.on('text-change', function() {
                const lwComponent = Livewire.find(
                    document.querySelector('[wire\\:id]').getAttribute('wire:id')
                );
                if (lwComponent) {
                    lwComponent.set('isi', window.quill.root.innerHTML);
                }
            });
        }
    </script>
@endpush

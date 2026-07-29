@extends('layouts.admins')

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Video</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('video.view') }}">Video</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Edit Video</li>
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

<livewire:admin.video.edit :id="$id" />
@endsection

@push('myscript')
<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('simpan-berhasil', () => {
        setTimeout(() => {
            window.location = "{{ route('video.view') }}";
        }, 1500);
    });
});
</script>

<script>
let autoSaveTimer;

function jadwalAutoSave(){
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(function(){
        Livewire.dispatch('auto-save');
    }, 5000);
}
</script>
@endpush

@extends('layouts.admins')

@section('content')

          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Layanan</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('dashboard')}}">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('layanan.view')}}">Layanan</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Edit</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="{{asset ('admins/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <livewire:admin.layanan.edit :id_layanan="$id_layanan" />

@endsection

@push('myscript')

<script src="{{asset ('admins/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset ('admins/js/datatable/datatable-basic.init.js') }}"></script>
<script src="{{asset ('admins/libs/quill/dist/quill.min.js') }}"></script>
<script src="{{asset ('admins/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{asset ('admins/js/plugins/meg.init.js') }}"></script>

<script src="{{ asset('admins/js/upload-thumbnail.js') }}"></script>

<script>

document.addEventListener('livewire:navigated',initQuill);
document.addEventListener('livewire:initialized',initQuill);

function initQuill(){

    if(window.quill)return;

    window.quill=new Quill('#editor',{
        theme:'snow'
    });

    quill.on('text-change',function(){

        Livewire.find(
            document.querySelector('[wire\\:id]').getAttribute('wire:id')
        ).set('deskripsi',quill.root.innerHTML);

    });

}

</script>

<script>

document.addEventListener('livewire:init',()=>{

    Livewire.on('simpan-berhasil',()=>{

        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil ditambahkan.',
            timer:1500,
            showConfirmButton:false
        }).then(()=>{
            window.location="{{ Route('layanan.view') }}";
        });

    });

});

</script>
  
@endpush
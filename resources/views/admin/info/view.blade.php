@extends('layouts.admins')

@section('content')
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Info dan Tips</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('dashboard')}}">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Info dan Tips</li>
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
          <div class="datatables">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">Data</h4>
                  <a href="{{ Route('info.create')}}" class="btn btn-primary">+ Buat Baru</a>
                </div>
                <br>
                 <div class="table-responsive">
                  <livewire:admin.info.table />
                  <livewire:admin.info.delete />
                </div>
              </div>
            </div>
          </div>

@endsection

@push('myscript')

<!-- Button Hapus -->
<script>
$(document).on('click','.hapus',function(){

    let id=$(this).data('id');

    Swal.fire({
        title:'Hapus data?',
        text:'Data yang dihapus tidak dapat dikembalikan.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Ya, Hapus',
        cancelButtonText:'Batal'
    }).then((result)=>{

        if(result.isConfirmed){

            Livewire.dispatch('hapusInfo',{
                id_post:id
            });

        }

    });

});
</script>
<!-- END Button Hapus -->

@endpush

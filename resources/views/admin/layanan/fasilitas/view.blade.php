@extends('layouts.admins')

@section('content')
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Fasilitas</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('dashboard')}}">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Fasilitas</li>
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
            <!-- start Zero Configuration -->
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">Data</h4>
                  <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-modal">+ Tambah Data</a>                  
                </div>
                <br>
                  {{-- Modal Tambah --}}
                  <div class="modal fade" id="tambah-modal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" wire:ignore.self">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="exampleModalLabel1">Tambah Data</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <livewire:admin.layanan.fasilitas.create />
                        </div>
                    </div>
                  </div>
                  {{-- End Modal Tambah --}}
                 <div class="table-responsive">

                  <livewire:admin.layanan.fasilitas.table />
                  <livewire:admin.layanan.fasilitas.delete />

                  {{-- Modal Edit --}}
                  <div class="modal fade" id="editdata" tabindex="-1" wire:ignore.self>
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header d-flex align-items-center">
                                  <h4 class="modal-title">Edit Data</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <livewire:admin.layanan.fasilitas.edit />

                          </div>
                      </div>
                  </div>
                  {{-- End Edit Tambah --}}
                </div>
              </div>
            </div>
          </div>     

@endsection

@push('myscript')


<!-- Button Edit -->
<script>
$(document).on('click','.edit',function(){

    let id=$(this).data('id');

    Livewire.dispatch('edit',{
        id_fasilitas:id
    });

    new bootstrap.Modal(document.getElementById('editdata')).show();

});
</script>
<!-- END Button Edit -->

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

            Livewire.dispatch('hapusFasilitas',{
                id_fasilitas:id
            });

        }

    });

});
</script>
<!-- END Button Hapus -->
<script>
  document.addEventListener('livewire:init', () => {
      Livewire.on('fasilitas-created', () => {
          bootstrap.Modal.getInstance(document.getElementById('tambah-modal')).hide();
      });
  });
</script>
<script>
  document.addEventListener('livewire:init',()=>{

    Livewire.on('close-edit-modal',()=>{

        bootstrap.Modal.getInstance(document.getElementById('editdata')).hide();

    });

  });
</script>
  
@endpush
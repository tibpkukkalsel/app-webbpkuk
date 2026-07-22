@extends('layouts.admins')

@section('content')
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Footer</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('dashboard')}}">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Footer</li>
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
                  <h4 class="card-title mb-0">Data Identitas Footer</h4>
                </div>
                <br>

                 <div class="table-responsive">

                  <livewire:admin.footer.table />

                  {{-- Modal Text --}}
                  <div class="modal fade" id="editdata" tabindex="-1" wire:ignore.self>
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header d-flex align-items-center">
                                  <h4 class="modal-title">Edit Footer</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                               <livewire:admin.footer.edit-text />

                          </div>
                      </div>
                  </div>
                  {{-- End Text --}}

                  {{-- Modal File --}}
                  <div class="modal fade" id="editfile" tabindex="-1" wire:ignore.self>
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header d-flex align-items-center">
                                  <h4 class="modal-title">Upload Gambar</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <livewire:admin.footer.edit-file />
                          </div>
                      </div>
                  </div>
                  {{-- End File --}}
                </div>
              </div>
            </div>
          </div>     

@endsection

@push('myscript')


<!-- Button Edit -->
<script>
$(document).on('click','.edit-text',function(){

    let id=$(this).data('id');

    Livewire.dispatch('editText',{
        id_footer:id
    });

    new bootstrap.Modal(document.getElementById('editdata')).show();

});
</script>
<!-- END Button Edit -->

<script>
  $(document).on('click','.edit-file',function(){

    let id=$(this).data('id');

    Livewire.dispatch('editFile',{
        id_footer:id
    });

    bootstrap.Modal.getOrCreateInstance(document.getElementById('editfile')).show();

});
</script>

<script>
  document.addEventListener('livewire:init',()=>{

    Livewire.on('close-edit-text',()=>{

        bootstrap.Modal.getInstance(document.getElementById('editdata')).hide();

    });

  });

    document.addEventListener('livewire:init',()=>{

    Livewire.on('close-edit-file',()=>{

        bootstrap.Modal.getInstance(document.getElementById('editfile')).hide();

    });

  });
</script>

  
@endpush
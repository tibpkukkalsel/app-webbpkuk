@extends('layouts.admins')

@section('content')

          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Info</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('dashboard')}}">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ Route('info.view')}}">Info</a>
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

          <livewire:admin.info.edit :id="$id" />

@endsection

@push('myscript')

<script src="{{asset ('admins/libs/quill/dist/quill.min.js') }}"></script>

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
        ).set('isi',quill.root.innerHTML);
        jadwalAutoSave();
    });
}
</script>

<script>
  let autoSaveTimer;
  function jadwalAutoSave(){
      clearTimeout(autoSaveTimer);
      autoSaveTimer=setTimeout(function(){
          Livewire.dispatch('auto-save');
      },6000000);
  }
</script>

<script>
  function initGallery(){
    $('.popup-gallery').magnificPopup({
        delegate:'a',
        type:'image',
        gallery:{ enabled:true }
    });
  }
  $(function(){ initGallery(); });
  document.addEventListener('livewire:init',()=>{
    Livewire.hook('morphed',()=>{
        $('.popup-gallery').magnificPopup('destroy');
        initGallery();
    });
  });
</script>

<script>
$(document).on('click','.hapus-galeri',function(){
    let id=$(this).data('id');
    Swal.fire({
        title:'Hapus foto?',
        text:'Foto akan dihapus permanen.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Ya',
        cancelButtonText:'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            Livewire.first().call('hapusGaleri',id);
        }
    });
});
</script>

<script>
document.addEventListener('livewire:init',()=>{
    const input=document.querySelector('#hashtag');
    const tagify=new Tagify(input,{
        whitelist:window.hashtagList,
        enforceWhitelist:false,
        duplicates:false,
        dropdown:{ enabled:1, maxItems:20 }
    });
    tagify.addTags(window.selectedHashtag);
    tagify.on('add',function(e){
        Livewire.first().call('tambahHashtag',e.detail.data);
    });
    tagify.on('remove',function(e){
        Livewire.first().call('hapusHashtag',e.detail.data);
    });
});
</script>

@endpush

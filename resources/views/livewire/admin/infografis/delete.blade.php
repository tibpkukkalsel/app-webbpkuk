<div>
    <div class="modal-body text-center py-4">
        <i class="ti ti-trash text-danger display-4 mb-3 d-block"></i>
        <h5 class="fw-semibold">Apakah Anda yakin?</h5>
        <p class="text-muted mb-0">Infografis "<strong>{{ $judul }}</strong>" akan dihapus permanen.</p>
    </div>
    <div class="modal-footer justify-content-center border-0 pt-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" wire:click="hapus" wire:loading.attr="disabled">
            Ya, Hapus
        </button>
    </div>
</div>

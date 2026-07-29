<div>
    <div class="modal-body text-center">
        <i class="ti ti-trash-x text-danger" style="font-size:3rem;"></i>
        <h5 class="mt-3">Hapus Hero Banner?</h5>
        <p class="text-muted mb-0">Data gambar <strong>"{{ $judul }}"</strong> akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
    </div>
    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger" wire:click="hapus"
                wire:loading.attr="disabled" wire:target="hapus">
            <span wire:loading.remove wire:target="hapus">Ya, Hapus</span>
            <span wire:loading wire:target="hapus">Menghapus...</span>
        </button>
        <button type="button" class="btn bg-secondary-subtle text-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</div>

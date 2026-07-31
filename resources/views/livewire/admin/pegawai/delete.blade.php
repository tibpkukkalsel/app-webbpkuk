<div wire:ignore.self class="modal fade" id="modalDeletePegawai" tabindex="-1" aria-labelledby="modalDeletePegawaiLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body p-4">
                <i class="ti ti-alert-circle text-danger fs-9 mb-2 d-block"></i>
                <h5 class="fw-semibold mb-1">Konfirmasi Hapus</h5>
                <p class="text-muted mb-4 fs-3">Apakah Anda yakin ingin menghapus data pegawai ini?</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" wire:click="delete" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

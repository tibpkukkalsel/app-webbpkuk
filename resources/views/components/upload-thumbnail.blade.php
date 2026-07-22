<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Thumbnail</h5>
    </div>

    <div class="card-body">

        <div class="border rounded overflow-hidden mb-3">
            <img src="{{ asset('admins/images/no-image.png') }}" id="preview-thumb" class="w-100" style="height:230px;object-fit:cover;">
        </div>

        <button type="button" class="btn btn-primary w-100" onclick="uploadFile()">
            <i class="ti ti-upload me-1"></i> Pilih Thumbnail
        </button>

        <input type="file" accept="image/png,image/jpeg,image/webp" name="image" id="file-thumbail" class="d-none">

    </div>
</div>
<div>
    @if ($lastSavedAt)
        <div class="alert customize-alert alert-dismissible alert-light-success bg-success-subtle text-success fade show remove-close-icon"
            role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="d-flex align-items-center me-3 me-md-0">
                <i class="ti ti-alert-circle fs-5 me-2 text-success"></i>
                ✓ Draft tersimpan otomatis pukul {{ $lastSavedAt }}
            </div>
        </div>
    @endif

    <form @if(!$isReadOnly) wire:submit="simpan" @endif>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Judul :</label>
                            <input type="text" class="form-control" wire:model="judul" @if($isReadOnly) disabled @else oninput="jadwalAutoSave()" @endif>
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select class="form-select" wire:model="id_kategori" @if($isReadOnly) disabled @else oninput="jadwalAutoSave()" @endif>
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">
                                        {{ $k->kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Artikel :</label>
                            @if($isReadOnly)
                                <div class="p-3 border rounded bg-light" style="min-height: 200px;">
                                    {!! $isi !!}
                                </div>
                            @else
                                <div wire:ignore>
                                    <div id="editor">
                                        <p>{!! $isi !!}</p>
                                    </div>
                                    <hr>
                                </div>
                            @endif
                            @error('isi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Ringkasan :</label>
                            <textarea rows="5" class="form-control" wire:model="ringkasan" @if($isReadOnly) disabled @endif></textarea>
                            @error('ringkasan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if(!$isReadOnly)
                                <div class="mt-2">
                                    <button type="button" class="btn btn-primary" wire:click="buatRingkasan"
                                        wire:loading.attr="disabled" wire:target="buatRingkasan">
                                        <i class="ti ti-refresh"></i> Buat Ringkasan AI
                                    </button>
                                    <span wire:loading wire:target="buatRingkasan" class="ms-2">
                                        AI sedang membuat ringkasan...
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thumbnail</h5>
                    </div>
                    <div class="card-body">
                        @if ($gambar)
                            <img src="{{ $gambar->temporaryUrl() }}" class="img-fluid rounded border mb-3"
                                style="height:220px;width:100%;object-fit:cover;">
                        @elseif($thumbnail)
                            <img src="{{ asset('storage/post/thumbnail/' . $thumbnail) }}"
                                class="img-fluid rounded border mb-3" style="height:220px;width:100%;object-fit:cover;">
                        @else
                            <img src="{{ asset('admins/images/no-image.png') }}" class="img-fluid rounded border mb-3"
                                style="height:220px;width:100%;object-fit:cover;">
                        @endif
                        @if(!$isReadOnly)
                            <input type="file" class="form-control" wire:model="gambar"
                                accept="image/png,image/jpeg,image/webp">
                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div wire:loading wire:target="gambar">
                                <small class="text-primary">Uploading...</small>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Publikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select wire:model="status" class="form-select" @if($isReadOnly) disabled @endif>
                                <option value="0">Draft</option>
                                <option value="1">Kirim</option>
                                @if (auth()->user()->hasRole('Superadmin') || (string)$status === '2')
                                    <option value="2">Publish</option>
                                @endif
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            @if(!$isReadOnly)
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Simpan
                                </button>
                            @else
                                <a href="{{ route('artikel.view') }}" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar
                                </a>
                            @endif
                            @if($postId)
                                <a href="{{ route('post.cetak-persetujuan', $postId) }}" target="_blank" class="btn btn-outline-secondary">
                                    <i class="ti ti-printer me-1"></i> Cetak Lembar Persetujuan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Galeri Foto</h5>
                        @if(!$isReadOnly)
                            <button type="button" class="btn btn-secondary"
                                onclick="document.getElementById('galeri').click()">
                                + Tambah
                            </button>
                            <input id="galeri" type="file" class="d-none" wire:model="galeri"
                                accept="image/png,image/jpeg,image/webp">
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!$isReadOnly)
                            <div wire:loading wire:target="galeri">
                                <small class="text-primary">
                                    Mengupload foto...
                                </small>
                            </div>
                        @endif
                        <div class="row popup-gallery">
                            @forelse($galeriPost as $g)
                                <div class="col-lg-3 col-md-6 mb-3" wire:key="galeri-{{ $g->id_galeri }}">
                                    <div class="card overflow-hidden position-relative">
                                        <a href="{{ asset('storage/post/galeri/' . $g->gambar) }}"
                                            title="{{ $judul ?? 'Galeri Foto' }}">
                                            <img src="{{ asset('storage/post/galeri/' . $g->gambar) }}"
                                                class="img-fluid w-100 rounded"
                                                style="height:180px;object-fit:cover;cursor:pointer;">
                                        </a>
                                        @if(!$isReadOnly)
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 hapus-galeri"
                                                data-id="{{ $g->id_galeri }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">
                                    Belum ada galeri foto.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Hashtag</h5>
                    </div>
                    <div class="card-body">
                        @if($isReadOnly)
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($hashtagPost as $tag)
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fs-2">
                                        <i class="ti ti-hash me-1"></i>{{ $tag->hashtag ?? $tag }}
                                    </span>
                                @empty
                                    <span class="text-muted fs-2">Belum ada hashtag.</span>
                                @endforelse
                            </div>
                        @else
                            <div wire:ignore>
                                <input id="hashtag" class="form-control" placeholder="Ketik hashtag...">
                            </div>
                            <script>
                                window.hashtagList = @json(
                                    $hashtags->map(function ($item) {
                                        return [
                                            'value' => $item->hashtag,
                                            'id_hashtag' => $item->id_hashtag,
                                        ];
                                    }));
                                window.selectedHashtag = @json($hashtagPost->pluck('hashtag'));
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

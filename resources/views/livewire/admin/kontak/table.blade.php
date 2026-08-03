<div class="card card-body p-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="card-title fw-semibold mb-0">Pesan Masuk</h5>
        <span class="badge bg-primary rounded-pill">{{ $kontaks->total() }} Pesan</span>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show text-sm py-2 px-3 mb-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show text-sm py-2 px-3 mb-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Quick Stats --}}
    <div class="row g-2 mb-3">
        <div class="col-4">
            <button wire:click="$set('filterStatus', 'unread')" 
                class="btn btn-sm w-100 {{ $filterStatus === 'unread' ? 'btn-danger' : 'btn-outline-danger' }}">
                Belum ({{ $unreadCount }})
            </button>
        </div>
        <div class="col-4">
            <button wire:click="$set('filterStatus', 'read')" 
                class="btn btn-sm w-100 {{ $filterStatus === 'read' ? 'btn-warning' : 'btn-outline-warning' }}">
                Dibaca ({{ $readCount }})
            </button>
        </div>
        <div class="col-4">
            <button wire:click="$set('filterStatus', 'replied')" 
                class="btn btn-sm w-100 {{ $filterStatus === 'replied' ? 'btn-success' : 'btn-outline-success' }}">
                Dibalas ({{ $repliedCount }})
            </button>
        </div>
    </div>

    {{-- Search & Reset Filter --}}
    <div class="mb-3">
        <div class="input-group input-group-sm">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Cari nama, email, subjek...">
            @if ($filterStatus || $search)
                <button wire:click="$set('filterStatus', ''); $set('search', '')" class="btn btn-outline-secondary" type="button">
                    <i class="ti ti-x"></i>
                </button>
            @endif
        </div>
    </div>

    {{-- List Kontak --}}
    <div class="list-group list-group-flush mb-3 overflow-auto" style="max-height: 520px;">
        @forelse($kontaks as $item)
            <a href="javascript:void(0)" 
               wire:click="selectKontak({{ $item->id }})"
               class="list-group-item list-group-item-action p-3 rounded-2 mb-2 border {{ $selectedKontakId == $item->id ? 'bg-light-primary border-primary' : '' }}">
                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                    <h6 class="mb-0 fw-semibold text-truncate me-2" style="max-width: 180px;">{{ $item->nama }}</h6>
                    <small class="text-muted fs-2">{{ $item->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1 text-dark fw-medium text-truncate fs-3">{{ $item->subjek }}</p>
                <p class="mb-2 text-muted fs-2 text-truncate">{{ $item->pesan }}</p>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if($item->status === 'unread')
                            <span class="badge bg-danger fs-1">Belum Dibaca</span>
                        @elseif($item->status === 'read')
                            <span class="badge bg-warning fs-1 text-dark">Sudah Dibaca</span>
                        @else
                            <span class="badge bg-success fs-1">Sudah Dibalas ({{ $item->balasan_count }})</span>
                        @endif
                    </div>
                    @can('kontak.delete')
                        <button type="button" 
                                onclick="confirm('Yakin hapus pesan ini?') || event.stopImmediatePropagation()"
                                wire:click="deleteKontak({{ $item->id }})" 
                                class="btn btn-link text-danger p-0 border-0 fs-2" 
                                title="Hapus">
                            <i class="ti ti-trash"></i>
                        </button>
                    @endcan
                </div>
            </a>
        @empty
            <div class="text-center py-4 text-muted">
                <i class="ti ti-inbox fs-7 mb-2 d-block"></i>
                Tidak ada pesan kontak ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $kontaks->links() }}
    </div>
</div>

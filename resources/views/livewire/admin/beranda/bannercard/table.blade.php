<div class="table-responsive">
    <table class="table align-middle mb-0">
        <tbody>
            @forelse($beranda as $d)
            <tr>
                <td width="220"><strong>{{ $d->nama }}</strong></td>
                <td width="20">:</td>
                <td>
                    @if($d->status=='file')
                        @if($d->keterangan_1)
                            <img src="{{ asset('storage/beranda/'.$d->keterangan_1) }}" class="img-thumbnail" style="height:200px;object-fit:cover;">
                        @else
                            <span class="text-danger">Belum ada file</span>
                        @endif
                    @else
                        {{ $d->keterangan_1 }}
                    @endif
                </td>
                <td class="text-center">
                    @if($d->status=='file')
                        <button class="btn btn-primary btn-sm edit-file" data-id="{{ $d->id_beranda }}" type="button"><i class="ti ti-upload"></i></button>
                    @else
                        <button class="btn btn-primary btn-sm edit-text" data-id="{{ $d->id_beranda }}" type="button"><i class="ti ti-pencil"></i></button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
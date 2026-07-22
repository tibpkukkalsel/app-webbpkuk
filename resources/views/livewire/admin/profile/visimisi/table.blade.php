<div class="table-responsive">
    <table class="table align-middle mb-0">
        <tbody>
            @forelse($profile as $d)
            <tr>
                <td width="220"><strong>{{ $d->nama }}</strong></td>
                <td width="20">:</td>
                <td>
                    @if($d->status=='file')
                        @if($d->keterangan)
                            <img src="{{ asset('storage/profileweb/'.$d->keterangan) }}" class="img-thumbnail" style="height:100px;object-fit:cover;">
                        @else
                            <span class="text-danger">Belum ada file</span>
                        @endif
                    @else
                        {{ $d->keterangan }}
                    @endif
                </td>
                <td class="text-center">
                    @if($d->status=='file')
                        <button class="btn btn-primary btn-sm edit-file" data-id="{{ $d->id_visimisi }}" type="button"><i class="ti ti-upload"></i></button>
                    @else
                        <button class="btn btn-primary btn-sm edit-text" data-id="{{ $d->id_visimisi }}" type="button"><i class="ti ti-pencil"></i></button>
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
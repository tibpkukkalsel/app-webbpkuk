<?php

namespace App\Services;

use App\Models\LinkTerkait;
use Illuminate\Support\Facades\Storage;

class LinkTerkaitService
{
    public function getAllPaginated($perPage = 10)
    {
        return LinkTerkait::orderBy('urutan')
            ->orderBy('id_link_terkait')
            ->paginate($perPage);
    }

    public function getActiveForWebsite()
    {
        return LinkTerkait::where('status', 'aktif')
            ->orderBy('urutan')
            ->orderBy('id_link_terkait')
            ->get();
    }

    public function create(array $data, $file = null)
    {
        if ($file) {
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('link-terkait', $namaFile, 'public');
            $data['gambar'] = $namaFile;
        }

        return LinkTerkait::create($data);
    }

    public function update($id, array $data, $fileBaru = null)
    {
        $item = LinkTerkait::findOrFail($id);

        if ($fileBaru) {
            if ($item->gambar) {
                Storage::disk('public')->delete('link-terkait/' . $item->gambar);
            }
            $namaFile = time() . '_' . uniqid() . '.' . $fileBaru->getClientOriginalExtension();
            $fileBaru->storeAs('link-terkait', $namaFile, 'public');
            $data['gambar'] = $namaFile;
        }

        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = LinkTerkait::findOrFail($id);

        if ($item->gambar) {
            Storage::disk('public')->delete('link-terkait/' . $item->gambar);
        }

        return $item->delete();
    }
}

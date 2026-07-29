<?php

namespace App\Services;

use App\Models\Infografis;
use Illuminate\Support\Facades\Storage;

class InfografisService
{
    public function getAllPaginated($perPage = 10)
    {
        return Infografis::orderBy('urutan')
            ->orderBy('id_infografis')
            ->paginate($perPage);
    }

    public function getActiveForWebsite()
    {
        return Infografis::where('status', 'aktif')
            ->orderBy('urutan')
            ->orderBy('id_infografis')
            ->get();
    }

    public function create(array $data, $file = null)
    {
        if ($file) {
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('infografis', $namaFile, 'public');
            $data['gambar'] = $namaFile;
        }

        return Infografis::create($data);
    }

    public function update($id, array $data, $fileBaru = null)
    {
        $infografis = Infografis::findOrFail($id);

        if ($fileBaru) {
            if ($infografis->gambar) {
                Storage::disk('public')->delete('infografis/' . $infografis->gambar);
            }
            $namaFile = time() . '_' . uniqid() . '.' . $fileBaru->getClientOriginalExtension();
            $fileBaru->storeAs('infografis', $namaFile, 'public');
            $data['gambar'] = $namaFile;
        }

        $infografis->update($data);
        return $infografis;
    }

    public function delete($id)
    {
        $infografis = Infografis::findOrFail($id);

        if ($infografis->gambar) {
            Storage::disk('public')->delete('infografis/' . $infografis->gambar);
        }

        return $infografis->delete();
    }
}

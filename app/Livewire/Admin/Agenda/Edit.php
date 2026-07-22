<?php

namespace App\Livewire\Admin\Agenda;

use App\Models\Agenda;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $id_agenda;
    public $nama;
    public $deskripsi;
    public $tglAwal;
    public $tglAkhir;
    public $jamMulai;
    public $jamAkhir;
    public $tempat;
    public $status;

    protected $listeners = [
        'editAgenda'
    ];

    public function editAgenda($id_agenda)
    {
        $data = Agenda::findOrFail($id_agenda);

        $this->id_agenda = $data->id_agenda;
        $this->nama = $data->nama;
        $this->deskripsi = $data->deskripsi;
        $this->tglAwal = $data->tgl_awal;
        $this->tglAkhir = $data->tgl_akhir;
        $this->jamMulai = $data->jam_mulai;
        $this->jamAkhir = $data->jam_akhir;
        $this->tempat = $data->tempat;
        $this->status = $data->status;
    }

    protected function buatSlug($nama)
    {
        $slug=Str::slug($nama);
        $originalSlug=$slug;
        $i=1;

        while(Agenda::where('slug',$slug)->where('id_agenda','!=',$this->id_agenda)->exists()){
            $slug=$originalSlug.'-'.$i;
            $i++;
        }

        return $slug;
    }

    public function update()
    {
        $this->validate([
        'nama.required'=>'Nama agenda wajib diisi.',
        'tglAwal.required'=>'Tanggal mulai wajib diisi.',
        'tglAkhir.required'=>'Tanggal selesai wajib diisi.',
        'tglAkhir.after_or_equal'=>'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        'jamMulai.required'=>'Jam wajib diisi.',
        'jamAkhir.after'=>'Jam selesai tidak boleh lebih awal dari jam mulai.',
        'tempat.required'=>'Tempat wajib diisi.',
        ]);

        Agenda::where('id_agenda', $this->id_agenda)->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'slug' => $this->buatSlug($this->nama),
            'tgl_awal' => $this->tglAwal,
            'tgl_akhir' => $this->tglAkhir,
            'jam_mulai' => $this->jamMulai,
            'jam_akhir' => $this->jamAkhir,
            'tempat' => $this->tempat,
            'status' => $this->status,
        ]);

        $this->dispatch('agenda-refresh');

        $this->dispatch('close-edit-modal');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil diubah.'
        );
    }

    public function render()
    {
        return view('livewire.admin.agenda.edit');
    }
}

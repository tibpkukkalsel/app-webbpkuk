<?php

namespace App\Livewire\Admin\Agenda;

use App\Models\Agenda;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public $nama = '';
    public $deskripsi = '';
    public $slug = '';
    public $tglAwal = '';
    public $tglAkhir = '';
    public $jamMulai = '';
    public $jamAkhir = '';
    public $tempat = '';
    public $status = '1';

    protected function buatSlug($nama)
    {
        $slug=Str::slug($nama);
        $originalSlug=$slug;
        $i=1;

        while(Agenda::where('slug',$slug)->exists()){
            $slug=$originalSlug.'-'.$i;
            $i++;
        }
        return $slug;
    }

    protected $rules=[
        'nama'=>'required|min:3|max:255',
        'deskripsi'=>'nullable',
        'tglAwal'=>'required|date',
        'tglAkhir'=>'required|date|after_or_equal:tglAwal',
        'jamMulai'=>'required',
        'jamAkhir'=>'required|after:jamMulai',
        'tempat'=>'required|max:255',
        'status'=>'required|boolean',
    ];

    protected $messages=[
        'nama.required'=>'Nama agenda wajib diisi.',
        'tglAwal.required'=>'Tanggal mulai wajib diisi.',
        'tglAkhir.required'=>'Tanggal selesai wajib diisi.',
        'tglAkhir.after_or_equal'=>'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        'jamMulai.required'=>'Jam wajib diisi.',
        'jamAkhir.after'=>'Jam selesai tidak boleh lebih awal dari jam mulai.',
        'tempat.required'=>'Tempat wajib diisi.',
    ];

   public function simpan()
   {
        $this->validate();

        Agenda::create([
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

        $this->reset();
        
        $this->dispatch('agenda-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil ditambahkan.'
        );

        $this->dispatch('agenda-created');
    }

    public function render()
    {
        return view('livewire.admin.agenda.create');
    }
}

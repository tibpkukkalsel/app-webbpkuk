<?php

namespace App\Livewire\Admin\Layanan\FasilitasPemesan;

use App\Models\FasilitasPemesan;
use App\Models\FasilitasPemesananDetail;
use App\Models\Fasilitas;
use App\Models\FasilitasTarif;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nama_pemohon;
    public $nik;
    public $instansi;
    public $email;
    public $no_hp;
    public $alamat;
    public $keperluan;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $jam_mulai;
    public $jam_selesai;
    public $foto_ktp;
    public $status = 'menunggu';
    public $catatan;

    public $items = [];

    public function mount()
    {
        $this->tanggal_mulai = now()->toDateString();
        $this->tanggal_selesai = now()->toDateString();
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'id_fasilitas' => '',
            'jumlah'       => 1,
            'tarif'        => 0,
            'subtotal'     => 0,
            'keterangan'   => '',
        ];
    }

    public function removeItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function selectFasilitas($index, $id_fasilitas)
    {
        $this->items[$index]['id_fasilitas'] = $id_fasilitas;
        if ($id_fasilitas) {
            $tarifObj = FasilitasTarif::where('id_fasilitas', $id_fasilitas)
                ->where('status', 1)
                ->orderBy('tanggal_mulai', 'desc')
                ->first();
            if ($tarifObj) {
                $this->items[$index]['tarif'] = (float) $tarifObj->tarif;
            }
        }
        $this->calculateSubtotal($index);
    }

    public function updateJumlah($index, $jumlah)
    {
        $this->items[$index]['jumlah'] = max(1, (int) $jumlah);
        $this->calculateSubtotal($index);
    }

    public function updateTarif($index, $tarif)
    {
        $this->items[$index]['tarif'] = max(0, (float) $tarif);
        $this->calculateSubtotal($index);
    }

    public function calculateSubtotal($index)
    {
        $jumlah = (int) ($this->items[$index]['jumlah'] ?? 1);
        $tarif  = (float) ($this->items[$index]['tarif'] ?? 0);
        $this->items[$index]['subtotal'] = $jumlah * $tarif;
    }

    public function getTotalKeseluruhanProperty()
    {
        return array_reduce($this->items, function ($acc, $item) {
            return $acc + ((float) ($item['subtotal'] ?? 0));
        }, 0);
    }

    public function simpan()
    {
        $this->validate([
            'nama_pemohon'          => 'required|string|max:150',
            'nik'                   => 'nullable|string|max:20',
            'instansi'              => 'nullable|string|max:200',
            'email'                 => 'nullable|email|max:150',
            'no_hp'                 => 'nullable|string|max:20',
            'alamat'                => 'nullable|string',
            'keperluan'             => 'nullable|string',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'             => 'nullable',
            'jam_selesai'           => 'nullable',
            'foto_ktp'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status'                => 'required|in:menunggu,disetujui,ditolak,selesai,dibatalkan',
            'catatan'               => 'nullable|string',
            'items'                 => 'required|array|min:1',
            'items.*.id_fasilitas'  => 'required|exists:fasilitas,id_fasilitas',
            'items.*.jumlah'        => 'required|integer|min:1',
            'items.*.tarif'         => 'required|numeric|min:0',
        ], [
            'items.*.id_fasilitas.required' => 'Fasilitas wajib dipilih pada setiap baris item.',
            'items.*.jumlah.min' => 'Jumlah unit minimal 1.',
        ]);

        $namaKtp = null;
        if ($this->foto_ktp) {
            $namaKtp = time() . '_ktp_' . uniqid() . '.' . $this->foto_ktp->getClientOriginalExtension();
            $this->foto_ktp->storeAs('pemesan_ktp', $namaKtp, 'public');
        }

        $nomorBooking = FasilitasPemesan::generateNomorBooking();

        $pemesan = FasilitasPemesan::create([
            'nomor_booking'   => $nomorBooking,
            'nama_pemohon'    => $this->nama_pemohon,
            'nik'             => $this->nik,
            'instansi'        => $this->instansi,
            'email'           => $this->email,
            'no_hp'           => $this->no_hp,
            'alamat'          => $this->alamat,
            'keperluan'       => $this->keperluan,
            'tanggal_mulai'   => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'jam_mulai'       => $this->jam_mulai ?: null,
            'jam_selesai'     => $this->jam_selesai ?: null,
            'foto_ktp'        => $namaKtp,
            'status'          => $this->status,
            'catatan'         => $this->catatan,
        ]);

        foreach ($this->items as $item) {
            $jumlah = (int) $item['jumlah'];
            $tarif = (float) $item['tarif'];
            $subtotal = $jumlah * $tarif;

            FasilitasPemesananDetail::create([
                'id_pemesanan' => $pemesan->id_pemesanan,
                'id_fasilitas' => $item['id_fasilitas'],
                'jumlah'       => $jumlah,
                'tarif'        => $tarif,
                'subtotal'     => $subtotal,
                'keterangan'   => $item['keterangan'] ?? null,
            ]);
        }

        \App\Models\FasilitasRiwayat::catatLog(
            aktivitas: 'Pengajuan Pemesanan',
            deskripsi: "Pemesanan baru {$nomorBooking} diajukan oleh {$this->nama_pemohon} (" . ($this->instansi ?? 'Pribadi') . ") dengan total biaya Rp " . number_format($pemesan->total_harga, 0, ',', '.'),
            idPemesanan: $pemesan->id_pemesanan,
            nomorBooking: $nomorBooking
        );

        $this->reset(['nama_pemohon', 'nik', 'instansi', 'email', 'no_hp', 'alamat', 'keperluan', 'jam_mulai', 'jam_selesai', 'foto_ktp', 'catatan', 'items']);
        $this->tanggal_mulai = now()->toDateString();
        $this->tanggal_selesai = now()->toDateString();
        $this->status = 'menunggu';
        $this->addItem();

        $this->dispatch('pemesan-refresh');
        $this->dispatch('pemesan-created');
    }

    public function render()
    {
        $fasilitasOptions = Fasilitas::where('status', 1)->get();
        return view('livewire.admin.layanan.fasilitas_pemesan.create', compact('fasilitasOptions'));
    }
}

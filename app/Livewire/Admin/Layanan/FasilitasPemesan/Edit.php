<?php

namespace App\Livewire\Admin\Layanan\FasilitasPemesan;

use App\Models\FasilitasPemesan;
use App\Models\FasilitasPemesananDetail;
use App\Models\Fasilitas;
use App\Models\FasilitasTarif;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_pemesanan;
    public $nomor_booking;
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
    public $fotoKtpLama;
    public $status;
    public $catatan;

    public $items = [];

    protected $listeners = [
        'editPemesan' => 'loadData'
    ];

    public function loadData($id_pemesanan)
    {
        $data = FasilitasPemesan::with('details')->findOrFail($id_pemesanan);
        $this->id_pemesanan    = $data->id_pemesanan;
        $this->nomor_booking   = $data->nomor_booking;
        $this->nama_pemohon    = $data->nama_pemohon;
        $this->nik             = $data->nik;
        $this->instansi        = $data->instansi;
        $this->email           = $data->email;
        $this->no_hp           = $data->no_hp;
        $this->alamat          = $data->alamat;
        $this->keperluan       = $data->keperluan;
        $this->tanggal_mulai   = $data->tanggal_mulai ? $data->tanggal_mulai->format('Y-m-d') : null;
        $this->tanggal_selesai = $data->tanggal_selesai ? $data->tanggal_selesai->format('Y-m-d') : null;
        $this->jam_mulai       = $data->jam_mulai;
        $this->jam_selesai     = $data->jam_selesai;
        $this->fotoKtpLama     = $data->foto_ktp;
        $this->status          = $data->status;
        $this->catatan         = $data->catatan;

        $this->items = [];
        foreach ($data->details as $det) {
            $this->items[] = [
                'id_detail'    => $det->id_detail,
                'id_fasilitas' => $det->id_fasilitas,
                'jumlah'       => $det->jumlah,
                'tarif'        => (float) $det->tarif,
                'subtotal'     => (float) $det->subtotal,
                'keterangan'   => $det->keterangan,
            ];
        }

        if (empty($this->items)) {
            $this->addItem();
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'id_detail'    => null,
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

    public function update()
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
        ]);

        $pemesan = FasilitasPemesan::findOrFail($this->id_pemesanan);
        $namaKtp = $this->fotoKtpLama;

        if ($this->foto_ktp) {
            if ($this->fotoKtpLama) {
                if (Storage::disk('local')->exists('pemesan_ktp/' . $this->fotoKtpLama)) {
                    Storage::disk('local')->delete('pemesan_ktp/' . $this->fotoKtpLama);
                } elseif (Storage::disk('local')->exists($this->fotoKtpLama)) {
                    Storage::disk('local')->delete($this->fotoKtpLama);
                } elseif (Storage::disk('public')->exists('pemesan_ktp/' . $this->fotoKtpLama)) {
                    Storage::disk('public')->delete('pemesan_ktp/' . $this->fotoKtpLama);
                }
            }
            $namaKtp = time() . '_ktp_' . uniqid() . '.' . $this->foto_ktp->getClientOriginalExtension();
            $this->foto_ktp->storeAs('pemesan_ktp', $namaKtp, 'local');
        }

        $pemesan->update([
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

        // Sync details
        FasilitasPemesananDetail::where('id_pemesanan', $pemesan->id_pemesanan)->delete();

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

        $namaAktivitas = 'Verifikasi Status: ' . ucfirst($this->status);
        $catatanInfo = $this->catatan ? " (Catatan: {$this->catatan})" : "";
        \App\Models\FasilitasRiwayat::catatLog(
            aktivitas: $namaAktivitas,
            deskripsi: "Pemesanan {$pemesan->nomor_booking} untuk {$pemesan->nama_pemohon} diperbarui menjadi status '{$this->status}'{$catatanInfo}.",
            idPemesanan: $pemesan->id_pemesanan,
            nomorBooking: $pemesan->nomor_booking
        );

        // Kirim Email Konfirmasi Status Resmi ke Pemesan
        if (!empty($pemesan->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($pemesan->email)->send(new \App\Mail\KonfirmasiStatusPemesananToPemesan($pemesan));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengirim email konfirmasi status ke pemesan: " . $e->getMessage());
            }
        }

        $this->dispatch('pemesan-refresh');
        $this->dispatch('close-edit-pemesan-modal');
    }

    public function render()
    {
        $fasilitasOptions = Fasilitas::where('status', 1)->get();
        return view('livewire.admin.layanan.fasilitas_pemesan.edit', compact('fasilitasOptions'));
    }
}

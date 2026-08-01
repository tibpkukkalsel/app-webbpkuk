<?php

namespace App\Livewire\Website\Fasilitas;

use App\Models\Fasilitas;
use App\Models\FasilitasPemesan;
use App\Models\FasilitasPemesananDetail;
use App\Models\FasilitasRiwayat;
use App\Models\FasilitasTarif;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class PesanForm extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    // Data Pemohon
    public $nama_pemohon;
    public $nik;
    public $instansi;
    public $email;
    public $no_hp;
    public $alamat;
    public $keperluan;
    public $foto_ktp;

    // Jadwal
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $jam_mulai = '08:00';
    public $jam_selesai = '16:00';

    // Multi-Item Fasilitas
    public $selectedItems = [];

    // Honeypot & Confirmation Modal State
    public $fax_hp = '';
    public $showConfirmModal = false;

    // Result Modal State
    public $bookingBerhasil = false;
    public $createdNomorBooking = null;
    public $createdPemesan = null;

    public function mount()
    {
        $this->tanggal_mulai = Carbon::now()->addDays(1)->format('Y-m-d');
        $this->tanggal_selesai = Carbon::now()->addDays(1)->format('Y-m-d');

        // Initial 1 item selection
        $firstFasilitas = Fasilitas::where('status', 1)->first();
        if ($firstFasilitas) {
            $topTarif = FasilitasTarif::where('id_fasilitas', $firstFasilitas->id_fasilitas)
                ->where('status', 1)
                ->orderBy('tanggal_mulai', 'desc')
                ->first();

            $this->selectedItems = [
                [
                    'id_fasilitas' => $firstFasilitas->id_fasilitas,
                    'jumlah' => 1,
                    'tarif' => $topTarif ? $topTarif->tarif : 0,
                    'satuan' => $topTarif ? $topTarif->satuan : 'hari',
                    'keterangan' => '',
                ]
            ];
        }
    }

    public function tambahItem()
    {
        $firstFasilitas = Fasilitas::where('status', 1)->first();
        if (!$firstFasilitas) return;

        $topTarif = FasilitasTarif::where('id_fasilitas', $firstFasilitas->id_fasilitas)
            ->where('status', 1)
            ->orderBy('tanggal_mulai', 'desc')
            ->first();

        $this->selectedItems[] = [
            'id_fasilitas' => $firstFasilitas->id_fasilitas,
            'jumlah' => 1,
            'tarif' => $topTarif ? $topTarif->tarif : 0,
            'satuan' => $topTarif ? $topTarif->satuan : 'hari',
            'keterangan' => '',
        ];
    }

    public function hapusItem($index)
    {
        if (count($this->selectedItems) > 1) {
            unset($this->selectedItems[$index]);
            $this->selectedItems = array_values($this->selectedItems);
        }
    }

    public function updatedSelectedItems($value, $key)
    {
        // Handle when user changes id_fasilitas
        $parts = explode('.', $key);
        if (count($parts) === 2 && $parts[1] === 'id_fasilitas') {
            $idx = $parts[0];
            $idFas = $this->selectedItems[$idx]['id_fasilitas'] ?? null;

            if ($idFas) {
                $topTarif = FasilitasTarif::where('id_fasilitas', $idFas)
                    ->where('status', 1)
                    ->orderBy('tanggal_mulai', 'desc')
                    ->first();

                $this->selectedItems[$idx]['tarif'] = $topTarif ? $topTarif->tarif : 0;
                $this->selectedItems[$idx]['satuan'] = $topTarif ? $topTarif->satuan : 'hari';
            }
        }
    }

    public function getTotalBiayaProperty()
    {
        $total = 0;
        foreach ($this->selectedItems as $item) {
            $total += ($item['jumlah'] ?? 1) * ($item['tarif'] ?? 0);
        }
        return $total;
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'nama_pemohon' => 'required|string|max:150',
                'nik'          => 'required|numeric|digits:16',
                'instansi'     => 'required|string|max:200',
                'email'        => 'required|email|max:150',
                'no_hp'        => 'required|numeric|digits_between:10,15',
                'alamat'       => 'required|string',
                'keperluan'    => 'required|string',
                'foto_ktp'     => 'required|image|max:3072', // Max 3MB
            ], [
                'nama_pemohon.required' => 'Nama pemohon wajib diisi.',
                'nik.required'          => 'NIK NIK wajib diisi 16 digit angka.',
                'nik.digits'            => 'NIK harus berisi 16 digit angka.',
                'instansi.required'     => 'Instansi/Organisasi wajib diisi.',
                'email.required'        => 'Email aktif wajib diisi.',
                'no_hp.required'        => 'Nomor HP/WhatsApp wajib diisi.',
                'alamat.required'       => 'Alamat lengkap wajib diisi.',
                'keperluan.required'    => 'Tujuan pemanfaatan fasilitas wajib diisi.',
                'foto_ktp.required'     => 'Foto KTP wajib diunggah untuk verifikasi.',
                'foto_ktp.max'          => 'Ukuran foto KTP maksimal 3MB.',
            ]);

            $this->currentStep = 2;
            $this->dispatch('scroll-to-form');
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'tanggal_mulai'   => 'required|date|after_or_equal:today',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'jam_mulai'       => 'required',
                'jam_selesai'     => 'required',
                'selectedItems'   => 'required|array|min:1',
                'selectedItems.*.id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
                'selectedItems.*.jumlah'       => 'required|integer|min:1',
            ], [
                'tanggal_mulai.required' => 'Tanggal mulai pemakaian wajib diisi.',
                'tanggal_mulai.after_or_equal' => 'Tanggal mulai minimal hari ini.',
                'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
                'selectedItems.min'      => 'Minimal pilih 1 fasilitas yang dipesan.',
            ]);

            $this->currentStep = 3;
            $this->dispatch('scroll-to-form');
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('scroll-to-form');
        }
    }

    public function updatedTanggalMulai($value)
    {
        if ($this->tanggal_selesai < $value) {
            $this->tanggal_selesai = $value;
        }
    }

    public function updatedNik($value)
    {
        $this->nik = preg_replace('/[^0-9]/', '', $value);
    }

    public function updatedNoHp($value)
    {
        $this->no_hp = preg_replace('/[^0-9]/', '', $value);
    }

    public function bukaModalKonfirmasi()
    {
        // Honeypot protection: If bot filled hidden field, return fake success
        if (!empty($this->fax_hp)) {
            $this->bookingBerhasil = true;
            $this->createdNomorBooking = 'BK-' . Carbon::now()->format('Ymd') . '-0001';
            $this->dispatch('scroll-to-form');
            return;
        }

        $this->showConfirmModal = true;
    }

    public function tutupModalKonfirmasi()
    {
        $this->showConfirmModal = false;
    }

    public function kirimPemesanan()
    {
        // Honeypot protection check
        if (!empty($this->fax_hp)) {
            $this->showConfirmModal = false;
            $this->bookingBerhasil = true;
            $this->createdNomorBooking = 'BK-' . Carbon::now()->format('Ymd') . '-0001';
            $this->dispatch('scroll-to-form');
            return;
        }

        $this->showConfirmModal = false;
        // Store KTP photo
        $ktpPath = null;
        if ($this->foto_ktp) {
            $fileName = 'ktp_' . time() . '_' . rand(1000, 9999) . '.' . $this->foto_ktp->getClientOriginalExtension();
            $ktpPath = $this->foto_ktp->storeAs('ktp', $fileName, 'public');
        }

        // Generate unique booking number
        $dateCode = Carbon::now()->format('Ymd');
        $countToday = FasilitasPemesan::whereDate('created_at', Carbon::today())->count() + 1;
        $nomorBooking = 'BK-' . $dateCode . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        // Create Pemesan record
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
            'jam_mulai'       => $this->jam_mulai,
            'jam_selesai'     => $this->jam_selesai,
            'foto_ktp'        => $ktpPath,
            'status'          => 'Menunggu Konfirmasi',
            'catatan'         => 'Pengajuan dibuat secara online melalui website resmi UPTD Balatkop & UKM Kalsel.',
        ]);

        // Create Multi-Item Details
        foreach ($this->selectedItems as $item) {
            $idFas = $item['id_fasilitas'];
            $jumlah = $item['jumlah'] ?? 1;
            $tarif = $item['tarif'] ?? 0;
            $subtotal = $jumlah * $tarif;
            $ket = $item['keterangan'] ?? '';

            FasilitasPemesananDetail::create([
                'id_pemesanan' => $pemesan->id_pemesanan,
                'id_fasilitas' => $idFas,
                'jumlah'       => $jumlah,
                'tarif'        => $tarif,
                'subtotal'     => $subtotal,
                'keterangan'   => $ket,
            ]);
        }

        // Log Activity — userId null karena pemohon adalah tamu (bukan admin)
        FasilitasRiwayat::catatLog(
            aktivitas: 'Pengajuan Pemesanan Online',
            deskripsi: "Pemohon {$this->nama_pemohon} ({$this->instansi}) mengajukan sewa fasilitas secara online.",
            idPemesanan: $pemesan->id_pemesanan,
            nomorBooking: $nomorBooking,
            userId: null
        );

        $this->createdNomorBooking = $nomorBooking;
        $this->createdPemesan = $pemesan;
        $this->bookingBerhasil = true;
        $this->dispatch('scroll-to-form');
    }

    public function render()
    {
        $fasilitasAll = Fasilitas::with(['tarifs' => function ($q) {
            $q->where('status', 1)->orderBy('tanggal_mulai', 'desc');
        }])->where('status', 1)->get();

        return view('livewire.website.fasilitas.pesan-form', compact('fasilitasAll'));
    }
}

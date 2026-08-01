<?php

namespace App\Livewire\Website\Fasilitas;

use App\Models\FasilitasPemesan;
use Livewire\Component;

class CekStatusForm extends Component
{
    public string $nomor_booking = '';
    public string $verifikasi = ''; // NIK, No. HP, atau Email

    public bool $searchExecuted = false;
    public ?int $foundPemesanId = null;  // Simpan ID saja, bukan model (Livewire safe)
    public ?string $errorMessage = null;

    public function mount(): void
    {
        if (request()->has('booking')) {
            $this->nomor_booking = request()->get('booking');
        }
    }

    public function cariStatus(): void
    {
        $this->validate([
            'nomor_booking' => 'required|string',
            'verifikasi'    => 'required|string',
        ], [
            'nomor_booking.required' => 'Nomor booking wajib diisi.',
            'verifikasi.required'    => 'NIK, Nomor HP/WA, atau Email wajib diisi untuk verifikasi.',
        ]);

        $bookingVal = strtoupper(trim($this->nomor_booking));
        $verifVal   = trim($this->verifikasi);

        $pemesan = FasilitasPemesan::where('nomor_booking', $bookingVal)
            ->where(function ($q) use ($verifVal) {
                $q->where('nik', $verifVal)
                    ->orWhere('no_hp', $verifVal)
                    ->orWhere('email', $verifVal);
            })
            ->first();

        $this->searchExecuted = true;

        if ($pemesan) {
            $this->foundPemesanId = $pemesan->id_pemesanan;
            $this->errorMessage   = null;
        } else {
            $this->foundPemesanId = null;
            $this->errorMessage   = 'Data pemesanan tidak ditemukan. Mohon pastikan Nomor Booking dan NIK / No. HP / Email yang Anda masukkan sudah tepat.';
        }
    }

    public function resetCari(): void
    {
        $this->reset(['nomor_booking', 'verifikasi', 'searchExecuted', 'foundPemesanId', 'errorMessage']);
    }

    public function render()
    {
        // Query ulang fresh di setiap render agar relasi selalu termuat
        $foundPemesan = null;
        if ($this->foundPemesanId) {
            $foundPemesan = FasilitasPemesan::with(['details.fasilitas'])
                ->find($this->foundPemesanId);
        }

        return view('livewire.website.fasilitas.cek-status-form', compact('foundPemesan'));
    }
}

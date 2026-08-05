<?php

namespace App\Livewire\Website\Fasilitas;

use App\Models\FasilitasPemesan;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class CekStatusForm extends Component
{
    public string $nomor_booking = '';
    public string $verifikasi = ''; // NIK, No. HP, atau Email
    public string $fax_hp = '';     // Honeypot field untuk proteksi Bot / Spam

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
        // 1. Proteksi Honeypot Anti-Bot
        if (!empty($this->fax_hp)) {
            $this->searchExecuted = true;
            $this->foundPemesanId = null;
            $this->errorMessage   = 'Akses ditolak. Terdeteksi aktivitas otomatis/bot.';
            return;
        }

        // 2. Proteksi Rate Limiting (Maksimal 6 kali percobaan per 1 menit per IP)
        $throttleKey = 'cek-status-booking:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 6)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->searchExecuted = true;
            $this->foundPemesanId = null;
            $this->errorMessage   = "Terlalu banyak percobaan pencarian. Silakan tunggu {$seconds} detik sebelum mencoba kembali.";
            return;
        }

        // 3. Validasi Form
        $this->validate([
            'nomor_booking' => 'required|string|min:5|max:35',
            'verifikasi'    => 'required|string|min:4|max:100',
        ], [
            'nomor_booking.required' => 'Nomor booking wajib diisi.',
            'nomor_booking.min'      => 'Nomor booking minimal 5 karakter.',
            'verifikasi.required'    => 'NIK, Nomor HP/WA, atau Email wajib diisi untuk verifikasi.',
            'verifikasi.min'         => 'Data verifikasi minimal 4 karakter.',
        ]);

        $bookingVal = strtoupper(trim($this->nomor_booking));
        $verifVal   = trim($this->verifikasi);

        // 4. Query Database (Safe Eloquent Parameter Binding - Anti SQL Injection)
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
            RateLimiter::clear($throttleKey); // Reset rate limiter jika berhasil
        } else {
            RateLimiter::hit($throttleKey, 60); // Tambah hit jika gagal
            $this->foundPemesanId = null;
            $this->errorMessage   = 'Data pemesanan tidak ditemukan. Mohon pastikan Nomor Booking dan NIK / No. HP / Email yang Anda masukkan sudah tepat.';
        }
    }

    public function resetCari(): void
    {
        $this->reset(['nomor_booking', 'verifikasi', 'fax_hp', 'searchExecuted', 'foundPemesanId', 'errorMessage']);
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

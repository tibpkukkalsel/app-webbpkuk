<?php

namespace App\Livewire\Admin\Kontak;

use App\Mail\ReplyKontakMail;
use App\Models\Kontak;
use App\Models\KontakBalasan;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Detail extends Component
{
    public $kontakId = null;
    public $kontak = null;
    public $subjek_balasan = '';
    public $pesan_balasan = '';
    public $isSending = false;

    protected $listeners = [
        'open-detail-kontak' => 'loadKontak',
        'kontak-refresh' => '$refresh',
    ];

    public function loadKontak($id)
    {
        $this->kontakId = $id;
        $this->kontak = Kontak::with(['balasan.user'])->find($id);

        if ($this->kontak) {
            if ($this->kontak->status === 'unread') {
                $this->kontak->update(['status' => 'read']);
                $this->dispatch('kontak-refresh');
            }

            $this->subjek_balasan = 'Re: ' . $this->kontak->subjek;
            $this->pesan_balasan = '';
        }
    }

    public function resetKontak()
    {
        $this->kontakId = null;
        $this->kontak = null;
        $this->subjek_balasan = '';
        $this->pesan_balasan = '';
    }

    public function sendReply()
    {
        $this->validate([
            'subjek_balasan' => 'required|string|max:255',
            'pesan_balasan' => 'required|string|min:5',
        ], [
            'subjek_balasan.required' => 'Subjek balasan wajib diisi.',
            'pesan_balasan.required' => 'Pesan balasan tidak boleh kosong.',
            'pesan_balasan.min' => 'Pesan balasan minimal 5 karakter.',
        ]);

        if (!$this->kontak) {
            session()->flash('error', 'Pesan kontak tidak ditemukan.');
            return;
        }

        try {
            $this->isSending = true;

            $balasan = KontakBalasan::create([
                'kontak_id' => $this->kontak->id,
                'user_id' => auth()->id(),
                'subjek_balasan' => $this->subjek_balasan,
                'pesan_balasan' => $this->pesan_balasan,
                'sent_at' => now(),
            ]);

            Mail::to($this->kontak->email)->send(new ReplyKontakMail($this->kontak, $balasan));

            $this->kontak->update(['status' => 'replied']);

            $this->loadKontak($this->kontak->id);

            session()->flash('success', 'Balasan email berhasil dikirim ke ' . $this->kontak->email);
            $this->dispatch('kontak-refresh');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat pengiriman email: ' . $e->getMessage());
        } finally {
            $this->isSending = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.kontak.detail');
    }
}

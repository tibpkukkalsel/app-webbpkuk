<?php

namespace App\Mail;

use App\Models\FasilitasPemesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonfirmasiStatusPemesananToPemesan extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesan;

    public function __construct(FasilitasPemesan $pemesan)
    {
        $this->pemesan = $pemesan->loadMissing(['details.fasilitas']);
    }

    public function envelope(): Envelope
    {
        $statusLabel = strtoupper($this->pemesan->status ?? 'DIUPDATE');
        return new Envelope(
            subject: "[KONFIRMASI RESMI BALATKOP-UK] Status Sewa Fasilitas ({$statusLabel}) - " . $this->pemesan->nomor_booking,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pemesanan_status_confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

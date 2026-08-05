<?php

namespace App\Mail;

use App\Models\FasilitasPemesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPemesananBaruToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $pemesan;

    public function __construct(FasilitasPemesan $pemesan)
    {
        $this->pemesan = $pemesan->loadMissing(['details.fasilitas']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[NOTIFIKASI BALATKOP-UK] Permohonan Sewa Fasilitas Baru - ' . $this->pemesan->nomor_booking,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pemesanan_admin_notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

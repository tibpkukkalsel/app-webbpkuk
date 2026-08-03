<?php

namespace App\Mail;

use App\Models\Kontak;
use App\Models\KontakBalasan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyKontakMail extends Mailable
{
    use Queueable, SerializesModels;

    public Kontak $kontak;
    public KontakBalasan $balasan;

    public function __construct(Kontak $kontak, KontakBalasan $balasan)
    {
        $this->kontak = $kontak;
        $this->balasan = $balasan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('bpkuk.provkalsel@gmail.com', 'Balatkop UKM Kalsel'),
            replyTo: [new Address('bpkuk.provkalsel@gmail.com', 'Balatkop UKM Kalsel')],
            subject: $this->balasan->subjek_balasan ?? ('Re: ' . $this->kontak->subjek),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reply_kontak',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

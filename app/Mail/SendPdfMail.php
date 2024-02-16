<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;
use Mpdf\Mpdf;

class SendPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $book;
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Pdf Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $data = [
            'book'      => $this->book['id_booking'],
            'kode_book' => $this->book['kode_booking'],
            'jurusan'   => $this->book['rute']['jurusan'],
            'rute'      => $this->book['rute']['rute'],
            'tujuan'    => $this->book['tujuan']['nama_kota'],
            'peserta'   => $this->book['detail'],
        ];

        $view = 'dashboard.pages.booking.ticket';

        return (new Content($view))->with($data);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

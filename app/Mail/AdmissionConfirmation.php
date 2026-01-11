<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdmissionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Admission $admission,
        public string $pdfPath
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admission Application Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admission-confirmation',
        );
    }

    public function attachments(): array
    {
        return [
            $this->pdfPath
        ];
    }
}

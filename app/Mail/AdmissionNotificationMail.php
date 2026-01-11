<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdmissionNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admission;

    public function __construct($admission)
    {
        $this->admission = $admission;
    }

    public function build()
    {
        return $this->subject('🎓 New Admission Application - ' . $this->admission->full_name)
                    ->view('emails.admission-notification')
                    ->with([
                        'admission' => $this->admission,
                    ]);
    }
}

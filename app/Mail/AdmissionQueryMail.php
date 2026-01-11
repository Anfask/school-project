<?php
// app/Mail/AdmissionQueryMail.php
namespace App\Mail;

use App\Models\AdmissionQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class AdmissionQueryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $query;
    public $type;
    public $pdf;

    public function __construct(AdmissionQuery $query, $type = 'admin', $pdf = null)
    {
        $this->query = $query;
        $this->type = $type;
        $this->pdf = $pdf;
    }

    public function build()
    {
        if ($this->type === 'admin') {
            $subject = 'New Admission Application: ' . $this->query->full_name;
            $view = 'emails.admin-notification';
        } else {
            $subject = 'Admission Application Received - P.A. Inamdar School';
            $view = 'emails.applicant-notification';
        }

        $mail = $this->subject($subject)
                    ->view($view)
                    ->with(['query' => $this->query]);

        if ($this->pdf && $this->type === 'applicant') {
            $mail->attachData($this->pdf->output(),
                $this->query->application_number . '_application.pdf', [
                    'mime' => 'application/pdf',
                ]);
        }

        return $mail;
    }
}

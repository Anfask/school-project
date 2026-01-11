<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StudentApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $pdfPath;
    public $statusColors;
    public $emailData;

    /**
     * Create a new message instance.
     */
    public function __construct($application, $pdfPath = null, $emailData = [])
    {
        $this->application = $application;
        $this->pdfPath = $pdfPath;
        $this->emailData = $emailData;
        $this->statusColors = [
            'pending' => '#f59e0b',
            'reviewed' => '#3b82f6',
            'accepted' => '#10b981',
            'rejected' => '#ef4444'
        ];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->emailData['subject'] ?? 'Application Status Update - ' . config('app.name');

        $mail = $this->subject($subject)
            ->view('emails.student-application-status')
            ->with([
                'application' => $this->application,
                'statusColors' => $this->statusColors,
                'emailData' => $this->emailData
            ]);

        // Attach PDF if available
        if ($this->pdfPath && Storage::exists($this->pdfPath)) {
            $mail->attach(Storage::path($this->pdfPath), [
                'as' => 'Application-' . $this->application->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}

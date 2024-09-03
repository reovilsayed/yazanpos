<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyDueReport extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $users;
    /**
     * Create a new message instance.
     */
    public function __construct($pdfContent, $users)
    {
        $this->pdfContent = $pdfContent;
        $this->users = $users;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Monthly Due Reports',
        );
    }

    /**
     * Get the message content definition.
     */

    public function build()
    {

        return $this->view('emails.monthlyDueReports')
            ->attachData($this->pdfContent->output(), 'monthly_due_report.pdf', [
                'mime' => 'application/pdf',
            ]);
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

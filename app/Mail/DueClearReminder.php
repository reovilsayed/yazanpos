<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueClearReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $orders;
    public $customer;
    /**
     * Create a new message instance.
     */
    public function __construct($orders, $customer)
    {
        $this->orders = $orders;
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->view('emails.DueClearReminder');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Urgent: Payment Reminder for Your Recent Purchase',
        );
    }

    /**
     * Get the message content definition.
     */


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

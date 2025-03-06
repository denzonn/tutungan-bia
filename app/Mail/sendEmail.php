<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data_email;
    /**
     * Create a new message instance.
     */
    public function __construct($data_email)
    {
        $this->data_email = $data_email;
    }

    public function build()
    {
        return $this->subject($this->data_email['subject']) // Harus pakai []
            ->from($this->data_email['email_sender'])
            ->view('pages.email');
    }
}

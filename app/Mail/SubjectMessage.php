<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubjectMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $mail = ['subject' => '','message' => ''];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message)
    {
        $this->mail['subject'] = $subject;
        $this->mail['message'] = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@example.com', 'CSV File Sender')
        ->subject('CSV File')
        ->markdown('mails.subject-message');
    }
}

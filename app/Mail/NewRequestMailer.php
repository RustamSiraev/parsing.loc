<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRequestMailer extends Mailable
{
    use Queueable, SerializesModels;

    private array $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public function build(): NewRequestMailer
    {
        $title = 'Новое сообщение';

        return $this->subject($title)
            ->view('applicant.contacts.new-message')
            ->with([
                'user' => $this->message['user'],
                'email' => $this->message['email'],
                'theme' => $this->message['title'],
                'body' => $this->message['body'],
            ]);
    }
}

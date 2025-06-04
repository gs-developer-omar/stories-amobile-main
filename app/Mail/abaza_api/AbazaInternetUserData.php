<?php

namespace App\Mail\abaza_api;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbazaInternetUserData extends Mailable
{
    use Queueable, SerializesModels;
    public string $fio;
    public string $address;
    public string $phone;
    public string $mail_from_address;
    public string $mail_from_name;
    public string $mail_subject = "Заявка на подключение интернета";
    public const MAIL_RECIPIENTS = [
        "harchilavaarsen2@gmail.com",
    ];

    /**
     * Create a new message instance.
     */
    public function __construct($userData)
    {
        $this->fio = $userData['fio'];
        $this->address = $userData['address'];
        $this->phone = $userData['phone'];
        $this->mail_from_address = config('mail.from.abaza.address', 'verification@a-mobile.biz');
        $this->mail_from_name = config('mail.from.abaza.name', 'Абаза Телеком');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->mail_from_address, $this->mail_from_name),
            replyTo: [
                new Address($this->mail_from_address, $this->mail_from_name),
            ],
            subject: $this->mail_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.abaza-internet-user-data',
        );
    }

    protected function buildRecipients($message): AbazaInternetUserData
    {
        foreach (self::MAIL_RECIPIENTS as $recipient) {
            $message->to($recipient);
        }
        return parent::buildRecipients($message);
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

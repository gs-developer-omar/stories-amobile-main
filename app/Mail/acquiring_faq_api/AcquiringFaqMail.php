<?php

namespace App\Mail\acquiring_faq_api;

use App\DTOs\AcquiringFaqFormDTO;
use App\Mail\ApplicantMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcquiringFaqMail extends Mailable
{
    use Queueable, SerializesModels;

    public AcquiringFaqFormDTO $acquiringFaqFormData;

    /**
     * Create a new message instance.
     */
    public function __construct(AcquiringFaqFormDTO $acquiringFaqFormData)
    {
        $this->acquiringFaqFormData = $acquiringFaqFormData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $mailFromAddress = config('acquiring_faq_mail.mail_from_address');
        $mailFromName = config('acquiring_faq_mail.mail_from_name');
        $mailSubject = config('acquiring_faq_mail.mail_subject');

        return new Envelope(
            from: new Address($mailFromAddress, $mailFromName),
            replyTo: [
                new Address($mailFromAddress, $mailFromName),
            ],
            subject: $mailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.acquiring-faq-mail',
        );
    }

    protected function buildRecipients($message): AcquiringFaqMail
    {
        $mailRecipients = config('acquiring_faq_mail.mail_recipients');
        $mailRecipientsArr = explode(',', $mailRecipients);
        foreach ($mailRecipientsArr as $recipient) {
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

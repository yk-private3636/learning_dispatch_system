<?php

namespace App\Mail;

use App\Models\GeneralUser;
use App\Models\AdminUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public GeneralUser|AdminUser $user
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('mail.password.reset.complete.subject'),
            from: config('mail.from.address'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'template.mail.reset_passwoed_complete',
            with: [
                'forgetUrl' => match ($this->user::class) {
                    \UserEnum::GENERAL->model() => route('login.forget.show'),
                    \UserEnum::ADMIN->model()   => url(\CommonConst::ADMIN_PREFIX . '/login/forget'),
                }
            ]
        );
    }

    /**
     * Get the attachments for the message.pe
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

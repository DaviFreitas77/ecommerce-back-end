<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class mailOrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $numberOrder;
    /**
     * Create a new message instance.
     */
    public function __construct(string $name,string $numberOrder)
    {
        $this->name = $name;
        $this->numberOrder = $numberOrder;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('freitaadavi20@gmail.com', 'Bazar virtual'),
            subject: 'Uhuul,pagamento confirmado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.viewMailOrderCreated',
            with: ['name' => $this->name,'order'=>$this->numberOrder]
        );
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

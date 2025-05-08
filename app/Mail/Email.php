<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Produto;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $produto;

    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo Produto Criado',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.blase.php', 
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
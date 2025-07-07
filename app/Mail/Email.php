<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Tarefa;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $tarefa;

    public function __construct(Tarefa $tarefa)
    {
        $this->tarefa = $tarefa;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nova Tarefa Criada',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.email', 
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $codigo,
        public string $nombre
    ) {}

    public function build(): static
    {
        return $this->subject('Código de verificación de acceso')
                    ->view('emails.codigo_verificacion');
    }
}
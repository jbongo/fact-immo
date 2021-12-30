<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ValidationFichier extends Mailable
{
    use Queueable, SerializesModels;
    public $fichier;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Document refusé")->markdown('email.validation_fichier')
        ->attach($this->fichier->url);
    }
}

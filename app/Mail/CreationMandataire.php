<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreationMandataire extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire,$password)
    {
        //
        $this->mandataire = $mandataire;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Outil de facturation - Vos informations de connexion")->markdown('email.creation_mandataire');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvoyerFactureStylimmoMandataire extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $facture;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire,$facture)
    {
        //
        $this->mandataire = $mandataire;
        $this->facture = $facture;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.envoyer_facture_stylimmo_mandataire')
        ->attach($this->facture->url);
        ;
    }
}

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
    public $numero_facture;
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
        $this->numero_facture = $facture->numero;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("STYL'IMMO Facture F$this->numero_facture")->markdown('email.envoyer_facture_stylimmo_mandataire')
        ->attach($this->facture->url);
        ;
    }
}

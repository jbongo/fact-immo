<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DemandeFactureStylimmo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mandataire;
    public function __construct($mandataire)
    {
        //
        $this->mandataire = $mandataire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Demande de facture STYL'IMMO")->markdown('email.demande_facture_stylimmo');
    }
}

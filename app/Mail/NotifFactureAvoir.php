<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifFactureAvoir extends Mailable
{
    use Queueable, SerializesModels;
    public $facture_avoir ;
    public $mandataire ;
    public $facture ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture_avoir, $facture, $mandataire)
    {
        $this->facture_avoir = $facture_avoir;
        $this->facture = $facture;
        $this->mandataire = $mandataire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Avoir sur facture")->markdown('email.notif_facture_avoir')
        ->attach($this->facture_avoir->url)
        ->attach($this->facture->url);
    }
}

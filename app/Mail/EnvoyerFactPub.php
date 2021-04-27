<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvoyerFactPub extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $facture;
    public $numero_facture;
    public $mois;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture)
    {
        //
        $tabmois = ['','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre'];
        
        $this->mandataire = $facture->user;
        $this->facture = $facture;
        $this->numero_facture = $facture->numero;
        $this->mois = $tabmois[$facture->factpublist()->created_at->format('m')*1];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Facture Pub et logiciel $this->mois F$this->numero_facture")->markdown('email.envoyer_fact_pub')
        ->attach($this->facture->url);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassageTVA extends Mailable
{
    use Queueable, SerializesModels;
    
    public $mandataire;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire)
    {
        $this->mandataire = $mandataire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Outil de facturation - Passage à la TVA")->markdown('email.passage_tva');

    }
}

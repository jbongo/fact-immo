<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifEvolutionFilleul extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $mandataire_filleul;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire, $mandataire_filleul)
    {
        $this->mandataire = $mandataire;
        $this->mandataire_filleul = $mandataire_filleul;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Expiration parrainage")->markdown('email.notif_evolution_filleul');
    }
}

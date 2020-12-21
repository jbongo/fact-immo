<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifChangementPalier extends Mailable
{
    use Queueable, SerializesModels;
    
    public $mandataire;
    public $ancien_pourcentant;
    public $nouveau_pourcentant;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire, $ancien_pourcentant, $nouveau_pourcentant)
    {
        $this->mandataire = $mandataire;
        $this->ancien_pourcentant = $ancien_pourcentant;
        $this->nouveau_pourcentant = $nouveau_pourcentant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notif_changement_palier');
    }
}

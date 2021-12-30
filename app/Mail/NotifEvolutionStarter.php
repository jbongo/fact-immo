<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifEvolutionStarter extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $ancienne_comm;
    public $nouvelle_comm;
    public $duree_starter;
    public $date_deb_activite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire,$duree_starter, $date_deb_activite, $ancienne_comm, $nouvelle_comm)
    {
        $this->mandataire = $mandataire;
        $this->duree_starter = $duree_starter;
        $this->date_deb_activite = $date_deb_activite;
        $this->ancienne_comm = $ancienne_comm;
        $this->nouvelle_comm = $nouvelle_comm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Passage de starter à expert")->markdown('email.notif_evolution_starter');

    }
}

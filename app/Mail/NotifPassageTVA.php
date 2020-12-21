<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifPassageTVA extends Mailable
{
    use Queueable, SerializesModels;

    public $mandataire;
    public $ca;
    public $catva;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire, $ca, $catva)
    {
        $this->mandataire = $mandataire ;
        $this->ca = $ca ;
        $this->catva = $catva ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notif_passage_tva');
    }
}

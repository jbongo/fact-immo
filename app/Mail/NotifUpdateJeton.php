<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifUpdateJeton extends Mailable
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
        return $this->subject("MINICURIEUX - Mise à jour de vos jetons")->markdown('email.notif_update_jeton');

    }
}

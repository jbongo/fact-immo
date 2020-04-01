<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ModifCompromis extends Mailable
{
    use Queueable, SerializesModels;
    public $compromis;
    public $requestcompromis;
    public $destinataire;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($compromis, $requestcompromis,$destinataire)
    {
        $this->compromis = $compromis;
        $this->requestcompromis = $requestcompromis;
        $this->destinataire = $destinataire;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mandat = $this->compromis->numero_mandat;
        return $this->subject("Modification du mandat $mandat")->markdown('email.modif_compromis');
    }
}

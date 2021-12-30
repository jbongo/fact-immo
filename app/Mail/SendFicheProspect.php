<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFicheProspect extends Mailable
{
    use Queueable, SerializesModels;
    
public $prospect;
public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($prospect, $url)
    {
        $this->prospect = $prospect ;
        $this->url = $url ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Mise à jour de votre fiche Info")->markdown('email.sendficheprospect');

    }
}


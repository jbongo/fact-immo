<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifFinDroitSuite extends Mailable
{
    use Queueable, SerializesModels;
    public $contrat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrat)
    {
        $this->contrat = $contrat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Fin de vos droits de suite")->markdown('email.fin_droit_suite');

    }
}

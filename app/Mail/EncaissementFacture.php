<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EncaissementFacture extends Mailable
{
    use Queueable, SerializesModels;
    public $facture;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($facture)
    {
        //
        $this->facture = $facture;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.encaissement_facture');
    }
}

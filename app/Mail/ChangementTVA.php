<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangementTVA extends Mailable
{
    use Queueable, SerializesModels;
    
    public $ancienne_tva;
    public $nouvelle_tva;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ancienne_tva, $nouvelle_tva)
    {
        $this->ancienne_tva = $ancienne_tva;
        $this->nouvelle_tva = $nouvelle_tva;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Changement TVA")->markdown('email.changement_tva');

    }
}

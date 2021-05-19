<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendModeleContrat extends Mailable
{
    use Queueable, SerializesModels;
    public $prospect;
    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($prospect, $pdf)
    {
        $this->prospect = $prospect ;
        $this->pdf = $pdf ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("STYL'IMMO - Modèle de contrat")->markdown('email.sendmodelecontrat')
        ->attach($this->pdf);;

    }
}

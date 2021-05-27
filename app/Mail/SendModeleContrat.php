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
    public $modele_contrat_pdf;
    public $annexe_pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($prospect, $modele_contrat_pdf, $annexe_pdf)
    {
        $this->prospect = $prospect ;
        $this->modele_contrat_pdf = $modele_contrat_pdf ;
        $this->annexe_pdf = $annexe_pdf ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("STYL'IMMO - Modèle de contrat")->markdown('email.sendmodelecontrat')
        ->attach($this->annexe_pdf)
        ->attach($this->modele_contrat_pdf)
        ;

    }
}

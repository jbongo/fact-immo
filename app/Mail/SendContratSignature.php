<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContratSignature extends Mailable
{
    use Queueable, SerializesModels;
    public $contrat;
    public $contrat_pdf;
    public $annexe_pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrat, $contrat_pdf, $annexe_pdf)
    {
        $this->contrat = $contrat ;
        $this->contrat_pdf = $contrat_pdf ;
        $this->annexe_pdf = $annexe_pdf ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Signature de contrat")->markdown('email.send_contrat_signature')
        ->attach($this->annexe_pdf)
        ->attach($this->contrat_pdf)
        ;
    }
}

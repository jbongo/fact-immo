<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifDocumentExpire extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $documents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire, $documents)
    {
        
        $this->mandataire = $mandataire;
        $this->documents = $documents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MINICURIEUX - Expiration document")->markdown('email.notif_expiration_document');

    }
}

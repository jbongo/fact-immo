<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreationMandataire extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $password;
    public $path_forfait;
    public $path_cci;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire,$password,$path_forfait,$path_cci)
    {
        //
        $this->mandataire = $mandataire;
        $this->password = $password;
        
        $this->path_forfait = $path_forfait;
        $this->path_cci = $path_cci;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Outil de facturation - Vos informations de connexion")->markdown('email.creation_mandataire')
        ->attach($this->path_forfait)
        ->attach($this->path_cci);
    }
}

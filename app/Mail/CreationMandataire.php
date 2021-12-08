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
    public $path_contrat;
    public $path_annexe;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire,$password,$path_forfait= null,$path_cci= null,$path_contrat= null,$path_annexe= null)
    {
        //
        $this->mandataire = $mandataire;
        $this->password = $password;
        
        $this->path_forfait = $path_forfait;
        $this->path_cci = $path_cci;
        $this->path_contrat = $path_contrat;
        $this->path_annexe = $path_annexe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        if($this->path_forfait != null && $this->path_cci != null && $this->path_contrat != null && $this->path_annexe != null ){
            
            return $this->subject("Outil de facturation - Vos informations de connexion")->markdown('email.creation_mandataire')
            ->attach($this->path_forfait)
            ->attach($this->path_cci)
            ->attach($this->path_annexe)
            ->attach($this->path_contrat);
        }
        
        return $this->subject("Outil de facturation - Vos informations de connexion")->markdown('email.creation_mandataire');
        
       
    }
}

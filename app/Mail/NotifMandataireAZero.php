<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifMandataireAZero extends Mailable
{
    use Queueable, SerializesModels;
    public $mandataire;
    public $date_deb_activite;
    public $ancienne_comm;
    public $nouvelle_comm;
    public $date_deb;
    public $date_fin;
    public $chiffre_affaire;
    public $nb_vente;
    public $nb_filleul;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mandataire, $date_deb_activite, $ancienne_comm, $nouvelle_comm, $date_deb, $date_fin, $chiffre_affaire, $nb_vente, $nb_filleul)
    {
        


        $this->mandataire = $mandataire;
        $this->date_deb_activite = $date_deb_activite;
        $this->ancienne_comm = $ancienne_comm;
        $this->nouvelle_comm = $nouvelle_comm;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->chiffre_affaire = $chiffre_affaire;
        $this->nb_vente = $nb_vente;
        $this->nb_filleul = $nb_filleul;

        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
        return $this->subject("Mise à jour de votre commission")->markdown('email.notif_mandataire_zero');
       

    }
}

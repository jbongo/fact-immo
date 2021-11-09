<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDocument extends Mailable
{
    use Queueable, SerializesModels;
    public $document;
    public $user;
    public $type_user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($document, $user, $type_user)
    {
        $this->document = $document ;
        $this->user = $user ;
        $this->type_user = $type_user ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
        $this->url = route('bibliotheque.show',[$this->document->id,$this->user->id,$this->type_user]);
        
        $nom = $this->document->nom;
        return $this->subject("STYL'IMMO - $nom")->markdown('email.send_document');

    }
}

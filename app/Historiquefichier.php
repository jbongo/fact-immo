<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Document;
use App\Fichier;
use App\User;

class Historiquefichier extends Model
{
    //
    protected $guarded =[];
    protected $dates = ['date_expiration']; 
    
    
    // Retourn le document correcpond à l'historique du fichier
    public function document(){
        
        $document = Document::where('id', $this->document_id)->first();
        
        return $document;
    }
    
    
    // retourne le fichier initiale 
    public function fichier(){
        
        $fichier = Fichier::where([['document_id', $this->document_id], ['user_id', $this->user_id]])->first();
        
        return $fichier;
    }
    
    
    public function user(){
    
        return  $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
    //

    protected $guarded =[];
    
    protected $dates =['date_expiration'];
    
    public function document(){
    
        return $this->belongsTo(Document::class);

    }
    
    public function est_image(){    
        return in_array($this->extension, ['.png','.jpg','.jpeg','.gif']) ;
    }
    
    // Si le fichier est une image, on copie le fichier dans un repertoir tmp public et on renvoie le lien vers le fichier
    public function lien_public_image(){
        
        if(file_exists($this->url) && copy($this->url, "tmp/{$this->document->reference}_{$this->user_id}")){
            return "/tmp/{$this->document->reference}_{$this->user_id}";
        
        }
    }
}

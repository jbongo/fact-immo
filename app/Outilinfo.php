<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outilinfo extends Model
{
    protected $guarded =[];
    
    
     /**
     * Déserialiser les champs
     *
     * @return \Illuminate\Http\Response
     */
    public static function champs_unserialize($param)
    {
        // on construit un tableau sans les &
        $palier = explode("&", $param);
        $array = array();
  
        foreach($palier as $pal)
        {
            // pour chaque element du tableau, on extrait la valeur
            $tmp = substr($pal , strpos($pal, "=") + 1, strlen($pal));
            array_push($array, $tmp);
        }
        // on divise le nouveau tableau de valeur en 4 tableau de même taille
        $chunk = array_chunk($array, 2);
        // syupprime le premier tableau de notre tableau
        // array_shift($chunk);

        return $chunk;
    }
    
    /**
     * Déserialiser les champs
     *
     * @return \Illuminate\Http\Response
     */
    public  function champs()
    {
 
        // on construit un tableau sans les &
        $palier = explode("&", $this->champs_valeurs);
        $array = array();
  
        foreach($palier as $pal)
        {
            // pour chaque element du tableau, on extrait la valeur
            $tmp = substr($pal , strpos($pal, "=") + 1, strlen($pal));
            array_push($array, $tmp);
        }
        // on divise le nouveau tableau de valeur en 2 tableau de même taille
        $chunk = array_chunk($array, 2);
        // syupprime le premier tableau de notre tableau
        // array_shift($chunk);

        return $chunk;
    }
    
     
    /**
     * Affiche retourne un outil de la fiche du mandataire
     *
     * @return \Illuminate\Http\Response
     */
    public  function useroutil($fiche_info_id)
    {
 
        $outil = Outilfiche::where([['ficheinfo_id', $fiche_info_id], ['outilinfo_id', $this->id]])->first();
        
        return $outil;
    }
}

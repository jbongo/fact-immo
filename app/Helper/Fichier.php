<?php 


// Retourne true si le fichier est une image
function est_image($url){
      return file_exists($url) && is_array(getimagesize($url)) ;
}


// On copie le fichier dans un repertoir tmp public et on renvoie le lien vers le fichier
function lien_public_fichier($url, $filename = "fichier"){
    
    if(file_exists($url) && copy($url, "tmp/{$filename}")){
        return "/tmp/{$filename}";
    
    }
    return false;
}

?>
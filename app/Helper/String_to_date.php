<?php 

function string_to_date($string_date, $lang="fr"){


    if($lang == "en"){
      $date =  date('Y-m-d',strtotime( $string_date));
    }else{
    
        $date =  date('d/m/Y',strtotime( $string_date));
    
    }
    
    return $date;
}
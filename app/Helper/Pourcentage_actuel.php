<?php 

// Retourne le Pourcentage actuel du mandataire à partir de sa facture d'honoraire
     function pourcentage_actuel($formule){
        
        $formule = unserialize($formule);
        
        
        return $formule[0][0][1];
    }
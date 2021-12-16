<?php

// Convertir un nombre en lettre
function lettre_en_nombre($a){
	if ($a<0) return 'moins '.lettre_en_nombre(-$a);
	if ($a<17){
		switch ($a){
			case 0: return 'zero';
			case 1: return 'un';
			case 2: return 'deux';
			case 3: return 'trois';
			case 4: return 'quatre';
			case 5: return 'cinq';
			case 6: return 'six';
			case 7: return 'sept';
			case 8: return 'huit';
			case 9: return 'neuf';
			case 10: return 'dix';
			case 11: return 'onze';
			case 12: return 'douze';
			case 13: return 'treize';
			case 14: return 'quatorze';
			case 15: return 'quinze';
			case 16: return 'seize';
		}
	} else if ($a<20){
		return 'dix-'.lettre_en_nombre($a-10);
	} else if ($a<100){
		if ($a%10==0){
			switch ($a){
				case 20: return 'vingt';
				case 30: return 'trente';
				case 40: return 'quarante';
				case 50: return 'cinquante';
				case 60: return 'soixante';
				case 70: return 'soixante-dix';
				case 80: return 'quatre-vingt';
				case 90: return 'quatre-vingt-dix';
			}
		} else if ($a<70){
			return lettre_en_nombre($a-$a%10).'-'.lettre_en_nombre($a%10);
		} else if ($a<80){
			return lettre_en_nombre(60).'-'.lettre_en_nombre($a%20);
		} else{
			return lettre_en_nombre(80).'-'.lettre_en_nombre($a%20);
		}
	} else if ($a==100){
		return 'cent';
	} else if ($a<200){
		return lettre_en_nombre(100).($a%100!=0?' '.lettre_en_nombre($a%100):'');
	} else if ($a<1000){
		return lettre_en_nombre((int)($a/100)).' '.lettre_en_nombre(100).' '.($a%100!=0?lettre_en_nombre($a%100):'');
	} else if ($a==1000){
		return 'mille';
	} else if ($a<2000){
		return lettre_en_nombre(1000).($a%1000!=0?' '.lettre_en_nombre($a%1000):'');
	} else if ($a<1000000){
		return lettre_en_nombre((int)($a/1000)).' '.lettre_en_nombre(1000).' '.($a%1000!=0?lettre_en_nombre($a%1000):'');
	}  
	
	else return $a;
}

?>
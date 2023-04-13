@php
    

// ----parametre de taille
//Largeur
@$width='200';

//Hauteur
@$height='20';

//---------------------------
$g= $bien->biendetail->_diagnostic_dpe_ges;
if(@$width=='') { $width='300'; $height='36'; } else{}


if ( $g =='') {	echo "<table border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-1'><b>GES non communiqu&eacute;</b></font></td></tr>";
	echo "</table>"; 

} else {

if ( $g <= 5 OR $g== 'A' OR  $g=='a') 			{  	$gaza='gaz-a.png'; $valuea=$g; } else { 	$gaza='gaz-a-v.png'; $valuea=''; }
if ( $g >= 6 && $g <= 10 OR $g=='B' OR  $g=='b') 	{  	$gazb='gaz-b.png'; $valueb=$g; $gaza='gaz-a-v.png';} else { 	$gazb='gaz-b-v.png'; $valueb=''; } 
if ( $g >= 11 && $g <= 20 OR $g=='C' OR  $g=='c' ) 	{ 	$gazc='gaz-c.png'; $valuec=$g; $gaza='gaz-a-v.png';} else { 	$gazc='gaz-c-v.png'; $valuec=''; }
if ( $g >= 21 && $g <= 35 OR $g=='D' OR  $g=='d') 	{  	$gazd='gaz-d.png'; $valued=$g; $gaza='gaz-a-v.png';} else { 	$gazd='gaz-d-v.png'; $valued=''; }
if ( $g >= 36 && $g <= 55 OR $g=='E' OR  $g=='e') 	{  	$gaze='gaz-e.png'; $valuee=$g; $gaza='gaz-a-v.png';} else { 	$gaze='gaz-e-v.png'; $valuee=''; }
if ( $g >= 56 && $g <= 80 OR $g=='F' OR  $g=='f') 	{  	$gazf='gaz-f.png'; $valuef=$g; $gaza='gaz-a-v.png';} else { 	$gazf='gaz-f-v.png'; $valuef=''; }
if ( $g > 80 OR $g=='G' OR $g=='g') 			{  	$gazg='gaz-g.png'; $valueg=$g; $gaza='gaz-a-v.png';} else { 	$gazg='gaz-g-v.png'; $valueg=''; }


	echo "<table border='0' cellspacing='0' cellpadding='0'>";	
	echo "<tr><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-1'><b>Faible &eacute;mission de GES*</b></font></td></tr>";	
	echo "</table>";
		
	if(!isset($nopdf)){
	echo "<table border='0' cellspacing='0' cellpadding='0'>";	
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gaza' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuea&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gazb' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueb&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gazc' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuec&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gazd' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valued&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gaze' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuee&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gazf' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuef&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$gazg' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueg&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "</table>";
	}

	else if($nopdf && $nopdf == 1){
		echo "<table border='0' cellspacing='0' cellpadding='0'>";	
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gaza' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuea&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gazb' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueb&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gazc' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuec&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gazd' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valued&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gaze' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuee&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gazf' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuef&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$gazg' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueg&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
	echo "</table>";
	}

	echo "<br>";
	
	echo "<table border='0' cellspacing='0' cellpadding='0'>";	
	echo "<tr><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-1'><b>Forte &eacute;mission de GES*</b></font></td></tr>";
	echo "</table>";

	echo "<table border='0' cellspacing='0' cellpadding='0'>";	
	echo "<tr valign=top><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-2'>* Gaz &agrave; effet de serre en <b>Kg</b>eqCO2/<b>m&sup2;.an</b></font></td></tr>";
	echo "</table>";
}
@endphp
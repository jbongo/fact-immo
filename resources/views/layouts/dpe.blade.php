     @php
	
    // ----parametre de taille
    //Largeur
    @$width='200';
    
    //Hauteur
    @$height='20';
    
    //---------------------------
    $e= $bien->biendetail->diagnostic_dpe_consommation;
    
    
    if(@$width=='') { $width='300'; $height='36'; } else{}
    
    
    if ( $e =='') {
        echo "<table border='0' cellspacing='0' cellpadding='0'>";	echo "<tr><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-1'><b>Energie non communiqu&eacute;</b></font></td></tr>";	
        echo "</table>"; 
            
        } else {
    
    if($e=='A' OR  $e=='a' OR $e=='B' OR $e=='b' OR $e=='C' OR $e=='c' OR $e=='D' OR $e=='d' OR $e=='E' OR $e=='e' OR $e=='F' OR $e=='f' OR $e=='G' OR $e=='g')
    
    {
    
    if ( $e=='A' OR $e=='a') 		{  	$energiea='energie-a.png'; $valuea=$e; } else { 	$energiea='energie-a-v.png'; $valuea=''; } 
    if ( $e=='B' OR $e=='b') 		{  	$energieb='energie-b.png'; $valueb=$e; $energiea='energie-a-v.png';} else { 	$energieb='energie-b-v.png'; $valueb=''; } 
    if ( $e=='C' OR $e=='c') 		{ 	$energiec='energie-c.png'; $valuec=$e; $energiea='energie-a-v.png';} else { 	$energiec='energie-c-v.png'; $valuec=''; }
    if ( $e=='D' OR $e=='d') 		{  	$energied='energie-d.png'; $valued=$e; $energiea='energie-a-v.png';} else { 	$energied='energie-d-v.png'; $valued=''; }
    if ( $e=='E' OR $e=='e') 		{  	$energiee='energie-e.png'; $valuee=$e; $energiea='energie-a-v.png';} else { 	$energiee='energie-e-v.png'; $valuee=''; }
    if ( $e=='F' OR $e=='f') 		{  	$energief='energie-f.png'; $valuef=$e; $energiea='energie-a-v.png';} else { 	$energief='energie-f-v.png'; $valuef=''; }
    if ( $e=='G' OR $e=='g') 		{  	$energieg='energie-g.png'; $valueg=$e; $energiea='energie-a-v.png';} else { 	$energieg='energie-g-v.png'; $valueg=''; }
    
    
    
    } else {
    
                
    if ( $e <=50 ) 		       {  	$energiea='energie-a.png'; $valuea=$e; } else { 	$energiea='energie-a-v.png'; $valuea=''; } 
    if ( $e >=51 && $e <=90 ) 		{  	$energieb='energie-b.png'; $valueb=$e; $energiea='energie-a-v.png';} else { 	$energieb='energie-b-v.png'; $valueb=''; } 
    if ( $e >=91 && $e <=150 ) 		{ 	$energiec='energie-c.png'; $valuec=$e; $energiea='energie-a-v.png';} else { 	$energiec='energie-c-v.png'; $valuec=''; }
    if ( $e >=151 && $e <=230 ) 	{  	$energied='energie-d.png'; $valued=$e; $energiea='energie-a-v.png';} else { 	$energied='energie-d-v.png'; $valued=''; }
    if ( $e >=231 && $e <=330 ) 	{  	$energiee='energie-e.png'; $valuee=$e; $energiea='energie-a-v.png';} else { 	$energiee='energie-e-v.png'; $valuee=''; }
    if ( $e >=331 && $e <=450 ) 	{  	$energief='energie-f.png'; $valuef=$e; $energiea='energie-a-v.png';} else { 	$energief='energie-f-v.png'; $valuef=''; }
    if ( $e >=451 ) 			{  	$energieg='energie-g.png'; $valueg=$e; $energiea='energie-a-v.png';} else { 	$energieg='energie-g-v.png'; $valueg=''; }
    
    }
        echo "<table border='0' cellspacing='0' cellpadding='0' height='5'>";	
        echo "<tr><td align=left width='$width' height='5'><font face=arial color=#000000 size='-1'><b>B&acirc;timent &eacute;conome</b></font></td></tr>";	
        echo "</table>";
        
        if(!isset($nopdf)){
        echo "<table border='1' cellspacing='0' cellpadding='0'>";	
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energiea' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuea&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energieb' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueb&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energiec' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuec&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energied' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valued&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energiee' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuee&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energief' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuef&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='energie/$energieg' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueg&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
        echo "</table>";
        }
        else if($nopdf && $nopdf == 1){
            echo "<table border='1' cellspacing='0' cellpadding='0'>";	
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energiea' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuea&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energieb' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueb&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energiec' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuec&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energied' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valued&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energiee' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuee&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energief' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valuef&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
            echo "<tr><td align=left width='$width' height='$height'><div style='position: absolute;'><img src='/energie/$energieg' width='$width' height='$height'><table style='position: absolute; top: -2; left: 0;' border=0 width='$width' height='$height'><tr><td align=right width='$width' height='$height'><font face=arial color=#FFFFFF><b>$valueg&nbsp;&nbsp;</b></font></td></tr></table></div></td></tr>";
        echo "</table>";
        }
        
        echo "<br>";
    
        echo "<table border='0' cellspacing='0' cellpadding='0'>";	
        echo "<tr><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-1'><b>B&acirc;timent &eacute;nergivore</b></font></td></tr>";	
        echo "</table>";
        
        echo "<table border='0' cellspacing='0' cellpadding='0'>";	
        echo "<tr valign=top><td align=left width='$width' bgcolor=#FFFFFF><font face=arial color=#000000 size='-2'> en <b>kWh</b>an<b>/m&sup2;.an</b></font></td></tr>";	
        echo "</table>";
        
    }
    
    @endphp		
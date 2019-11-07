<table style="width: 50%">
    <tbody>
        <tr>           
               
            <td style="width: 216px;">Date de la facture</td>
            <td style="width: 194px;">{{ $avoir->date->format('d/m/Y') }}</td> 
            <td style="width: 344px;"><span style="text-decoration: underline;"><strong>FACTURE N&deg;  {{$avoir->numero}} </td>
          
        </tr>
    </tbody>
</table>
<table style="height: 91px; width: 20%">
    <tbody>
       
    </tbody>
</table>


<br>
<br>
<br>

<table style="height: 63px; width: 50%;">
    <tbody>
        <tr >
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px; "><span style="text-decoration: underline;"><strong>Description:</strong></span></td>
            <td style="width: 391px;"></td>

        </tr>
        <tr style="">
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px; ">{{substr($avoir->motif,0,200)}}</td>
            <td style="width: 391px;"></td>

        </tr>
    </tbody>
</table>
<br>
<table style="height: 47px; width: 672px;">
    <tbody>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">TOTAL H.T :</td>
            <td style="width: 231px;">- {{round($avoir->montant - $avoir->montant*0.2,2)}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">T.V.A 20% :</td>
            <td style="width: 231px;">- {{round($avoir->montant * 0.2,2)}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;"> <hr style="height: 5px; background-color: #839D2D">TOTAL T.T.C:</td>
            <td style="width: 231px;"> <hr style="height: 5px; background-color: #839D2D">- {{round($avoir->montant,2)}} &euro;</td>
        </tr>
    </tbody>
</table>
<br>
<br>
<br>
<br>


<hr>
<div style="text-align: center; font-size: 11px; margin-right: 10%; margin-left: 10%; margin-top: 20px;">
    <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
    </p>
</div>
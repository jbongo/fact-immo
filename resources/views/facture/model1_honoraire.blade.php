@extends('layouts.app')

@section('content')
    @section ('page_title')
Création Facture honoraire
    @endsection
    <div class="row"> 
       
                <div class="col-lg-12">
                        @if (session('ok'))
               
                        <div class="alert alert-success alert-dismissible fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                        </div>
                     @endif       
                    <div class="card alert">
                   <div class="row">
                     
                      <div class="col-lg-2 ml-auto">
                         <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromis->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                      </div>
                      
                    
          
                   </div>
                         <hr>
          

<table style="height: 122px; width: 700px; margin-left: auto; margin-right: auto;">
                <tbody>
                <tr>
                <td style="width: 433px;">
                <p><span style="color: #3366ff;"><strong>GALVES NICOLAS</strong></span></p>
                <p><span style="color: #3366ff;"><strong>Conseiller en Immobilier</strong></span><br /><span style="color: #3366ff;"><strong>06 60 90 25 69</strong></span></p>
                <p>&nbsp;</p>
                </td>
                <td style="width: 251px;"><strong>Sarl V4F</strong><br /><strong>115 Avenue de la roquette</strong><br /><strong>30 200 &ndash; Bagnols sur ceze</strong></td>
                </tr>
                </tbody>
                </table>
                <p>&nbsp;</p>
                <table style="height: 103px; width: 696px; margin-left: auto; margin-right: auto;">
                <tbody>
                <tr>
                <td style="width: 397px;"><strong>Facture n&deg; : 201904</strong><br />DATE: 11 sept. 19</td>
                <td style="width: 283px;">&nbsp;</td>
                </tr>
                </tbody>
                </table>
                <table style="height: 89px; margin-left: auto; margin-right: auto;" width="695">
                <tbody>
                <tr>
                <td style="width: 685px;">N&deg; de mandat : 15 756 &ndash; Facture Stylimmo N&deg; 15 756 du 04/09/2019</td>
                </tr>
                <tr>
                <td style="width: 685px;">Vendeur : Borla / Acqu&eacute;reur : Messineo / Notaire Sollier</td>
                </tr>
                </tbody>
                </table>
                <table style="height: 106px; border-color: black; margin-left: auto; margin-right: auto;" border="2" width="693">
                <tbody>
                <tr>
                <td style="width: 131px;"><strong>NOM VENDEUR</strong></td>
                <td style="width: 132px;"><strong>COMMISSION</strong><br /><strong>TOTALE</strong></td>
                <td style="width: 132px;"><strong>TAUX DE</strong><br /><strong>COMMISSIONNEMENT</strong></td>
                </tr>
                <tr>
                <td style="width: 131px;">BORLA</td>
                <td style="width: 132px;">6 000 TTC</td>
                <td style="width: 132px;">90%</td>
                </tr>
                </tbody>
                </table>
                <p>&nbsp;</p>
                <table style="height: 130px; border-color: black; margin-left: auto; margin-right: auto;" border="1" width="691" cellspacing="0" cellpadding="0">
                <tbody>
                <tr style="height: 18px;">
                <td style="width: 169px; height: 18px;"><strong>QUANTITES</strong></td>
                <td style="width: 170px; height: 18px;"><strong>DESIGNATION</strong></td>
                <td style="width: 171px; height: 18px;"><strong>P.U.H.T.</strong></td>
                <td style="width: 171px; height: 18px;"><strong>MONTANT H.T.</strong></td>
                </tr>
                <tr style="height: 238px;">
                <td style="width: 169px; text-align: right; height: 238px;">1</td>
                <td style="width: 170px; text-align: right; height: 238px;">6000 TTC *90%=5400 TTC</td>
                <td style="width: 171px; text-align: right; height: 238px;">4 500,00</td>
                <td style="width: 171px; text-align: right; height: 238px;">
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>4 500,00</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                </td>
                </tr>
                <tr style="height: 16px;">
                <td style="width: 169px; height: 16px;">&nbsp;</td>
                <td style="width: 170px; height: 16px;">&nbsp;</td>
                <td style="width: 171px; height: 16px;">TOTAL H.T.&nbsp;<br /><br /></td>
                <td style="width: 171px; height: 16px;">
                <p>4 500,000</p>
                </td>
                </tr>
                <tr style="height: 18px;">
                <td style="width: 169px; height: 18px;">&nbsp;</td>
                <td style="width: 170px; height: 18px;">&nbsp;</td>
                <td style="width: 171px; height: 18px;">T.V.A. 20 %</td>
                <td style="width: 171px; height: 18px;">900,000</td>
                </tr>
                <tr style="height: 18px;">
                <td style="width: 169px; height: 18px;">&nbsp;</td>
                <td style="width: 170px; height: 18px;">&nbsp;</td>
                <td style="width: 171px; height: 18px;">&nbsp;</td>
                <td style="width: 171px; height: 18px;">&nbsp;</td>
                </tr>
                <tr style="height: 18px; border-color: black;">
                <td style="width: 169px; height: 18px;">&nbsp;</td>
                <td style="width: 170px; height: 18px;">&nbsp;</td>
                <td style="width: 171px; height: 18px;">TOTAL T.T.C.</td>
                <td style="width: 171px; height: 18px;">4 852,80</td>
                </tr>
                </tbody>
                </table>
                <p>&nbsp;</p>
                <p style="text-align: center;">Factures : Aout/Septembre 2019</p>
                <p>&nbsp;</p>
                <p style="text-align: center;"><strong>Valeur en votre aimable r&egrave;glement</strong></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p style="text-align: center;"><strong>1 parc de chatenay - 38540 &ndash; Heyrieux N&deg;siret : 324 830 447 00037 / code APE 6831 ZTVA</strong><br /><strong>INTRACOMMUNAUTAIRE : FR 593 248 304 47</strong></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
@endsection
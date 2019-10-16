@extends('layouts.app')

@section('content')
   @section ('page_title')
      Facture Pack pub
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


        <table style="height: 26px; width: 760px;">
            <tbody>
            <tr>
            <td style="width: 370px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="249" height="140" /></td>
            <td style="width: 378px;">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <table style="height: 132px;" width="756">
            <tbody>
            <tr style="height: 100px;">
            <td style="width: 370px; height: 100px;">Bagnols sur C&egrave;ze le,&nbsp;31 mars 2017</td>
            <td style="width: 370px; height: 100px;">
            <p><strong>Mme LAUCAGNE Valentine</strong></p>
            <p><strong>99 Avenue du Mistral</strong><br /><strong>30200 SAINT ETIENNE DES SORTS</strong></p>
            </td>
            </tr>
            </tbody>
            </table>
            <table style="height: 72px;" width="756">
            <tbody>
            <tr>
            <td style="width: 370px;"><strong>FACTURE N&deg; F14 908</strong></td>
            <td style="width: 370px;">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <table style="height: 57px;" width="755">
            <tbody>
            <tr>
            <td style="width: 745px; text-align: center;">Je vous prie de bien vouloir trouver ci-joint la facture concernant vos logiciels, passerelles &amp; outils.</td>
            </tr>
            </tbody>
            </table>
            <table style="height: 48px;" width="755">
            <tbody>
            <tr>
            <td style="width: 745px; text-align: center;">P&eacute;riode d'utilisation du mois de :&nbsp;mars</td>
            </tr>
            </tbody>
            </table>
            <table >
            <tbody>
            <tr>
            <td >Logiciel</td>
            </tr>
            </tbody>
            </table>
            <table style="height: 49px;" width="754">
            <tbody>
            <tr style="height: 134px;">
            <td style="width: 744px; height: 134px;"><img style="display: block; margin-left: auto; margin-right: auto;" src="{{asset('images/logiciel.png')}}"  width="446" height="100"  /></td>
            </tr>
            </tbody>
            </table>
            <table>
            <tbody>
            <tr>
            <td>Passerelle dans votre PAC 20</td>
            </tr>
            </tbody>
            </table>
            <table width="754">
            <tbody>
            <tr>
            <td><img style="display: block; margin-left: auto; margin-right: auto;" src="{{asset('images/passerelle_abon.png')}}"  width="446" height="200" /></td>
            </tr>
            </tbody>
            </table>
            <table>
            <tbody>
            <tr>
            <td>Passerelles illimit&eacute;es dans votre Pac</td>
            </tr>
            </tbody>
            </table>
            <table width="754">
            <tbody>
            <tr>
            <td><img style="display: block; margin-left: auto; margin-right: auto;" src="{{asset('images/passerelle_grat.png')}}" alt="https://www.stylimmo.com/images/logo.jpg" width="446" height="120" /></td>
            </tr>
            </tbody>
            </table>
            <table style="height: 46px;" width="754">
            <tbody>
            <tr>
            <td style="width: 243px;">T H.T. : 236,90 &euro;</td>
            <td style="width: 243px;">T.V.A. 20 % : 4 7,38 &euro;</td>
            <td style="width: 246px;">TOTAL T.T.C. : 284,28 &euro;</td>
            </tr>
            </tbody>
            </table>
            <table style="height: 49px;" width="753">
            <tbody>
            <tr>
            <td style="width: 743px; text-align: center;">Conditions de paiement : &agrave; r&eacute;ception de la facture par virement en pr&eacute;cisant le N&deg; de la pr&eacute;sente facture.</td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>
            <table class="table table-striped table-bordered table-hover" style="width: 99.0753%;" border="1">
            <thead>
            <tr style="height: 18px;">
            <th style="height: 18px; width: 100%;" align="center">DOMICILIATION BANCAIRE: Credit Mutuel</th>
            </tr>
            </thead>
            <tbody>
            <tr style="height: 18px;">
            <th style="height: 18px; width: 100%;" align="center">RIB: 10278 7941 00020227203 08</th>
            </tr>
            <tr style="height: 18px;">
            <th style="width: 100%;" align="center">IBAN: FR76102 78079 41000 2022 720308</th>
            </tr>
            <tr style="height: 8px;">
            <th style="height: 8px; width: 100%;" align="center">BIC: CMCIFR2A</th>
            </tr>
            </tbody>
            </table>
            <hr />
            <div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
            <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE Carte professionnelle N&deg;1312T14 SIRET: 800 738 478 00018 - RCS NIMES 800 738 478</p>
            </div>

          </div>
      </div>
</div>
@endsection
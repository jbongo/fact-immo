@extends('layouts.app')

@section('content')
    @section ('page_title')

Facture d'avoir pour la facture N° {{$facture->numero}}

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
                    <div class="col-lg-3 col-md-3 col-sm-5">
                        <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($avoir->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                    </div>
                </div>
                <hr>

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
            <td style="width: 428px; ">{{$avoir->motif}}</td>
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
<table class="table table-striped table-bordered table-hover" style="width: 50%;" border="1">
    <thead>
        <tr style="height: 18px;">
            <th align="center" style="height: 18px;">DOMICILIATION BANCAIRE: Crédit Mutuel</th>
        </tr>
    </thead>
    <tbody>
        <tr style="height: 18px;">
            <th align="center" style="height: 18px;">RIB: 10278 7941 00020227203 08</th>
        </tr>
        <tr style="height: 18px;">
            <th align="center">IBAN: FR76102 78079 41000 2022 720308</th>
        </tr>
        <tr style="height: 8px;">
            <th align="center" style="height: 8px;">BIC: CMCIFR2A</th>
        </tr>
    </tbody>
</table>

<hr>
<div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
    <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
    </p>
</div>



          </div>
      </div>
</div>
@endsection
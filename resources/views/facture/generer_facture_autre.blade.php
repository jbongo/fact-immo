@extends('layouts.app')

@section('content')
    @section ('page_title')
Facture N° {{$facture->numero}}

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
         
            @if($facture->url != null)
            <div class="col-lg-3 col-md-3 col-sm-6">
               <a href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
            </div>
            @else 

            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="{{route('facture.edit_libre', Crypt::encrypt($facture->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-pencil"></i>Modifier</a>
             </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="{{route('facture.generer_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-reload"></i>Génerer la facture</a>
             </div>


            @endif
            

           
            

         </div>
               <hr>

<table style="width: 50%">
    <tbody>
        <tr>           
            <td style="width: 382px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="219" height="114" /></td>
            <td style="width: 380px;">
                {{-- {{ dd($facture)}} --}}

                @if($facture->destinataire_est_mandataire == true)
                    <p>  {{$facture->user->nom}} {{$facture->user->prenom}}</p>
                    <p>{{$facture->user->adresse}}</p> 
                    <p>{{$facture->user->code_postal}}, {{$facture->user->ville}}</p>

                @else

                    <p> {!! $facture->destinataire !!}  </p>
                @endif
               
            </td>
        </tr>
    </tbody>
</table>
<br>

<table style="height: 53px;" width="50%">
    <tbody>
        <tr>
            <td style="width: 343px;"><span style="color: #ff0000;"></span></td>
            <td style="width: 344px;"><span style="text-decoration: underline; font-size:20px"><strong>FACTURE N&deg;   {{$facture->numero}}</strong></span></td>
        </tr>
    </tbody>
</table>
<table style="height: 59px; width: 311px;">
    <tbody>
        <tr>
            <td style="width: 158px;"><span style="text-decoration: underline;"><strong> TRANSACTION</strong></span></td>
        <td style="width: 143px;"><span style="text-decoration: underline;"><strong> {{strtoupper($facture->type)}}</strong></span></td>
        </tr>
    </tbody>
</table>

<br>
<table style="height: 115px; width: 100%">
    <tbody>
        <tr>
            <td style="width: 150px;">&nbsp;</td>
            <td style="width: 528px;"><span style="text-decoration: underline;">{!! $facture->description_produit !!} </td>
            <td style="width: 30px;">&nbsp;</td>
        </tr>
        
    </tbody>
</table>

<br>

<br>
<br>
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 349px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
            <td style="width: 117px; height: 25px;">{{number_format($facture->montant_ht,2,',',' ')}} &euro; HT</td>
            <td style="width: 177px; height: 25px;"> </td>
        </tr>
    </tbody>

</table>
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
<div style="text-align: center; font-size: 11px; margin-right: 20%; margin-left: 20%; margin-top: 20px;">
    <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE <br> Capital social: 3000 € - Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
    </p>
</div>



          </div>
      </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    @section ('page_title')

Avoir N° {{$avoir->numero}}


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
            <div class="col-lg-3 col-md-3 col-sm-6">
                <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($avoir->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
             </div>
            {{-- @if ($compromis->facture_stylimmo_valide == true)
           
            <div class="col-lg-3 col-md-3 col-sm-6">
               <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($avoir->id))}}"  class="btn btn-default btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
            </div>
            @else 
                @if(Auth()->user()->role == "admin")
                <div class="col-lg-4 col-md-4  col-sm-5 ml-auto">
                    <form action="{{route('facture.valider_facture_stylimmo', Crypt::encrypt($compromis->id))}}" method="get">
                            <div class="row">
                                <div class="  col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <label for="numero">Numéro facture :</label>
                                </div>
                                <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <label for="numero">Date facture :</label>
                                </div>
                            </div>
                        
                        <div class="row">
                            <div class="form-group  col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <div class="">  <input class="form-control " style="height:35px; border-color:royalblue" type="number" name="numero" id="numero" value="{{ old('numero') ? old('numero') : 55555}}" required> </div>
                                @if ($errors->has('numero'))
                                <br>
                                <div class="alert alert-warning ">
                                <strong>{{$errors->first('numero')}}</strong> 
                                </div>
                                @endif     
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="">  <input class="form-control " style="height:35px; border-color:royalblue" type="date"  name="date_facture" id="date_facture"  required> </div>
                                @if ($errors->has('date_facture'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{$errors->first('date_facture')}}</strong> 
                                </div>
                                @endif     
                            </div>
                        </div>
                        <div class="form-group  ">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <button  class="btn btn-default btn-flat btn-addon "  id="ajouter"><i class="ti-check"></i>Valider la facture</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                @endif
            @endif --}}

         </div>
               <hr>

<table style="width: 50%">
    <tbody>
        <tr>           
            <td style="width: 382px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt="" width="219" height="114" /></td>
            <td style="width: 380px;">
                @if ($compromis->charge == "Vendeur")
                   
                        <p>{{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </p>
                   
                        <p>{{$compromis->adresse1_vendeur}}</p>
                        <p>{{$compromis->adresse2_vendeur}}</p> 
                        <p>{{$compromis->code_postal_vendeur}}, {{$compromis->ville_vendeur}}</p>
                @else 

                   
                    <p>{{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} </p>                
                   
                        <p>{{$compromis->adresse1_acquereur}} </p>
                        <p>{{$compromis->adresse2_acquereur}} </p>
                        <p>{{$compromis->code_postal_acquereur}} {{$compromis->ville_acquereur}}</p>
                @endif
               
            </td>
        </tr>
    </tbody>
</table>
<br>
{{-- <table style="height: 91px; width: 20%">
    <tbody>
        <tr>
            <td style="width: 216px;">Bagnols sur C&egrave;ze, le</td>
            <td style="width: 194px;">{{Carbon\Carbon::now()->format('d/m/Y')}}</td> 
        </tr>
    </tbody>
</table> --}}
<table style="height: 53px;" width="50%">
    <tbody>
        <tr>
            <td style="width: 343px;"><span style="color: #ff0000;"></td>
            <td style="width: 344px;"><span style="text-decoration: underline; font-size:20px"><strong>AVOIR N&deg; {{$avoir->numero}}</td>
        </tr>
        <tr>
            <td style="width: 343px;"><span style="color: #ff0000;"></td>
            <td style="width: 344px;"><span style="color: #ff0000;"><strong>Avoir sur la facture N° {{$facture->numero}} du {{$facture->date_facture->format('d/m/Y')}}</td>
        </tr>
    </tbody>
</table>
<table style="height: 59px; width: 311px;">
    <tbody>
        <tr>
            <td style="width: 158px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
        <td style="width: 143px;"><span style="text-decoration: underline;"><strong> {{strtoupper($compromis->type_affaire)}}</strong></span></td>
        </tr>
    </tbody>
</table>
@if($compromis->type_affaire == "Vente")
<table style="height: 26px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;">En l'&eacute;tude de Scp&nbsp; {{$compromis->scp_notaire}}</td>
            <td style="width: 260px;">  Pr&eacute;vue pour le : {{ Carbon\Carbon::parse($compromis->date_vente)->format('d/m/Y')}} </td>
        </tr>
    </tbody>
</table>
@endif
@if($compromis->type_affaire == "Location")
<table style="height: 26px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;">&nbsp; </td>
            <td style="width: 260px;"> date entrée : {{ Carbon\Carbon::parse($compromis->user->date_entree)->format('d/m/Y')}}   </td>
        </tr>
    </tbody>
</table>
@endif
<table style="height: 37px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>R&eacute;f.</strong></span><strong>:&nbsp;</strong>&nbsp; Mandat N&deg;&nbsp; {{$compromis->numero_mandat}}&nbsp; du : {{ Carbon\Carbon::parse($compromis->date_mandat)->format('d/m/Y')}}</td>
            <td style="width: 260px;">Affaire suivie par : {{$mandataire->nom}} {{$mandataire->prenom}}</td>
        </tr>
    </tbody>
</table>
<br>
<table style="height: 66px; width: 50%">
    <tbody>
        <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px;"><span style="text-decoration: underline;">@if($compromis->type_affaire == "Vente") Vendeur(s) @else Propriétaire(s)@endif: </span>&nbsp; {{$compromis->civilite_vendeur}} {{$compromis->nom_vendeur}} </td>
            <td style="width: 191px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 228px;"><span style="text-decoration: underline;">@if($compromis->type_affaire == "Vente") Acquéreur(s) @else Locataire(s)@endif:</span>&nbsp; {{$compromis->civilite_acquereur}} {{$compromis->nom_acquereur}} {{$compromis->prenom_acquereur}} </td>
            <td style="width: 191px;">&nbsp;</td>
        </tr>
    </tbody>
</table>

<table style="height: 63px; ">
    <tbody>
        <tr >
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 700px; "><span style="text-decoration: underline;"><strong>Description et adresse du bien :</strong></span></td>
            <td style="width: 391px;"></td>

        </tr>
        <tr style="">
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 700px; ">{{ substr($compromis->description_bien, 0,150) }}</td>
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
            <td style="width: 231px;">{{number_format($facture->montant_ttc/1.2 ,2,',',' ')}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">T.V.A 20% :</td>
            <td style="width: 231px;">{{number_format(($facture->montant_ttc/1.2) *0.2,2,',',' ')}} &euro;</td>
        </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">TOTAL T.T.C :</td>
            <td style="width: 231px;">{{number_format($facture->montant_ttc,2,',',' ')}} &euro;</td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 300px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
            <td style="width: 117px; height: 25px;">{{number_format($facture->montant_ttc,2,',',' ')}}  &euro; TTC</td>
            <td style="width: 177px; height: 25px;"></td>
        </tr>
    </tbody>

</table>
<br>
@if($compromis->type_affaire == "Vente")
<table style="height: 40px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 196px;">
                <div>
                    <div><span style="text-decoration: underline;"><strong>Conditions de paiement:</strong></span></div>
                </div>
            </td>
            <td style="width: 488px;">
                <div>
                    <div>Au plus tard le jour de la signature de l'acte authentique, par virement &agrave; la SARL&nbsp;V4F, en rappelant au moins sur l'objet du virement les r&eacute;f&eacute;rences de la facture.</div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
@endif
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
    <p><strong>SARL V4F</strong> - 115 Avenue de la Roquette - Zone Artisanale de Berret - 30200 BAGNOLS SUR CEZE Carte professionnelle N°1312T14 TVA in FR 67 800738478 - SIRET: 800 738 478 00018 - RCS NIMES 800 738 478
    </p>
</div>



          </div>
      </div>
</div>
@endsection
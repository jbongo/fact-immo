@extends('layouts.app')

@section('content')
   @section ('page_title')
      Note honoraire <span class="color-danger">(commission agence / partage)</span> | {{$mandataire->nom}} {{$mandataire->prenom}}
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
            @if ($mandataire->statut == "auto-entrepreneur" && $compromis->facture_honoraire_partage_cree == false)
           <br><br>
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <span > <strong> Jetons restant : </strong></span>&nbsp;&nbsp;  <span class="color-warning"> <strong> {{$mandataire->nb_mois_pub_restant}}</strong></span> <br>
                     <span > <strong> Année concernée : </strong></span> &nbsp;&nbsp; <span class="color-warning"> <strong> {{date('Y')}}</strong></span> <br>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6"></div>
               </div> <br>

               <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-8">
                        <form class="form-valide form-horizontal" action="{{ route('facture.deduire_pub_facture_honoraire',Crypt::encrypt($compromis->id) ) }}" method="post">
                              {{ csrf_field() }}
                            <div class="row">

                                <hr>
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-md-6 col-sm-6 control-label" for="nb_mois_deduire">Nombre de jetons à utiliser<span class="text-danger">*</span> </label>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                        <input type="number" max="{{$mandataire->nb_mois_pub_restant}}" min="0" class="form-control {{ $errors->has('nb_mois_deduire') ? ' is-invalid' : '' }}" value="{{old('nb_mois_deduire')}}" id="nb_mois_deduire" name="nb_mois_deduire" required >
                                           @if ($errors->has('nb_mois_deduire'))
                                           <br>
                                           <div class="alert alert-warning ">
                                              <strong>{{$errors->first('nb_mois_deduire')}}</strong> 
                                           </div>
                                           @endif   
                                        </div>
                                     </div>
                                </div>
       
                              </div>
                           
                              <div class="form-group row" style="text-align: center; ">
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <button class="btn btn-success btn-flat btn-addon btn-md m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
                                 </div>
                              </div>
                           </form>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4"></div>
               </div>

            @endif

         </div>
               <hr>


<table style="height: 59px; width: 311px;">
    <tbody>
        <tr>
            <td style="width: 158px;"><span style="text-decoration: underline;"><strong>TRANSACTION</strong></span></td>
            <td style="width: 143px;"><span style="text-decoration: underline;"><strong>VENTE</strong></span></td>
        </tr>
    </tbody>
</table>
<table style="height: 26px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;">En l'&eacute;tude de Scp&nbsp; {{$compromis->scp_notaire}}</td>
            <td style="width: 260px;">Pr&eacute;vue pour le : {{ Carbon\Carbon::parse($compromis->date_vente)->format('d/m/Y')}}</td>
        </tr>
    </tbody>
</table>
<table style="height: 37px; width: 50%;">
    <tbody>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>R&eacute;f.</strong></span><strong>:&nbsp;</strong>&nbsp; Mandat N&deg;&nbsp; {{$compromis->numero_mandat}}&nbsp; du : {{ Carbon\Carbon::parse($compromis->date_mandat)->format('d/m/Y')}}</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Mandataire avec qui je partage:</strong> </span> &nbsp; {{$mandataire_partage->nom}} {{$mandataire_partage->prenom}}&nbsp;</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Frais d'agence:</strong> </span> &nbsp; {{ number_format($compromis->frais_agence, 2, '.', ' ') }} € &nbsp;</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Mon pourcentage de partage:</strong> </span> &nbsp; {{$pourcentage_partage}} %&nbsp; soit ({{ number_format($compromis->frais_agence * $pourcentage_partage /100, 2, '.', ' ')  }} €) </td>
            <td style="width: 260px;height:35px"></td>
        </tr>
    </tbody>
</table>
<br>
<table style="height: 66px; width: 50%">
    <tbody>
         <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px;"><span style="text-decoration: underline;"><strong>Commission:</strong></span>&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:mediumblue"> {{$mandataire->commission}} %</td>
            <td style="width: 391px; height:35px"></td>
         </tr>
        <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px;"><span style="text-decoration: underline;"><strong>Vendeur:</strong></span> &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:mediumblue">
                {{$compromis->civilite_vendeur}}
                @if ($compromis->civilite_vendeur == "M." || $compromis->civilite_vendeur == "Mme")
                    {{$compromis->nom_vendeur}} {{$compromis->prenom_vendeur}}
                @else 
                   {{$compromis->raison_sociale_vendeur}}                      
                @endif
                
            </td>
            <td style="width: 391px; height:35px"></td>
        </tr>
        <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 228px;"><span style="text-decoration: underline;"><strong>Acquereur:</strong></span> &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:mediumblue"> 
                {{$compromis->civilite_acquereur}}
                @if ($compromis->civilite_acquereur == "M." || $compromis->civilite_acquereur == "Mme")
                    {{$compromis->nom_acquereur}} {{$compromis->prenom_acquereur}}                  
                @else 
                    {{$compromis->raison_sociale_acquereur}}                            
                @endif
                
            </td>
            <td style="width: 391px; height:35px"></td>
        </tr>
        <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 228px;"><span style="text-decoration: underline;"><strong>Description du bien:</strong></span> &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:mediumblue"> 
                <p> {{$compromis->description_bien}} /   <span class="color-warning"> {{$compromis->ville_bien}} </span> </p>
            </td>
            <td style="width: 391px; height:35px"></td>
        </tr>
    </tbody>
</table>

<br>

@if($facture != null )
<table style="height: 47px; width: 672px;">
    <tbody>
        @foreach ($formule[0] as $key=>$formu)
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px; color:rebeccapurple">{{$key+1}} &nbsp; :</td>
            <td style="width: 231px;">{{ number_format($formu[0], 2, '.', ' ') }} &euro; * {{$formu[1]/100}}</td>
        </tr>
        @endforeach
        
        <tr>
            <td style="width: 400px;">&nbsp; </td>
            <td style="width: 153px;"><hr style="border-top: 1px solid red;">TOTAL H.T :</td>
            <td style="width: 231px;"><hr style="border-top: 1px solid red;">{{ number_format($facture->montant_ht, 2, '.', ' ') }} &euro;</td>
        </tr>
        <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">T.V.A 20% :</td>
            <td style="width: 231px;">{{ number_format($facture->montant_ttc - $facture->montant_ht, 2, '.', ' ') }} &euro;</td>
        </tr>
        <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>

        @php
         $montant_pub_deduis =  0;   
        @endphp

        @if ($facture->nb_mois_deduis > 0)
       @php $montant_pub_deduis = $facture->nb_mois_deduis * $mandataire->contrat->packpub->tarif @endphp
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">Jetons déduis :</td>
            <td style="width: 231px;">- {{ number_format($montant_pub_deduis, 2, '.', ' ') }} &euro;</td>
        </tr>
        @endif
       
        <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">TOTAL T.T.C:</td>
            <td style="width: 231px;">{{ number_format($facture->montant_ttc - $montant_pub_deduis, 2, '.', ' ') }} &euro;</td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 349px; height: 25px;">Valeur en votre aimable r&egrave;glement de :</td>
            <td style="width: 117px; height: 25px;">{{  number_format($facture->montant_ttc - $montant_pub_deduis, 2, '.', ' ')  }} &euro; TTC</td>
            <td style="width: 177px; height: 25px;"></td>
        </tr>
    </tbody>

</table>
@endif

<br>



<hr>
<div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
    <p><strong>{{$mandataire->nom}} {{$mandataire->prenom}}</strong> &nbsp; - &nbsp;<strong> SIRET : {{$mandataire->siret}} </strong> &nbsp; &nbsp; <strong>{{$mandataire->adresse}} {{$mandataire->code_postal}} {{$mandataire->ville}}</strong>
    </p>
</div>



          </div>
      </div>
</div>
@endsection
@section('js-content')
    <script>
    // $('.price')    nb = 1580000;
    // alert(nb.toLocaleString());

    </script>
@endsection
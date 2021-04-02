@extends('layouts.app')

@section('content')
   @section ('page_title')
      Note honoraire <span class="color-danger">(commission parrainage)</span>
<span >| {{$parrain->nom}} {{$parrain->prenom}}</span>
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
            {{-- @if ($filleul->statut == "auto-entrepreneur" && $compromis->facture_honoraire_cree == false)
           <br><br>
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                     <span > <strong> Jetons restant : </strong></span>&nbsp;&nbsp;  <span class="color-warning"> <strong> {{$filleul->nb_mois_pub_restant}}</strong></span> <br>
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
                                        <input type="number" max="{{$filleul->nb_mois_pub_restant}}" min="0" class="form-control {{ $errors->has('nb_mois_deduire') ? ' is-invalid' : '' }}" value="{{old('nb_mois_deduire')}}" id="nb_mois_deduire" name="nb_mois_deduire" required >
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

            @endif --}}

         </div>
               <hr>
               <div class="row">
                <div class="col-md-4"> 
                    @if(Auth()->user()->role == "admin" && $facture != null )
                        <a href="{{route('facture.recalculer_honoraire',Crypt::encrypt($facture->id))}}" class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-reload"></i>Recalculer</a>
                    @endif
                </div>
                <div class="col-md-4">
                    @if($facture != null)
                     @if($facture->statut == "valide" && $facture->url != null)
                         <a class="color-info" title="Télécharger la facture d'honoraire "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger Fac: {{$facture->numero}} <i class="ti-download"></i> </a>
                     @elseif($facture->statut == "en attente de validation")
                         <label class="color-danger" ><strong> Facture en attente de validation </strong> &nbsp;  </label> 
                         @if(Auth()->user()->role == "admin")
                            <a href="{{route('facture.valider_honoraire', [1,Crypt::encrypt($facture->id)] )}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider" id="valider"><i class="ti-check"></i>Valider</a>
                            <a href="{{route('facture.valider_honoraire', [0,Crypt::encrypt($facture->id)] )}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 refuser" id="refuser"><i class="ti-close"></i>Réfuser</a>
                        @endif
                    @elseif($facture->statut == "refuse")
                         <label class="color-danger" ><strong> Facture réfusée </strong> </label>
                     @else
                     <label class="color-danger" ><strong> Facture non Ajoutée </strong> </label>
                     @endif 
                @endif 
                </div>
            </div>
                
    

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
        @if($compromis->getFactureStylimmo())
        <tr>           
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Facture stylimmo N&deg;:</strong> </span> &nbsp; {{$compromis->getFactureStylimmo()->numero}}&nbsp;</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        @endif
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Filleul:</strong></span> &nbsp;  <span class="color-warning"> {{$filleul->nom}} {{$filleul->prenom}}&nbsp; </span></td>
            <td style="width: 260px; height:35px"></td>
        </tr>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Commission agence:</strong></span> &nbsp;  <span class="color-warning">
                @if($compromis->est_partage_agent == false)
                 {{number_format($compromis->frais_agence(),'2','.',' ')}} €&nbsp; 
                 @else
                    @if($compromis->user_id == $filleul->id)
                        {{number_format($compromis->frais_agence() * $compromis->pourcentage_agent/100,'2','.',' ')}} €&nbsp; (soit {{$compromis->pourcentage_agent}} % de {{$compromis->frais_agence()}} €)
                    @else
                        {{number_format($compromis->frais_agence() * (100 - $compromis->pourcentage_agent) /100,'2','.',' ')}} €&nbsp; (soit {{$compromis->pourcentage_agent}} % de {{$compromis->frais_agence()}} €)
                    @endif

                 @endif
                </span></td>
            <td style="width: 260px; height:35px"></td>
        </tr>
    </tbody>
</table>
<br>
<table style="height: 66px; width: 50%">
    <tbody>
         <tr>
            <td style="width: 48px;">&nbsp;</td>
            <td style="width: 428px;"><span style="text-decoration: underline;"><strong>Commission de parrainage:</strong></span>&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:mediumblue"> {{$pourcentage_parrain}} %</td>
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
{{-- {{dd($result)}} --}}

<br>
{{-- {{dd($facture)}} --}}
@if($facture != null && $result['respect_condition'] == true )
<table style="height: 47px; width: 672px;">
    <tbody>
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">TOTAL H.T :</td>
                <td style="width: 231px;">{{number_format($facture->montant_ht,'2','.',' ')}} &euro;</td>
            </tr>
            <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
        @if($facture->montant_ttc > $facture->montant_ht )
        
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">T.V.A 20% :</td>
                <td style="width: 231px;">{{number_format($facture->montant_ttc- $facture->montant_ht,'2','.',' ') }} &euro;</td>
            </tr>
            <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
            <tr>
                <td style="width: 400px;">&nbsp;</td>
                <td style="width: 153px;">TOTAL T.T.C:</td>
                <td style="width: 231px;">{{number_format($facture->montant_ttc,'2','.',' ')}} &euro;</td>
            </tr>

        @else   
            @if($facture->user->contrat->est_soumis_tva == false )
                <tr>
                    <td style="width: 400px;">&nbsp;</td>
                    <td style="width: 353px; color:brown">Vous n'êtes pas soumis à la TVA </td>
                    <td style="width: 31px;"></td>
                </tr>
                <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
            @else 
                <tr>
                    <td style="width: 400px;">&nbsp;</td>
                <td style="width: 353px; color:brown"> Vous n'etiez pas soumis à la TVA au moment du calcul ({{$facture->created_at->format('d/m/Y')}}) </td>
                    <td style="width: 31px;"></td>
                </tr>
                <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
            @endif
        @endif
    </tbody>
</table>
<br>
<br>
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 349px; height: 25px;">Vous recevrez un montant net de :</td>
                @if($facture->montant_ttc > $facture->montant_ht )
                    <td style="width: 117px; height: 25px;">{{  number_format($facture->montant_ttc, 2, '.', ' ')  }} &euro; </td>
                @else 
                    <td style="width: 117px; height: 25px;">{{  number_format($facture->montant_ht, 2, '.', ' ')  }} &euro; </td>
                @endif

            <td style="width: 177px; height: 25px;"></td>
        </tr>
    </tbody>
</table>
@endif 
<br>
<span  style="background-color:rgb(240, 215, 248);color: #ff; " > Votre plafond HT de parrainnage sur votre filleul: <strong>{{number_format($filleul->contrat->seuil_comm,'2','.',' ') }} &euro; </strong></span> <br>
    <span @if($result['ca_comm_parr'] > $filleul->contrat->seuil_comm)  style="background-color: #FD9090;color: #ff; " @endif> Votre CA HT de parrainnage actuellement encaissé sur ce filleul : <strong>{{number_format($result["ca_comm_parr"],'2','.',' ') }} &euro; </strong></span>
   <br> <br> <span   style="color: rgb(107, 64, 64); " >  <strong>NB: Plafond sur les 12 derniers mois précedents la date d'encaissement  </strong> </span>  <span   style="color: #ff0080; " > ( {{$compromis->getFactureStylimmo()->date_encaissement->format('d/m/Y')}} )</span>
    </strong></span>
 
 <hr>
{{-- Si les conditions de parrainnage sont respectées --}}
@if($result['respect_condition'] == false)

    @if($result['a_demission_parrain'] == true)
        <span style="color:#ff0080">VOUS AVEZ DÉMISSIONNÉ AVANT LA DATE D'ENCAISSEMENT DE LA FACTURE STYL'IMMO </span> <hr>
        <span style="color:#1800a3">DATE DE DÉMISSION : {{$parrain->contrat->date_demission->format('d/m/Y')}}</span> <br>
        <span style="color:#ff0080">DATE DE D'ENCAISSEMENT : {{$compromis->getFactureStylimmo()->date_encaissement->format('d/m/Y')}}  </span> <hr>

    @elseif($result['a_demission_filleul'] == true)
        <span style="color:#ff0080">VOTRE FILLEUL A DÉMISSIONNÉ AVANT LA DATE D'ENCAISSEMENT DE LA FACTURE STYL'IMMO </span> <hr>
        <span style="color:#1800a3">DATE DE DÉMISSION : {{$filleul->contrat->date_demission->format('d/m/Y')}}</span> <br>
        <span style="color:#1800a3">DATE DE D'ENCAISSEMENT : {{$compromis->getFactureStylimmo()->date_encaissement->format('d/m/Y')}} </span> <hr>
    @else

    <span style="color:#ff0080">VOUS NE RESPECTEZ PAS LES CONDITIONS DE PARRAINNAGE </span> <hr>

    

    <table style="height: 47px; width: 800px;"  border="1">
        <tbody>
        <tr style="height: 47px; width: 800px; background-color:#C4C4C4;color: green; " >
            <td style="width: 96px;">&nbsp;</td>
            <td style="width: 96px;">Chiffre d'affaires réalisé </td>
            <td style="width: 96px;">Chiffre d'affaires requis </td>
            <td style="width: 97px;">Facture Pub </td>
        </tr>
        <tr>
            <td style="width: 96px;">{{$parrain->nom }} {{$parrain->prenom}} (parrain) </td>
            <td style="width: 96px;"><span @if($result['ca_parrain'] < $result['seuil_parrain'])  style="background-color:#FD9090;color: #fffffff; " @endif> {{number_format($result["ca_parrain"],'2','.',' ')}} &euro; </span></td>
            <td style="width: 96px;">{{number_format($result["seuil_parrain"],'2','.',' ') }} &euro;</td>
            <td style="width: 97px;">Pas pris en compte</td>
        </tr>
        <tr>
            <td style="width: 96px;">{{$filleul->nom }} {{$filleul->prenom}} (filleul) </td>
            <td style="width: 96px;"><span @if($result['ca_filleul'] < $result['seuil_filleul'])  style="background-color:#FD9090;color: #ff; " @endif> {{number_format($result["ca_filleul"],'2','.',' ') }} &euro; </span></td>
            <td style="width: 96px;">{{number_format($result["seuil_filleul"],'2','.',' ') }} &euro;</td>
            <td style="width: 97px;">Pas pris en compte</td>
        </tr>
     
        </tbody>
    </table>
        <br>
    <span style="color:#f81803f5">Chiffre d'affaires HT sur la période du  {{$result["date_12_fr"] }}  au {{$compromis->getFactureStylimmo()->date_encaissement->format('d/m/Y')}}  (Les 12 mois précedents la date de d'encaissement de la facture STYL'IMMO)</span> 

    @endif
@endif
<br>



@if($facture != null && $result['respect_condition'] == true)
    @if($facture->statut != "valide")
        {{-- <a href="{{route('facture.generer_honoraire_create', Crypt::encrypt($facture->id))}}" class="btn btn-default btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-loop"></i>Générer la facture</a> --}}
        <a href="{{route('facture.create_upload_pdf_honoraire', Crypt::encrypt($facture->id))}}" class="btn btn-danger btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-upload"></i>Ajouter ma facture</a>
    @endif    

@endif

<hr>
<div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
    <p><strong>{{$parrain->nom}} {{$parrain->prenom}}</strong> &nbsp; - &nbsp;<strong> SIRET : {{$parrain->siret}} </strong> &nbsp; &nbsp; <strong>{{$parrain->adresse}} {{$parrain->code_postal}} {{$parrain->ville}}</strong> 
      
    </p>
</div>

          </div>
      </div>
</div>
@if ($facture !=null ) {{$facture->id}} @endif
@endsection
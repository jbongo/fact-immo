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
    @if(Auth()->user()->role == "admin" && $facture != null )

        @if(!in_array($facture->statut, ["valide","en attente de validation"]) )

            <a href="{{route('facture.recalculer_honoraire',Crypt::encrypt($facture->id))}}" class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-reload"></i>Recalculer</a>
        @endif
    @endif

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
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Filleul:</strong></span> &nbsp;  <span class="color-warning"> {{$filleul->nom}} {{$filleul->prenom}}&nbsp; </span></td>
            <td style="width: 260px; height:35px"></td>
        </tr>
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Commission agence:</strong></span> &nbsp;  <span class="color-warning"> {{number_format($compromis->frais_agence,'2','.',' ')}} €&nbsp; </span></td>
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
                    <td style="width: 353px; color:brown">Vous n'etiez pas soumis à la TVA au moment du calcul ({{$facture->created_at->format('d-m-Y')}}) </td>
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
{{-- Si les conditions de parrainnage sont respectées --}}
@if($result['respect_condition'] == false)

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
<span style="color:#f81803f5">Chiffre d'affaires sur la période du  {{$result["date_12"] }}  au {{$compromis->date_vente->format('d/m/Y')}} (Les 12 mois précedents la date de vente)</span> 


@endif
<br>


<hr>

@if($facture != null && $result['respect_condition'] != false)
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
@endsection
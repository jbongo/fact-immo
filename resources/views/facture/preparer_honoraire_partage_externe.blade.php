@extends('layouts.app')

@section('content')
   @section ('page_title')
      Note honoraire <span class="color-danger">(commission partage externe)</span> | AGENCE:  {{$compromis->nom_agent}} 
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
              {{-- {{dd($compromis)}} --}}
      
               <hr>

               <div class="row">
                   <div class="col-md-4"> @if(Auth()->user()->role == "admin" && $facture != null )
                        {{-- @if(!in_array($facture->statut, ["valide","en attente de validation"]) ) --}}
                            <a href="{{route('facture.recalculer_honoraire',Crypt::encrypt($facture->id))}}" class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-reload"></i>Recalculer</a>
                        {{-- @endif --}}
                    @endif 
                </div>
                   <div class="col-md-4">
                    @if($facture != null)
                        @if($facture->statut == "valide" && $facture->url != null)
                            <a class="color-info" title="Télécharger la facture d'honoraire "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger Fac:  <i class="ti-download"></i> </a>
                        @elseif($facture->statut == "en attente de validation")
                            <label class="color-danger" ><strong> Facture en attente de validation </strong> &nbsp; </label>
                            @if(Auth()->user()->role == "admin")
                                <a href="{{route('facture.valider_honoraire', [1,Crypt::encrypt($facture->id)] )}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider" id="valider"><i class="ti-check"></i>Valider</a>
                                <a href="{{route('facture.valider_honoraire', [0,Crypt::encrypt($facture->id)] )}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 refuser" id="refuser"><i class="ti-close"></i>Refuser</a>
                            @endif
                        @elseif($facture->statut == "refuse")
                            <label class="color-danger" ><strong> Facture refusée </strong> ({{$facture->motif}})  </label>
                        @else
                        <label class="color-danger" ><strong> Facture non Ajoutée </strong> </label>

                        @endif  
                        
                        @if( $facture->rib != null)
                            <a class="color-warning" title="Télécharger le rib de l'agence "  href="{{route('facture.telecharger_pdf_rib', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger rib <i class="ti-download"></i> </a>
                        @endif
                    @endif
                    
                    <br>
                    <br>
                    <br>
                    
                    @if(Auth()->user()->role == "admin" )
                        @if ($facture->user->contrat->deduis_jeton == false  )
                           <span class="text-danger" style="font-weight: bold">Factures Pub à régler:</span> <a href="{{route('mandataire.historique_facture_pub', Crypt::encrypt($facture->user->id))}}" target="_blank" data-toggle="tooltip" title="@lang('Factures Pub')" class="badge @if($facture->user->nb_facture_pub_retard == 0) badge-success @elseif($facture->user->nb_facture_pub_retard > 0 && $facture->user->nb_facture_pub_retard < 4) badge-warning @else badge-danger @endif ">{{$facture->user->nb_facture_pub_retard}}</a>
                        
                        @else                     
                        <span class="text-danger" style="font-weight: bold">Jetons à déduire:</span>  <a href="{{route('mandataire.historique_jeton', Crypt::encrypt($facture->user->id))}}" target="_blank" data-toggle="tooltip" title="@lang('Détails des jetons ')" class="badge @if($facture->user->nb_mois_pub_restant == 0) badge-success @elseif($facture->user->nb_mois_pub_restant > 0 && $facture->user->nb_mois_pub_restant < 4) badge-warning @else badge-danger @endif ">{{$facture->user->nb_mois_pub_restant}}</a>
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
        {{-- @if(Auth()->user()->role !="admin")        --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;">  <strong>L'agence partage avec :</strong> </span> &nbsp; {{$compromis->user->nom}} {{$compromis->user->prenom}}  &nbsp; </td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        {{-- @endif --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Frais d'agence:</strong> </span> &nbsp; {{ number_format($compromis->frais_agence(), 2, '.', ' ') }} € &nbsp;</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
            {{-- @if(Auth()->user()->role !="admin") --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Pourcentage de l'agence :</strong> </span> &nbsp; {{ 100 - $compromis->pourcentage_agent}} %&nbsp;  </td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        {{-- @endif --}}
    </tbody>
</table>
<br>
<table style="height: 66px; width: 50%">
    <tbody>
            {{-- @if(Auth()->user()->role !="admin") --}}
         <tr>
            <td style="width: 48px;">&nbsp;</td>
            {{-- <td style="width: 428px;"><span style="text-decoration: underline;"><strong>Commission:</strong></span>&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:mediumblue"> {{$mandataire->commission}} %</td> --}}
            <td style="width: 391px; height:35px"></td>
         </tr>
         {{-- @endif --}}
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

@if($facture != null   )
<table style="height: 47px; width: 672px;">
    <tbody>
    


        <tr>
            <td style="width: 400px;">&nbsp; </td>
            <td style="width: 153px;">TOTAL H.T :</td>
            <td style="width: 231px;">{{ number_format($facture->montant_ht, 2, '.', ' ') }} &euro;</td>
        </tr>
        <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>

        @if($facture->montant_ttc > $facture->montant_ht)

        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">T.V.A 20% :</td>
            <td style="width: 231px;">{{ number_format($facture->montant_ttc - $facture->montant_ht, 2, '.', ' ') }} &euro;</td>
        </tr>
        <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr>
        @endif

        {{-- @if(($facture->user->chiffre_affaire >= 35200 && $facture->user->statut == "auto-entrepreneur") || $facture->user->statut!="auto-entrepreneur") --}}
        @if($facture->montant_ttc > 0 )
        {{-- <tr><td>&nbsp;</td> <td>&nbsp;</td> </tr> --}}
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px;">TOTAL T.T.C:</td>
            <td style="width: 231px;">{{ number_format($facture->montant_ttc , 2, '.', ' ') }} &euro;</td>
        </tr>
       
        @else
        
     
        
        <tr>
            <td style="width: 400px;">&nbsp;</td>
            <td style="width: 153px; font-size:20px; color:#dc3545">Montant ht non conforme :</td>
            <td style="width: 231px; font-size:20px; color:#dc3545">{{ number_format($facture->montant_ht, 2, '.', ' ') }} &euro;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="width: 100px;">&nbsp;</td>
            <td style="width: 653px; font-size:20px; color:#dc3545">Contactez le siège pour un recalcul de votre commission</td>
            <td style="width: 31px;"></td>
        </tr>
        
    
        
        @endif
    </tbody>
</table>
<br>
<br>
@if($facture->montant_ht > 0)
<table style="height: 42px; width: 50%;">
    <tbody>
        <tr style="height: 25px;">
            <td style="width: 349px; height: 25px;"> l'agence recevra un montant net de :</td>
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

<hr>
    @if($facture->montant_ht > 0)
        @if($facture->statut != "valide" || Auth()->user()->role == "admin")
            {{-- <a href="{{route('facture.generer_honoraire_create', Crypt::encrypt($facture->id))}}" class="btn btn-default btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-loop"></i>Générer la facture</a> --}}
            <a href="{{route('facture.create_upload_pdf_honoraire', Crypt::encrypt($facture->id))}}" class="btn btn-danger btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-upload"></i>Ajouter la facture de l'agence</a>
        @endif    
    @endif

@endif
<hr>

<div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
    {{-- <p><strong>{{$mandataire->nom}} {{$mandataire->prenom}}</strong> &nbsp; - &nbsp;<strong> SIRET : {{$mandataire->siret}} </strong> &nbsp; &nbsp; <strong>{{$mandataire->adresse}} {{$mandataire->code_postal}} {{$mandataire->ville}}</strong> --}}
    </p>
</div>



          </div>
      </div>
</div>
@if ($facture !=null ) {{$facture->id}} @endif

@endsection
@section('js-content')
    <script>
    // $('.price')    nb = 1580000;
    // alert(nb.toLocaleString());



    </script>

    
<script>

    //###Valider la facture      
    
        $(function() {
           $.ajaxSetup({
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
           })
           
          
           $('[data-toggle="tooltip"]').tooltip()
           $('body').on('click','a.valider',function(e) {
              let that = $(this)
          
              e.preventDefault()
              const swalWithBootstrapButtons = swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
              })
    
        swalWithBootstrapButtons({
           title: '@lang('Voulez-vous vraiment valider la facture ?')',
           type: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#DD6B55',
           confirmButtonText: '@lang('Oui')',
           cancelButtonText: '@lang('Non')',
           
        }).then((result) => {
           if (result.value) {
              $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                       url: that.attr('href'),
                       type: 'GET',
                       success: function(data){
                         document.location.reload();
                       },
                       error : function(data){
                          console.log(data);
                       }
                    })
                    .done(function () {
                          
                    })
    
              swalWithBootstrapButtons(
              'Validée!',
              'Le mandatataire sera notifié par mail.',
              'success'
              )
              
              
           } else if (
              // Read more about handling dismissals
              result.dismiss === swal.DismissReason.cancel
           ) {
              swalWithBootstrapButtons(
              'Annulé',
              'Aucune validation effectuée :)',
              'error'
              )
           }
        })
           })
        })
    
    
    
    // ###  Refuser la facture
    
    
        $(function() {
           $.ajaxSetup({
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
           })
           
          
           $('[data-toggle="tooltip"]').tooltip()
           $('body').on('click','a.refuser',function(e) {
              let that = $(this)
          
              e.preventDefault()
              const swalWithBootstrapButtons = swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
              })
    
        swalWithBootstrapButtons({
           title: '@lang('Voulez-vous vraiment refuser la facture ?')',
           type: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#DD6B55',
           confirmButtonText: '@lang('Oui')',
           cancelButtonText: '@lang('Non')',
           
        }).then((result) => {
           if (result.value) {
              $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                       url: that.attr('href'),
                       type: 'GET',
                       success: function(data){
                         document.location.reload();
                       },
                       error : function(data){
                          console.log(data);
                       }
                    })
                    .done(function () {
                          
                    })
    
              swalWithBootstrapButtons(
              'Refusée!',
              'Le mandatataire sera notifié par mail.',
              'success'
              )
              
              
           } else if (
              // Read more about handling dismissals
              result.dismiss === swal.DismissReason.cancel
           ) {
              swalWithBootstrapButtons(
              'Annulé',
              'Aucune action effectuée :)',
              'error'
              )
           }
        })
           })
        })
    </script>
@endsection
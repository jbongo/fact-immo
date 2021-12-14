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
              {{-- {{dd($compromis)}} --}}
         <div class="row">
             {{-- {{dd($compromis )}} --}}
         
            @if (($mandataire->id == $compromis->user_id && $mandataire->contrat->deduis_jeton == true && $compromis->facture_honoraire_partage_porteur_cree == false && $mandataire->nb_mois_pub_restant > 0)
                || ($mandataire->id == $compromis->agent_id && $mandataire->contrat->deduis_jeton == true && $compromis->facture_honoraire_partage_cree == false && $mandataire->nb_mois_pub_restant > 0)
                )
                {{-- {{dd($mandataire->contrat->deduis_jeton == true && $compromis->facture_honoraire_partage_cree == false)}} --}}
            <br><br>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <span > <strong> Jeton(s) restant(s) : </strong></span>&nbsp;&nbsp;  <span class="color-warning"> <strong> {{$mandataire->nb_mois_pub_restant}}</strong></span> <br>
                        <span > <strong> Dépuis la date d'anniversaire : </strong></span> &nbsp;&nbsp; <span class="color-warning"> <strong> {{$mandataire->date_anniv("fr")}}</strong></span> <br>
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        @if($etat_jeton['retard'] > 0 )                  
                            <span><strong> <span class="clignote" style="font-size:20px; background-color:#FF0633;color:white;visibility:visible; "> Vous n'êtes pas à jour sur les jetons </span>, vous avez <span style="font-size:20px; color:#FF0633;"> {{$etat_jeton['retard']}}</span> mois de retards <strong> </span><br>
                            
                                @if($etat_jeton['retard'] > 3 ) 
                                <span><strong> Vous devez déduire minimum  <span style="font-size:20px; color:#dc3545"> {{$etat_jeton['jeton_min_a_deduire']}}</span> jetons ou <span class="text-danger"> contacter le siège !!.</span><strong> </span>
                                @endif
                      
                        @endif
                    </div>
                </div> <br>

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                            <form class="form-valide form-horizontal" action="{{ route('facture.deduire_pub_facture_honoraire_partage', [Crypt::encrypt($compromis->id), $mandataire->id] ) }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">

                                    <hr>
                                    <div class="col-lg-9 col-md-9 col-sm-9">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-md-6 col-sm-6 control-label" for="nb_mois_deduire">Nombre de jetons à déduire<span class="text-danger">*</span> </label>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                            {{-- <input type="number" max="{{$mandataire->nb_mois_pub_restant}}" min="0" class="form-control {{ $errors->has('nb_mois_deduire') ? ' is-invalid' : '' }}" value="{{old('nb_mois_deduire')}}" id="nb_mois_deduire" name="nb_mois_deduire" required > --}}
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
        @if($compromis->getFactureStylimmo())
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Facture stylimmo N&deg;:</strong> </span> &nbsp; {{$compromis->getFactureStylimmo()->numero}}&nbsp;</td>

            <td style="width: 260px;height:35px"></td>
        </tr>
        @endif
        {{-- @if(Auth()->user()->role !="admin")        --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"> @if($mandataire_partage != null) <strong>Mandataire avec qui je partage:</strong> </span> &nbsp; {{$mandataire_partage->nom}} {{$mandataire_partage->prenom}} @endif &nbsp; </td>
            <td style="width: 260px;height:35px"></td>
        </tr>
        {{-- @endif --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Frais d'agence:</strong> </span> &nbsp; {{ number_format($compromis->frais_agence(), 2, '.', ' ') }} € &nbsp;</td>
            <td style="width: 260px;height:35px"></td>
        </tr>
            {{-- @if(Auth()->user()->role !="admin") --}}
        <tr>
            <td style="width: 423px;"><span style="text-decoration: underline;"><strong>Mon pourcentage de partage:</strong> </span> &nbsp; {{$pourcentage_partage}} %&nbsp; soit ({{ number_format($compromis->frais_agence() * $pourcentage_partage /100, 2, '.', ' ')  }} €) </td>
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




          </div>
      </div>
</div>
@if ($facture !=null ) {{$facture->id}} @endif

@endsection
@section('js-content')
    <script>
    // $('.price')    nb = 1580000;
    // alert(nb.toLocaleString());

console.log("***statut mand :{{$mandataire->statut}}***");
console.log("***mand id :{{$mandataire->id}}***");

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
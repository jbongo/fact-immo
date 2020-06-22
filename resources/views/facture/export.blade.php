@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures 
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
                <!-- table -->
                

            <div class="row">
                
 
                <!-- table -->
                
                <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example00" class=" table student-data-table  table-striped table-hover display    "  style="width:100%"  >
                            <thead>
                                <tr>
                                   
                                    <th style="background: rgb(205, 216, 238);">@lang('Facture Stylimmo')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Mandat')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Date fact')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Charge')</th>                                    
                                    <th style="background: rgb(205, 216, 238);">@lang('Montant HT ')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Montant TTC ')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Date de la vente')</th>
                                    <th style="background: rgb(205, 216, 238);">@lang('Alerte paiement')</th>
                                    @if(auth()->user()->role == "admin")
                                    <th style="background: rgb(205, 216, 238);">@lang('Encaissement')</th>
                                    @endif
                                    <th style="background: rgb(205, 216, 238);">@lang('Net vendeur')</th>
                                    
            
                                    <th style="background: rgb(205, 216, 238);">@lang('Indépendant')</th>
                                    <th style="background:rgb(205, 216, 238);">@lang('son %')</th>

                                    <th style="background: rgb(223, 176, 211);">@lang('N° Fact Hono ')</th>
                                    <th style="background: rgb(223, 176, 211);">@lang('Montant Ht Hono')</th>
                                    <th style="background: rgb(223, 176, 211);">@lang('Montant Ttc Hono')</th>
                                    <th style="background: rgb(223, 176, 211);">@lang('Hono réglé le')</th>

                                    <th style="background: rgb(231, 218, 213);">@lang('Nom Parrain')</th>
                                    <th style="background: rgb(231, 218, 213);">@lang('N° Hono parrain')</th>
                                    <th style="background: rgb(231, 218, 213);">@lang('Montant Ht Parrain')</th>
                                    <th style="background: rgb(231, 218, 213);">@lang('Montant Ttc Parrain')</th>
                                    <th style="background: rgb(231, 218, 213);">@lang('Date règlement fact parrain')</th>


                                    <th style="background: rgb(6, 133, 165);">@lang('Nom du partage')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('son %')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('N° Facture Hono partage')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('Nb Pub déduite')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('Montant Ht Hono ')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('Montant Ttc Hono ')</th>
                                    <th style="background: rgb(6, 133, 165);">@lang('Fact hono Reglé le ')</th>

                                    <th style="background: rgb(140, 221, 201);">@lang('Parrain partage')</th>
                                    <th style="background: rgb(140, 221, 201);">@lang('N° fact parrain')</th>
                                    <th style="background: rgb(140, 221, 201);">@lang('Montant HT hono parrain')</th>
                                    <th style="background: rgb(140, 221, 201);">@lang('Montant TTC hono parrain')</th>
                                    <th style="background: rgb(140, 221, 201);">@lang('Réglé le ')</th>
                                  


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)

                                <tr>
                                    <td width="" >
                                        
                                    <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  </a>

                                    </td>
                                    <td width="" >
                                        {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                    <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  </a></label>

                                    </td>
                                    {{-- Date facture --}}
                                    <td width=""  > @if($facture->date_facture != null) {{$facture->date_facture->format('d/m/Y')}}  @endif</td>
                                    {{-- Charges --}}
                                    <td  style="">
                                        @if($facture->compromis->charge == "Vendeur")
                                            <strong>{{ substr($facture->compromis->nom_vendeur,0,20)}}</strong> 
                                        @else
                                            <strong>{{ substr($facture->compromis->nom_acquereur,0,20)}}</strong> 
                                        @endif   
                                    </td>
                                    {{-- montant ht styl --}}
                                    <td  width="" >
                                        {{number_format($facture->montant_ht,'2','.','')}}
                                    </td>
                                    <td  width="" >
                                        {{number_format($facture->montant_ttc,'2','.','')}}
                                    </td>
                                 
                               {{-- Date vente --}}
                                  
                                    <td width="" >
                                        <label class="color-info">
                                            {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                        </label> 
                                    </td>

                                  
                                {{--  alert paiement--}}
                                    @php
                                        $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                        $diff_jours = $interval / 86400 ;
                                    @endphp

                                    <td width="" >
                                        @if( $facture->encaissee == false && $diff_jours < 3)
                                            <label  style="color:lime">En attente de paiement</label>
                                        @elseif( $facture->encaissee == false && $diff_jours >=3 && $diff_jours <=6)
                                            <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                        @elseif($facture->encaissee == false && $diff_jours >6) 
                                            <label class="danger" style="background-color:#FF0633;color:white;visibility:visible;">Danger !!! &nbsp;&nbsp;</label>
                                        @elseif($facture->encaissee == true)
                                            <label  style="background-color:#EDECE7">En banque  </label>
                                        @endif
                                    </td>


                                {{-- fin alert paiement --}}

                                    {{-- encaissement seulement par admin --}}
                                    @if(auth()->user()->role == "admin")
                                    <td width="" >
                                        @if($facture->encaissee == 0)
                                        
                                        @else 
                                        <label class="color-danger"> @if($facture->date_encaissement != null) {{$facture->date_encaissement->format('d/m/Y')}} @else  @endif  </label> 
                                        @endif 
                                    </td>
                                    @endif
                            
                                {{-- Net vendeur --}}

                                <td width=""  >  {{number_format($facture->compromis->net_vendeur,'2','.','')}} </td>

                                {{-- Indépendant --}}

                                  <td width="" >
                                    <label class="color-info">
                                        @if($facture->user !=null)
                                        <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}</a>  
                                       @endif
                                    </label> 
                                </td>

                                 {{-- Son % --}}
                                    <td width=""  > @if($facture->compromis->est_partage_agent == 1) {{$facture->compromis->pourcentage_agent}}% @else 100% @endif </td>

                                    {{-- FACTURE HONO DU MANDATAIRE QUI PORTE L'AFFAIRE --}}
                                    <td width=""  >  @if($facture->compromis->getHonoPorteur() != null) {{$facture->compromis->getHonoPorteur()->numero}}  @endif</td>
                                    <td width=""  >  @if($facture->compromis->getHonoPorteur() != null)  {{number_format($facture->compromis->getHonoPorteur()->montant_ht,'2','.','')}}  @endif</td>
                                    <td width=""  >  @if($facture->compromis->getHonoPorteur() != null)  {{number_format($facture->compromis->getHonoPorteur()->montant_ttc,'2','.','')}}  @endif</td>                            
                                    <td width=""  > @if($facture->compromis->getHonoPorteur() != null && $facture->compromis->getHonoPorteur()->date_reglement != null ) {{$facture->compromis->getHonoPorteur()->date_reglement->format('d/m/Y')}}  @endif </td>
                                    
                                    {{-- PARRAIN DE CELUI QUI PORTE L'AFFAIRE --}}
                                    <td width=""  >  @if($facture->compromis->getFactureParrainPorteur() != null && $facture->compromis->getFactureParrainPorteur()->user!= null ) {{$facture->compromis->getFactureParrainPorteur()->user->nom }} {{$facture->compromis->getFactureParrainPorteur()->user->prenom }}  @endif </td>
                                    <td width=""  >  @if($facture->compromis->getFactureParrainPorteur() != null ) {{$facture->compromis->getFactureParrainPorteur()->numero }}  @endif  </td>
                                    <td width=""  >   @if($facture->compromis->getFactureParrainPorteur() != null ) {{number_format($facture->compromis->getFactureParrainPorteur()->montant_ht,'2','.','')}}   @endif  </td>
                                    <td width=""  >   @if($facture->compromis->getFactureParrainPorteur() != null ) {{number_format($facture->compromis->getFactureParrainPorteur()->montant_ttc,'2','.','')}}   @endif  </td>                                  
                                    <td width=""  >  @if($facture->compromis->getFactureParrainPorteur() != null && $facture->compromis->getFactureParrainPorteur()->date_reglement != null ) {{$facture->compromis->getFactureParrainPorteur()->date_reglement->format('d/m/Y')}}  @endif  </td>
                                    
                                    {{-- LE MANDATAIRE QUI PARTAGE L'AFFAIRE --}}
                                    
                                    <td width=""  >  @if($facture->compromis->getHonoPartage() != null && $facture->compromis->getHonoPartage()->user!= null ) {{$facture->compromis->getHonoPartage()->user->nom }} {{$facture->compromis->getHonoPartage()->user->prenom }}  @endif </td>
                                    <td width=""  >  @if($facture->compromis->getHonoPartage() != null ) {{100- $facture->compromis->pourcentage_agent }}  @endif  </td>
                                    <td width=""  >  @if($facture->compromis->getHonoPartage() != null ) {{$facture->compromis->getHonoPartage()->numero }}  @endif  </td>
                                    <td width=""  >  @if($facture->compromis->getHonoPartage() != null ) {{$facture->compromis->getHonoPartage()->nb_mois_deduis }}  @endif  </td>
                                    <td width=""  >   @if($facture->compromis->getHonoPartage() != null ) {{number_format($facture->compromis->getHonoPartage()->montant_ht,'2','.','')}}   @endif  </td>
                                    <td width=""  >   @if($facture->compromis->getHonoPartage() != null ) {{number_format($facture->compromis->getHonoPartage()->montant_ttc,'2','.','')}}   @endif  </td>                                  
                                    <td width=""  >  @if($facture->compromis->getHonoPartage() != null && $facture->compromis->getHonoPartage()->date_reglement != null ) {{$facture->compromis->getHonoPartage()->date_reglement->format('d/m/Y')}}  @endif  </td>
                                  
                                  {{-- LE  PARRAIN DU PARTAGE --}}
                                  <td width=""  >  @if($facture->compromis->getFactureParrainPartage() != null && $facture->compromis->getFactureParrainPartage()->user!= null ) {{$facture->compromis->getFactureParrainPartage()->user->nom }} {{$facture->compromis->getFactureParrainPartage()->user->prenom }}  @endif </td>
                                  <td width=""  >  @if($facture->compromis->getFactureParrainPartage() != null ) {{$facture->compromis->getFactureParrainPartage()->numero }}  @endif  </td>
                                  <td width=""  >   @if($facture->compromis->getFactureParrainPartage() != null ) {{number_format($facture->compromis->getFactureParrainPartage()->montant_ht,'2','.','')}}   @endif  </td>
                                  <td width=""  >   @if($facture->compromis->getFactureParrainPartage() != null ) {{number_format($facture->compromis->getFactureParrainPartage()->montant_ttc,'2','.','')}}   @endif  </td>                                  
                                  <td width=""  >  @if($facture->compromis->getFactureParrainPartage() != null && $facture->compromis->getFactureParrainPartage()->date_reglement != null ) {{$facture->compromis->getFactureParrainPartage()->date_reglement->format('d/m/Y')}}  @endif  </td>
                                  
                                
                                </tr> 
                           
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
            <!-- end table -->
        


      




               </div>
         </div>
      </div>
    </div>
@endsection

@section('js-content')


{{-- ##### Encaissement de la facture stylimmo --}}
<script>

function getId(id){
   facture_id = id;
   // console.log(id);
   
}


   // $('.encaisser').click(function(){
   //    facture_id = $(this).attr('data-id');
   //    console.log("okok");
      
   //    console.log(facture_id);
   // })
      
      
      
$('#valider_encaissement').on('click',function(e){
  e.preventDefault();

if($("#date_encaissement").val() != ""){
  

   $.ajax({
         type: "GET",
         url: "encaisser/factures-stylimmo/"+facture_id ,
         data:  $("#form_encaissement").serialize(),
         success: function (result) {
                  swal(
                     'Encaissée',
                     'Vous avez encaissé la facture '+result,
                     'success'
                  )
                  .then(function() {
                     window.location.href = "{{route('facture.index')}}";
                  })
         },
         error: function(error){
            swal(
                     'Echec',
                     'la facture '+error+' n\'a pas été encaissée',
                     'error'
                  )
                  .then(function() {
                     window.location.href = "{{route('facture.index')}}";
                  })
            
         }
   });
}

});

</script>
{{-- Alertes paiement  --}}
<script type="text/javascript">
   var clignotement = function(){

      var element = document.getElementsByClassName('danger');
   

      Array.prototype.forEach.call(element, function(el) {
         if (el.style.visibility=='visible'){
            el.style.visibility='hidden';
         }
         else{
            el.style.visibility='visible';
         }
     });
     
     
   };

   periode = setInterval(clignotement, 1500);

</script>

{{--  Reglement de la facture stylimmo--}}
<script>
   // $('.payer').on('click',function(e){
   //    facture_id = $(this).attr('id');  
   //    console.log(facture_id);
   // });

   function getIdPayer(id){
      facture_id = id;
      // console.log(id);
      
   }



   $('#valider_reglement').on('click',function(e){
       e.preventDefault();
 
      if($("#date_reglement").val() != ""){

         $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
         $.ajax({
               type: "GET",
               url: "regler/factures-honoraire/"+facture_id ,
               data:  $("#form_regler").serialize(),
               success: function (result) {
                  swal(
                     'Réglée',
                     'Vous avez reglé la facture ',
                     'success'
                  )
                  .then(function() {
                     window.location.href = "{{route('facture.index')}}";
                  })
               },
               error: function(error){
                  console.log(error);
                  
                  swal(
                           'Echec',
                           'la facture  n\'a pas été reglé '+error,
                           'error'
                        )
                        .then(function() {
                           window.location.href = "{{route('facture.index')}}";
                        })
                  
               }
         });
      }


   });
 
</script>


@endsection
@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures à Payer
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
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_a_payer" class="active"><a href="#a_payer" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Honoraires à payer')<span class="badge badge-warning"> {{App\Facture::nb_facture_a_payer()}}</span></a> </li>
                          <li id="li_non_ajoute_nav"><a href="#non_ajoute_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Honoraires non ajoutées + Attente de Valid.')</a></li>
                          <li id="li_etat_fin_nav"><a href="#etat_fin_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Etat Financier')</a></li>
                          <li id="li_reitere_nav"><a href="#reitere_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Honoraires réitérées non crées')</a></li>
                         
                         
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="a_payer"> @include('facture.a_payer.a_payer')</div>
                                <div class="tab-pane" id="non_ajoute_nav">@include('facture.a_payer.non_ajoute')</div>
                                <div class="tab-pane" id="etat_fin_nav">@include('facture.a_payer.etat_fin')</div>
                                <div class="tab-pane" id="reitere_nav">@include('facture.a_payer.compro_r')</div>
                             </div>
                          </div>
                       </div>
                    </div>





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
            console.log(result);
            
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
            console.log(error);
            
            swal(
                     'Echec',
                     'la facture '+error+' n\'a pas été encaissée',
                     'error'
                  )
                  .then(function() {
                     // window.location.href = "{{route('facture.index')}}";
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
    //    console.log(id);
      
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
               url: "/regler/factures-honoraire/"+facture_id ,
               data:  $("#form_regler").serialize(),
               success: function (result) {
                  swal(
                     'Réglée',
                     'Vous avez reglé la facture ',
                     'success'
                  )
                  .then(function() {
                     window.location.href = "{{route('facture.honoraire_a_payer')}}";
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
                        //    window.location.href = "{{route('facture.honoraire_a_payer')}}";
                        })
                  
               }
         });
      }


   });
 
</script>


@endsection
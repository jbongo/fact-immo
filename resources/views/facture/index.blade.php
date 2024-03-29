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
                @if(Auth::user()->role == "admin")
                
                <a href="{{route('facture.create_libre')}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Créer facture STYL\'IMMO')</a> 
                <span class="color-primary"><a href="{{route('facture.index_all')}}" target="_blank"> Voir toutes les factures STYL'IMMO </a></span>
                  <br> <hr>
             
               @endif
            <div class="row">
            
               <nav class="navbar navbar-default">
                  <div class="container-fluid">
                   
                  
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                      <ul class="nav navbar-nav">
                        <li class="active"><a href="{{route('facture.index')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Styl'immo <span class="sr-only">(current)</span></a></li>
                        <li><a href="{{route('facture.index_honoraire')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Honoraires</a></li>
                        <li><a href="{{route('facture.index_communication')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif</a></li>
                        @if(Auth()->user()->role == "admin") <li><a href="{{route('facture.index_fournisseur')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  @lang('Factures Fournisseurs')  <span class="badge badge-danger"></span></a></li> @endif
                        
                      </ul>
                
                     
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
                </nav>
            
                    <!-- Navigation Buttons -->
                    {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_stylimmo" class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Factures Styl\'immo')</a></li>
                          <li id="li_caracteristique_nav"><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Factures Honoraires')</a></li>
                          <li id="li_autre_nav"><a href="#autre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif </a></li>
                         
                         
                       </ul>
                    </div> --}}
                    <!-- Content -->
                    {{-- <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="stylimmo"> @include('facture.stylimmo')</div>
                                <div class="tab-pane" id="caracteristique_nav">@include('facture.honoraire')</div>
                                <div class="tab-pane" id="autre_nav"> @if(Auth()->user()->role == "admin")  @include('facture.pubs') @else @include('facture.communication') @endif </div>                               
                             </div>
                          </div>
                       </div>
                    </div> --}}
                    
                  <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                @include('facture.stylimmo')
                                                     
                             </div>
                          </div>
                       </div>
                    </div> 




                        <!-- Modal d'encaissement de la facture stylimmo-->
                  <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog modal-xs">
                     
                        <!-- Modal content-->
                        <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Date d'encaissement</h4>
                           </div>
                           <div class="modal-body">
                              <form action="" method="get" id="form_encaissement">
                                    <div class="modal-body">
                                       
                                       <div class="">
                                          <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_encaissement">Date d'encaissement <span class="text-danger">*</span> </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                   <input type="date"  class="form-control {{ $errors->has('date_encaissement') ? ' is-invalid' : '' }}" value="{{old('date_encaissement')}}" max="{{date('Y-m-d')}}" id="date_encaissement" name="date_encaissement" required >
                                                   @if ($errors->has('date_encaissement'))
                                                   <br>
                                                   <div class="alert alert-warning ">
                                                      <strong>{{$errors->first('date_encaissement')}}</strong> 
                                                   </div>
                                                   @endif   
                                                </div>
                                          </div>
                                       </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                                       <input type="submit" class="btn btn-success" id="valider_encaissement"  value="Valider" />
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    </div>
                              </form> 
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
      // console.log(id);
      
   }



// Règlement de la note d'honoraire
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
   
   
   
   
   
   // Règlement de la facture de pub
   $('#valider_reglement_pub').on('click',function(e){
       e.preventDefault();
 
      if($("#date_reglement_pub").val() != ""){

         $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
         $.ajax({
               type: "GET",
               url: "regler/factures-honoraire/"+facture_id ,
               data:  $("#form_regler_pub").serialize(),
               success: function (result) {
                  swal(
                     'Réglée',
                     'Vous avez reglé la facture ',
                     'success'
                  )
                  .then(function(data) {
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

<script>
   // ######### Réitérer une affaire


   $(function() {
       $.ajaxSetup({
           headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
       })
       $('[data-toggle="tooltip"]').tooltip()
       $('body').on('click','a.cloturer',function(e) {
           let that = $(this)
           e.preventDefault()
           const swalWithBootstrapButtons = swal.mixin({
       confirmButtonClass: 'btn btn-success',
       cancelButtonClass: 'btn btn-danger',
       buttonsStyling: false,
})

   swalWithBootstrapButtons({
       title: 'Confirmez-vous la réitération de cette affaire (Mandat '+that.attr("data-mandat")+' )  ?',
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
                       that.parents('tr').remove()
               })

           swalWithBootstrapButtons(
           'Réitérée!',
           'L\'affaire a bien été réitérée.',
           'success'
           )
           
           
       } else if (
           // Read more about handling dismissals
           result.dismiss === swal.DismissReason.cancel
       ) {
           swalWithBootstrapButtons(
           'Annulé',
           'L\'affaire n\'a pas été réitérée.',
         
           'error'
           )
       }
   })
       })
   })
</script>





{{-- Relancer un mandataire pour une facture PUB --}}
<script>      
        
        
    $(function() {
       $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
       })
       
      
       $('[data-toggle="tooltip"]').tooltip()
       $('body').on('click','a.relancer',function(e) {
          let that = $(this)
      
          e.preventDefault()
          const swalWithBootstrapButtons = swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          })

    swalWithBootstrapButtons({
       title: 'Le mandataire va recevoir un mail de relance, continuer ?',
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
                  console.log(data);
                      
                })

          swalWithBootstrapButtons(
          'Relancé!',
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
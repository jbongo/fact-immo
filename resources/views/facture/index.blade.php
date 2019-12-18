@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures  {{session('admin_id')}}
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
                          <li id="li_stylimmo" class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures Styl\'immo')</a></li>
                          <li id="li_caracteristique_nav"><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures Honoraires')</a></li>
                          <li id="li_autre_nav"><a href="#autre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @if(auth::user()->role == "admin") @lang('Factures Fournisseurs') @else @lang('Factures Communication') @endif </a></li>
                         
                         
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="stylimmo"> @include('facture.stylimmo')</div>
                                <div class="tab-pane" id="caracteristique_nav">@include('facture.honoraire')</div>
                                <div class="tab-pane" id="autre_nav">@include('facture.autre')</div>
                               
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


  
  <script>
      $(function() {
         $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
         })
         $('[data-toggle="tooltip"]').tooltip()
         $('a.encaisser').on('click',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

      swalWithBootstrapButtons({
         title: '@lang('Voulez-vous vraiment continuer ?')',
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
            'Encaissée!',
            'Le mandatataire sera notifié par mail.',
            'success'
            )
            
            
         } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
         ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Aucune modification effectuée :)',
            'error'
            )
         }
      })
         })
      })
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
   $('.payer').on('click',function(e){

      facture_id = $(this).attr('id');
      
   });

   $('#valider_reglement').on('click',function(e){
      // e.preventDefault();
 
      if($("#date_reglement").val() != ""){

     
         $.ajax({
               type: "POST",
               url: "regler/factures-honoraire/"+facture_id ,
               data:  $("#form_regler").serialize(),
               success: function (result) {
                  console.log(result); 
                  document.location.reload();
               },
               error: function(error){
                  console.log(error);
                  
               }
         });
      }


   });
 
</script>


@endsection
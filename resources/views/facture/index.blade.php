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
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_stylimmo" class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures Styl\'immo')</a></li>
                          <li id="li_caracteristique_nav"><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures Honoraires')</a></li>
                          <li id="li_autre_nav"><a href="#autre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @if(Auth()->user()->role == "admin") @lang('Factures Fournisseurs') @else @lang('Factures Communication') @endif </a></li>
                         
                         
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
                                                   <input type="date"  class="form-control {{ $errors->has('date_encaissement') ? ' is-invalid' : '' }}" value="{{old('date_encaissement')}}" id="date_encaissement" name="date_encaissement" required >
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
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
{{-- href="{{route('facture.encaisser_facture_stylimmo', Crypt::encrypt($facture->id))}}" --}}

<script>
   // console.log("ddddddddddddddddddd");
   $('.encaisser').on('click',function(e){
      facture_id = $(this).attr('id');
      console.log(facture_id);
      
      
   });

$('#valider_encaissement').on('click',function(e){
// e.preventDefault();

if($("#date_encaissement").val() != ""){


   $.ajax({
         type: "GET",
         url: "encaisser/factures-stylimmo/"+facture_id ,
         data:  $("#form_encaissement").serialize(),
         success: function (result) {
            console.log(result); 
            // document.location.reload();
         },
         error: function(error){
            console.log(error);
            
         }
   });
}


});


      // $(function() {
      //    $.ajaxSetup({
      //       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      //    })
      //    $('[data-toggle="tooltip"]').tooltip()
      //    $('a.encaisser').on('click',function(e) {
      //       let that = $(this)
      //       e.preventDefault()
      //       const swalWithBootstrapButtons = swal.mixin({
      //       confirmButtonClass: 'btn btn-success',
      //       cancelButtonClass: 'btn btn-danger',
      //       buttonsStyling: false,
      //       })

      // swalWithBootstrapButtons({
      //    title: '@lang('Voulez-vous vraiment continuer ?')',
      //    type: 'warning',
      //    showCancelButton: true,
      //    confirmButtonColor: '#DD6B55',
      //    confirmButtonText: '@lang('Oui')',
      //    cancelButtonText: '@lang('Non')',
         
      // }).then((result) => {
      //    if (result.value) {
      //       $('[data-toggle="tooltip"]').tooltip('hide')
      //             $.ajax({                        
      //                url: that.attr('href'),
      //                type: 'GET',
      //                success: function(data){
      //                  document.location.reload();
      //                },
      //                error : function(data){
      //                   console.log(data);
      //                }
      //             })
      //             .done(function () {
                        
      //             })

      //       swalWithBootstrapButtons(
      //       'Encaissée!',
      //       'Le mandatataire sera notifié par mail.',
      //       'success'
      //       )
            
            
      //    } else if (
      //       // Read more about handling dismissals
      //       result.dismiss === swal.DismissReason.cancel
      //    ) {
      //       swalWithBootstrapButtons(
      //       'Annulé',
      //       'Aucune modification effectuée :)',
      //       'error'
      //       )
      //    }
      // })
      //    })
      // })
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

         $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
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
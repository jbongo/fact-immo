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
                          <li id="li_stylimmo" class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures émises')</a></li>
                          <li id="li_caracteristique_nav"><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Factures reçues')</a></li>
                         
                         
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="stylimmo"> @include('facture.emise')</div>
                                <div class="tab-pane" id="caracteristique_nav">@include('facture.recu')</div>
                               
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
         $('a.encaisser').click(function(e) {
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
                     type: 'POST',
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
@endsection
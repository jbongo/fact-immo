@extends('layouts.app')
@section('content')
    @section ('page_title')
    Affaires
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
            @if (Auth()->user()->role == "mandataire")
                <a href="{{route('compromis.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle affaire')</a>
            <br><br>
            @endif
                <!-- table -->
                

            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_stylimmo"  class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @if (Auth()->user()->role == "mandataire") Mes @endif Affaires </a></li>
                         @if(Auth()->user()->role == "mandataire") <li id="li_caracteristique_nav" ><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Affaires de mes filleuls ')</a></li>  @endif                       
                         
                         <li id="li_sous_offre_nav" style="background-color: #FFA500;" class=""><a href="#sous_offre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous offre</a></li>                       
                         <li id="li_sous_compromis_nav" style="background-color: #0ad2ff;" ><a href="#sous_compromis_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous compromis</a></li>                       
                         <li id="li_en_attente_nav" style="background-color: #e6e6e6;" ><a href="#en_attente_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">timer</i> En attente d'encaissement</a></li>                       
                         <li id="li_encaissee_nav" style="background-color: #6eff1a;"><a href="#encaissee_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  Encaissées </a></li>
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="stylimmo"> @include('compromis.mes_affaires')</div>
                               @if(Auth()->user()->role == "mandataire") <div class="tab-pane" id="caracteristique_nav">@include('compromis.affaires_parrainee')</div>@endif
                               <div class="tab-pane " id="sous_offre_nav"> @include('compromis.type_affaire.sous_offre')</div>
                                 <div class="tab-pane " id="sous_compromis_nav"> @include('compromis.type_affaire.sous_compromis')</div>
                                 <div class="tab-pane " id="en_attente_nav"> @include('compromis.type_affaire.en_attente')</div>
                                <div class="tab-pane " id="encaissee_nav"> @include('compromis.type_affaire.encaissee')</div>
                               
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
 
    periode = setInterval(clignotement, 4000);
 
 </script>
<script>
        // ######### Cloturer une affaire


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
            title: 'Confirmez-vous la clôture de cette affaire (Mandat '+that.attr("data-mandat")+' )  ?',
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
                'Cloturé!',
                'L\'affaire a bien été clôturée.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'L\'affaire n\'a pas été clôturée.',
              
                'error'
                )
            }
        })
            })
        })
    </script>

    {{-- Archiver une affaire --}}
    <script>

$('.archiver').on('click',function(e){
      archive_id = $(this).attr('id');
   });
   
   

$('#valider_archive').on('click',function(e){
 e.preventDefault();

if($("#motif_archive").val() != ""){

    $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
   $.ajax({

         type: "POST",
         url: "compromis/archiver/"+archive_id ,
         data:  $("#form_archive").serialize(),
         success: function (result) {
            swal(
                'Archivée',
                'Vous retrouverez votre affaire dans les archives!',
                'success'
            )
            .then(function() {
                window.location.href = "{{route('compromis.index')}}";
            })
        
         },
         error: function(error){
            console.log(error);
            
         }
   });
}


});
    </script>

    {{-- Envois sur la tabulation en fonction de l'ancre dasn l'url #aaa --}}
<script type="text/javascript">
    $(document).ready(function(){
        var anchorHash = window.location.href.toString();
        if( anchorHash.lastIndexOf('#') != -1 ) {
            anchorHash = anchorHash.substr(anchorHash.lastIndexOf('#'));
            if( $('a[href="'+ anchorHash +'"]').length > 0 ) {
                $('a[href="'+ anchorHash +'"]').trigger('click');
            }
        }
    });
</script>
@endsection
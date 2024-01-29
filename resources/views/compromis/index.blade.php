@extends('layouts.app')
@section('content')
    @section ('page_title')
    Affaires en cours @if($page_filleul != null) de mes filleuls @endif
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
            @if (Auth()->user()->role == "mandataire" && $page_filleul ==null)
                <a href="{{route('compromis.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle affaire')</a>
            <br><br>
            @endif
                <!-- table -->
                

            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          @if($page_filleul ==null) 
                            <li id="li_stylimmo"  class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @if (Auth()->user()->role == "mandataire") Mes @endif Affaires </a></li>
                            <li id="li_sous_offre_nav" style="background-color: #FFA500;" class=""><a href="#sous_offre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous offre</a></li>                       
                            <li id="li_sous_compromis_nav" style="background-color: #0ad2ff;" ><a href="#sous_compromis_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous compromis</a></li>                       
                            <li id="li_en_attente_nav" style="background-color: #e6e6e6;" ><a href="#en_attente_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">timer</i> En attente d'encaissement  @if(Auth::user()->role == "mandataire") (STYL) @endif</a></li>                       
                            <li id="li_encaissee_nav" style="background-color: #6eff1a;"><a href="#encaissee_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  Encaissées  @if(Auth::user()->role == "mandataire") (STYL) @endif </a></li>
                          @else 
                                @if(Auth()->user()->role == "mandataire") <li id="li_caracteristique_nav" class="active" ><a href="#caracteristique_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i> @lang('Affaires de mes filleuls ')</a></li>  @endif                       
                          
                          @endif
                         
                       
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                            @if($page_filleul ==null) 
                                <div class="tab-pane active" id="stylimmo"> @include('compromis.mes_affaires')</div>
                            @else
                               @if(Auth()->user()->role == "mandataire") <div class="tab-pane active" id="caracteristique_nav">@include('compromis.affaires_parrainee')</div>@endif
                            @endif
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



<!-- Modal archive de l'affaire -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-xs">
    
        <!-- Modal content-->
        <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choisir la raison de l'archive</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form_archive">
                    <div class="modal-body">
                        
                        <div class="">
                            <div class="form-group row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                   
                                    <div>
                                        <input type="radio" id="perte" name="motif_archive" value="Perte du mandat" checked>
                                        <label for="perte">Perte du mandat</label>
                                      </div>
                                      
                                      <div>
                                        <input type="radio" id="retrait" name="motif_archive" value="Retrait de l'acquéreur ">
                                        <label for="retrait">Retrait de l'acquéreur </label>
                                      </div>
                                      
                                      <div>
                                        <input type="radio" id="refus" name="motif_archive" value="Refus de finacement">
                                        <label for="refus">Refus de finacement</label>
                                      </div>
                                      <div>
                                        <input type="radio" id="deces" name="motif_archive" value="Décès">
                                        <label for="deces">Décès</label>
                                      </div>
                                      <div>
                                        <input type="radio" id="autre" name="motif_archive" value="Autre">
                                        <label for="autre">Autre</label>
                                      </div>
                                </div>
                                
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="valider_archive"  value="Valider" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form> 
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
         url: "/compromis/archiver/"+archive_id ,
         data:  $("#form_archive").serialize(),
         success: function (result) {
             if(result =="avoir"){
                swal(
                'Archivée, Avoir STYL\'IMMO généré',
                'Vous retrouverez votre affaire dans les archives!',
                'success'
                )
                .then(function() {
                window.location.href = "{{route('compromis.index')}}";
                })
             }else{
                swal(
                'Archivée',
                'Vous retrouverez votre affaire dans les archives!',
                'success'
                )
                .then(function() {
                    window.location.href = "{{route('compromis.index')}}";
                })
             }
           
            
        
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


{{-- Demandes de facture impossible si date de vente - today  > 15 jours --}}
<script>

$('.demander_facture').click(function(e){
    e.preventDefault();

// on reccupère la date today et la date de vente
    var today = new Date();
    today = (today.getMonth()+1)+'/'+today.getDate()+'/'+today.getFullYear();
    date_vente = $(this).attr('date-vente');

// On calcul la différence entre les deux dates
    const dateT = new Date(today);
    const dateV = new Date(date_vente);
    const diffTime = dateV - dateT;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    // console.log(diffTime + " milliseconds");
    console.log(diffDays + " jours");
    console.log(date_vente );

const nb_jour_max_demande = "{{$nb_jour_max_demande}}";

console.log(diffDays);
    if(diffDays > nb_jour_max_demande  &&  diffDays > 0 ){

        swal(
                'Demande de facture impossible',
                'La demande de facture ne peut être faite plus de '+nb_jour_max_demande+' jours avant la date de vente: ( '+$(this).attr('date_vente')+' )',
                'error'
        )
    // swal(diffDays +'jours')
        
    }
    else{
        window.location.href = $(this).attr('href');
    }

})



</script>
@endsection
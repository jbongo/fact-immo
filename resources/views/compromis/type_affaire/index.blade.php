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
         
                <a href="{{route('compromis.index')}}" class="btn btn-danger btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-folder"></i>@lang('Générales  (toutes les affaires)')</a>
            <br><br>
       
                <!-- table -->
                

            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                           <li id="li_sous_offre_nav" class="active"><a href="#sous_offre_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous offre</a></li>                       
                           <li id="li_sous_compromis_nav"><a href="#sous_compromis_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i> Sous compromis</a></li>                       
                           <li id="li_en_attente_nav"><a href="#en_attente_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">timer</i> En attente d'encaissement</a></li>                       
                           <li id="li_encaissee_nav" ><a href="#encaissee_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  Encaissées </a></li>
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                 <div class="tab-pane active" id="sous_offre_nav"> @include('compromis.type_affaire.sous_offre')</div>
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


<script>

$(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','a.delete',function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })
        swalWithBootstrapButtons({
            title: '@lang('Vraiment archiver cette affaire  ?')',
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
                        type: 'PUT'
                    })
                    .done(function () {
                            that.parents('tr').remove()
                    })

                swalWithBootstrapButtons(
                'Archivé!',
                'Le compromis a bien été archivé.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'Le compromis n\'a pas été archivé :)',
                'error'
                )
            }
        })
            })
        })






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
@endsection
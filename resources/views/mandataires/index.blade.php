@extends('layouts.app')
@section('content')
    @section ('page_title')
    Mandataires
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
            <a href="{{route('mandataire.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouveau mandataire')</a>
              
            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_mandataire_actif" class="active"><a href="#mandataire_actif" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Mandataires Actifs')</a></li>
                          <li id="li_demissionnaire_nav"><a href="#demissionnaire_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Démissionnaires')</a></li>
                          <li id="li_desactive_nav"><a href="#desactive_nav" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Mandataires Désactivés')</a></li>
                         
                         
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="mandataire_actif"> @include('mandataires.mandataire')</div>
                                <div class="tab-pane" id="demissionnaire_nav">@include('mandataires.demissionnaire')</div>
                                <div class="tab-pane" id="desactive_nav">@include('mandataires.desactive')</div>
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
        
        
        $('body').on('click','a.activer',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({   
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
                 })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment réactiver cet mandataire  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        
                        
        
                    $.ajax({
                        type: "POST",
                        // url: "{{route('mandataire.add')}}",
                        url: that.attr('href'),
                       
                        // data: data,
                        success: function(data) {
                            console.log(data);
                            
                            swal(
                                    'Activé',
                                    'Le mandataire a été réactivé \n Veuillez mettre à jour son contrat',
                                    'success'
                                )
                                .then(function() {
                                    window.location.href = that.attr('contrat');
                                })
                                // setInterval(() => {
                                //     window.location.href = "{{route('mandataire.index')}}";
                                    
                                // }, 5);
                        },
                        error: function(data) {
                            console.log(data);
                            
                            swal(
                                'Echec',
                                'Le mandataire n\'a pas été activé :)',
                                'error'
                            );
                        }
                    });
                    
                  
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Le mandataire n\'a pas été activé :)',
                    'error'
                    )
                }
            })
         })
    })
</script>


@endsection
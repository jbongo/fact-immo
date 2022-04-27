@extends('layouts.app')
@section('content')
    @section ('page_title')
    Fournisseurs
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
                    <a href="{{route('fournisseur.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un fournisseur')</a>
                    <a href="{{route('passerelles.index')}}" class="btn btn-warning btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-direction"></i>@lang('Passerelles')</a>
                      <br> <hr>
               @endif
               <div class="row">
                <!-- Navigation Buttons -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                   <ul class="nav nav-pills nav-tabs" id="myTabs">
                
                        <li class="active" id="li_passerelle" ><a href="#passerelle" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">file_download</i>  Fournisseurs de Passerelles <span class="sr-only">(current)</span> </a></li>
                        <li id="li_autre" style="background-color: #FFA500;" class=""><a href="#autre" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">trending_up</i>Autres Fournisseurs</a></li>                       

                   </ul>
                </div>
                
                <!-- Content -->
                <div class=" col-lg-12 col-md-12 col-sm-12">
                   <div class="card">
                      <div class="card-body">
                         <div class="tab-content">                      
                            <div class="tab-pane active " id="passerelle"> @include('fournisseur.passerelle')</div>
                            <div class="tab-pane " id="autre"> @include('fournisseur.autre')</div>
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
        $('a.delete').click(function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
})

    swalWithBootstrapButtons({
        title: '@lang('Vraiment archiver cet fournisseur  ?')',
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
            'L\'fournisseur a bien été archivé.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'L\'utlisateur n\'a pas été archivé :)',
            'error'
            )
        }
    })
        })
    })
</script>

@endsection
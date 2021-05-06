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
            <a href="{{route('prospect.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouveau prospect')</a>
              
            
                
            <div class="card-body">
                <div class="panel panel-info m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example00" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Nom')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Téléphone')</th>
                                <th>@lang('Code postal')</th>
                                <th>@lang('Ville')</th>
                               
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($prospects as $prospect)
                        
                            <tr>
                                
                               
                                <td>
                                    {{$prospect->prenom}} {{$prospect->nom}} 
                                </td>
                                <td>
                                    {{$prospect->email}} 
                                </td>
                                <td>
                                    {{$prospect->telephone_personnel}}
                                </td>
                                <td>
                                    {{$prospect->code_postal}}
                                </td>
                                <td>
                                    {{$prospect->ville}}
                                </td>
                                                         
                              
                                <td width="13%">
                                    <span><a href="{{route('prospect.show',Crypt::encrypt($prospect->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $prospect->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                    <span><a href="{{route('prospect.edit',Crypt::encrypt($prospect->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $prospect->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                    {{-- <span><a href="{{route('switch_user',Crypt::encrypt($prospect->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $prospect->nom }}"><i class="large material-icons color-success">person_pin</i></a></span> --}}
                                    
                                {{-- <span><a  href="{{route('prospect.archive',[$prospect->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $prospect->nom }}"><i class="large material-icons color-danger">delete</i> </a></span> --}}
                                </td>
                            </tr>
                            
  
                            
                            
                    @endforeach
                      </tbody>
                    </table>
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
                title: '@lang('Vraiment réactiver cet prospect  ?')',
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
                        // url: "{{route('prospect.add')}}",
                        url: that.attr('href'),
                       
                        // data: data,
                        success: function(data) {
                            console.log(data);
                            
                            swal(
                                    'Activé',
                                    'Le prospect a été réactivé \n Veuillez mettre à jour son contrat',
                                    'success'
                                )
                                .then(function() {
                                    window.location.href = that.attr('contrat');
                                })
                                // setInterval(() => {
                                //     window.location.href = "{{route('prospect.index')}}";
                                    
                                // }, 5);
                        },
                        error: function(data) {
                            console.log(data);
                            
                            swal(
                                'Echec',
                                'Le prospect n\'a pas été activé :)',
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
                    'Le prospect n\'a pas été activé :)',
                    'error'
                    )
                }
            })
         })
    })
</script>


@endsection
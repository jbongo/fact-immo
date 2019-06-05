@extends('layouts.app')
@section('content')
    @section ('page_title')
    Ajouter une offre
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
            <a href="{{route('offre.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle offre')</a>
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont">
                                <div class="panel-heading">Listes des offres</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('Offre')</th>
                                        <th>@lang('Désignation')</th>
                                        <th>@lang('Numéro Mandat')</th>
                                        <th>@lang('Net Vendeur')</th>
                                        <th>@lang('Date exacte de vente')</th>
                                        <th>@lang('Partage avec Agent/Agence')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offres as $offre)
                                    <tr>

                                        <td>
                                        {{$offre->type_offre}}
                                        </td>
                                        <td >
                                        <strong>{{$offre->designation}}</strong> 
                                        </td>
                                        <td style="color: #e05555;">
                                            <strong> {{$offre->numero_mandat}}</strong> 
                                        </td>
                                        <td>
                                            {{$offre->net_vendeur}}   
                                        </td>
                                        <td>
                                        {{$offre->date_mandat}}   
                                        </td>
                                        <td>
                                            @php($color = "danger")

                                            @if($offre->est_partage_agent == 0)
                                                <span class="badge badge-danger">Non</span>
                                            @else
                                                <span class="badge badge-success">Oui</span>
                                            @endif

                                        </td>                                        
                                      
                                        <td>
                                            <span><a href="{{route('offre.show',Crypt::encrypt($offre->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> </span>
                                            <span><a href="{{route('offre.show',Crypt::encrypt($offre->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a  href="{{route('offre.archive',[$offre->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $offre->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                        </td>
                                    </tr>
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                    </div>
                <!-- end table -->
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
            title: '@lang('Vraiment archiver cet offre  ?')',
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
                'L\'offre a bien été archivé.',
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
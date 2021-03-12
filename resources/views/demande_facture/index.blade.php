@extends('layouts.app')
@section('content')
    @section ('page_title')
    Demandes de factures
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
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont">
                                {{-- <div class="panel-heading">Listes des compromis</div> --}}
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Mandataire')</th>
                                        {{-- <th>@lang('Désignation')</th> --}}
                                        <th>@lang('Mandat')</th>
                                        <th>@lang('Net Vendeur')</th>
                                        <th>@lang('Frais agence')</th>
                                        <th>@lang('Date exacte de vente')</th>
                                        <th>@lang('Partage')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compromis as $compromi)
                                    <tr>
                                        <td >
                                           <label class="color-info"> <a href="{{route('switch_user',Crypt::encrypt($compromi->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->user->nom}}">{{$compromi->user->civilite}} {{$compromi->user->nom}} {{$compromi->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   </label> 
                                        </td>
                                        {{-- <td >
                                        <strong>{{$compromi->description_bien}}</strong> 
                                        </td> --}}
                                        <td style="color: #e05555;">
                                            <strong> {{$compromi->numero_mandat}}</strong> 
                                        </td>
                                        <td>
                                            {{number_format($compromi->net_vendeur,2,',',' ')}} €  
                                        </td>
                                        <td>
                                            {{number_format($compromi->frais_agence,2,',',' ')}} €  
                                        </td>
                                        <td>
                                        {{$compromi->date_vente->format('d/m/Y')}}   
                                        </td>
                                        <td>
                                            @php($color = "danger")

                                            @if($compromi->est_partage_agent == 0)
                                                <span class="badge badge-danger">Non</span>
                                            @else
                                                
                                                @if($compromi->getPartage() != null)
                                                <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->getPartage()->nom}}">{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                                
                                                
                                                @endif
                                               
                                            @endif

                                        </td>                                
                                        <td>
                                            <span><a href="{{route('facture.generer_facture_stylimmo', Crypt::encrypt($compromi->id) )}}" data-toggle="tooltip" title="@lang('Voir la demande  ')"><i class="large material-icons color-info">visibility</i></a> </span>
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
            title: '@lang('Vraiment archiver cet compromis  ?')',
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
                'L\'compromis a bien été archivé.',
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
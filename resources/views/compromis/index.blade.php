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
                <!-- table -->
                @if (Auth()->user()->role == "mandataire")
                    <a href="{{route('compromis.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle affaire')</a>
                @endif
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont">
                                <div class="panel-heading">Listes des affaires</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                            @if (Auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                    @endif

                                        <th>@lang('porte l\'affaire')</th>
                                        <th>@lang('Numéro Mandat')</th>
                                        <th>@lang('Description bien')</th>
                                        <th>@lang('Net Vendeur')</th>
                                        <th>@lang('Date vente')</th>
                                        <th>@lang('Partage avec Agent/Agence')</th>
                                        <th>@lang('Facture Styl')</th>

                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compromis as $compromi)
                                    <tr>
                                            @if (Auth()->user()->role == "admin")
                                        <td width="15%" >
                                        <strong>{{$compromi->user->nom}} {{$compromi->user->prenom}}</strong> 
                                        </td> 
                                        @endif
                                        <td width="15%">
                    
                                            @if($compromi->je_porte_affaire == 0)
                                                <span class="badge badge-danger">Non</span>
                                                @php  $grise = "background-color:#EDECE7"; @endphp
                                            @else
                                                <span class="badge badge-success">Oui</span>
                                            @endif

                                        </td>   
                                        <td width="15%" style="color: #e05555;{{$grise}}">
                                            <strong> {{$compromi->numero_mandat}}</strong> 
                                        </td>     
                                        <td width="20%"style="{{$grise}}" >
                                            <strong>{{$compromi->description_bien}}</strong> 
                                        </td>
                                        
                                        <td width="15%" style="{{$grise}}">
                                            {{$compromi->net_vendeur}}   
                                        </td>
                                        <td width="15%" style="{{$grise}}">
                                        {{$compromi->date_mandat}}   
                                        </td>
                                        <td width="15%">
 
                                            @if($compromi->est_partage_agent == 0)
                                                <span class="badge badge-danger">Non</span>
                                            @else
                                                <span class="badge badge-success">Oui</span>
                                            @endif

                                        </td>        
                                        <td width="15%" style="{{$grise}}">
                                            @if($compromi->je_porte_affaire == 1)
                                                @if($compromi->demande_facture == 0)
                                                    <span><a class="btn btn-default" href="{{route('facture.demander_facture',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang(' ddddd')">demander facture styl</a> </span>
                                                @elseif($compromi->demande_facture == 1)
                                                    <span class="color-warning">En attente..</span>                                            
                                                @else 
                                                <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                                @endif
                                            @endif
                                        </td>                                
                                      
                                        <td width="15%">
                                            <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> </span>
                                            
                                            @if (Auth()->user()->role == "mandataire")
                                                <span><a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Modifier ') "><i class="large material-icons color-warning">edit</i></a></span>
                                                <span><a  href="{{route('compromis.archive',[$compromi->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $compromi->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                            @endif
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
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
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont">
                                <div class="panel-heading">Liste des mandataires</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example3" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('Nom')</th>
                                        <th>@lang('Statut')</th>
                                        <th>@lang('Email')</th>
                                        <th>@lang('Téléphone')</th>
                                        {{-- <th>@lang('Adresse')</th> --}}
                                        <th>@lang('Ville')</th>
                                        <th>@lang('date anniv')</th>
                                        <th>@lang('Comm')</th>
                                        <th>@lang('CA HT en cours')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($mandataires as $mandataire)
                                    <tr>
                                        
                                        <td>
                                            <a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}">{{$mandataire->nom}} {{$mandataire->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                        </td>
                                        <td>
                                        {{$mandataire->statut}} 
                                        </td>
                                        <td style="color: #32ade1; text-decoration: underline;">
                                        <strong>{{$mandataire->email}}</strong> 
                                        </td>
                                        <td style="color: #e05555;; text-decoration: underline;">
                                            <strong> {{$mandataire->telephone1}} </strong> 
                                        </td>
                                        {{-- <td>
                                            {{$mandataire->adresse}} 
                                        </td> --}}
                                        <td>
                                            {{$mandataire->ville}}   
                                        </td>        
                                        <td>
                                            {{$mandataire->date_anniv()}}   
                                        </td>                                  
                                        <td @if($mandataire->contrat== null) style="background:#757575; color:white" @endif>                                             
                                            <span class="color-success" >@if($mandataire->contrat!= null) {{$mandataire->commission}} % @else Pas de contrat @endif</span>
                                        </td>
                                        <td>                                             
                                            <span class="color-warning">{{number_format($mandataire->chiffre_affaire_styl($mandataire->date_anniv(), date('Y-m-d')),2,'.',' ')}} €</span>
                                        </td>
                                        <td width="13%">
                                            <span><a href="{{route('mandataire.show',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $mandataire->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                            <span><a href="{{route('mandataire.edit',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $mandataire->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                            {{-- <span><a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}"><i class="large material-icons color-success">person_pin</i></a></span> --}}
                                            
                                        <span><a  href="{{route('mandataire.archive',[$mandataire->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $mandataire->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
            $('body').on('click','a.delete',function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

        swalWithBootstrapButtons({
            title: '@lang('Vraiment archiver cet mandataire  ?')',
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
                'L\'mandataire a bien été archivé.',
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
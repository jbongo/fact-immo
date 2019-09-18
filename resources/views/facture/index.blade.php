@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures stylimmo
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
            <a href="{{route('facture.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle facture')</a>
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont">
                                <div class="panel-heading">Listes des factures</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('Num Facture')</th>
                                        <th>@lang('Mandat')</th>
                                        <th>@lang('Année')</th>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Mandataire')</th>
                                        <th>@lang('Montant TTC')</th>
                                        <th>@lang('Montant HT')</th>
                                        <th>@lang('%')</th>
                                        <th>@lang('Date de règlement Com Styl en Banque')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($factures as $facture)
                                    <tr>

                                        <td>
                                        {{$facture->nom}} {{$facture->prenom}}
                                        </td>
                                        <td style="color: #32ade1; text-decoration: underline;">
                                        <strong>{{$facture->email}}</strong> 
                                        </td>
                                        <td style="color: #e05555;; text-decoration: underline;">
                                            <strong> {{$facture->telephone}}</strong> 
                                        </td>
                                        <td>
                                        {{$facture->ville}}   
                                        </td>
                                        <td>
                                        {{$facture->adresse}} 
                                        </td>                                        
                                        <td>
                                           
                                                @php($color = "danger")
                                            
                                        <span class="badge badge-{{$color}}">{{$facture->role}}</span>
                                          
                                        </td>
                                        <td>
                                            <span><a href="{{route('facture.show',$facture->id)}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $facture->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                            <span><a href="{{route('facture.edit',$facture->id)}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $facture->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
        
                                        <span><a  href="{{route('facture.archive',[$facture->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $facture->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
            title: '@lang('Vraiment archiver cet facture  ?')',
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
                'L\'facture a bien été archivé.',
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
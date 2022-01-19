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
            <a href="{{route('fournisseur.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un fournisseur')</a>
            <a href="{{route('passerelles.index')}}" class="btn btn-warning btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-direction"></i>@lang('Passerelles')</a>
                
                <div class="card-body">
                        <div class="panel m-t-15" id="cont" >
                                <div class="panel-heading">Listes des fournisseurs</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr  style="background-color: #2a596d;">
                                        <th style=" color:#fff">@lang('Nom')</th>
                                        <th style=" color:#fff">@lang('Type')</th>
                                        <th style=" color:#fff">@lang('Téléphone')</th>
                                        <th style=" color:#fff">@lang('Site web')</th>
                                        <th style=" color:#fff">@lang('Email')</th>
                                        <th style=" color:#fff">@lang('Login')</th>
                                        <th style=" color:#fff">@lang('Mot de passe')</th>
                                        <th style=" color:#fff">@lang('Action')</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($fournisseurs as $fournisseur)
                                    <tr>

                                        <td style="color: #e05555; text-decoration: underline;">
                                        <strong>{{$fournisseur->nom}}</strong> 
                                        </td>
                                        <td style="color: #32ade1;">
                                             {{$fournisseur->type}}  
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$fournisseur->telephone}}
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$fournisseur->site_web}}
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$fournisseur->email}}
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$fournisseur->login}}
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$fournisseur->password}}
                                        </td>
                                     
                                     
                                                                         
                                
                                        <td>
                                            <span><a href="{{route('fournisseur.show',Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Afficher ') {{ $fournisseur->nom }}"><i class="large material-icons color-success">remove_red_eye</i></a></span>
                                            {{-- <span><a class="btn btn-default" href="{{route('article.index', Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Voir les annonces ') "><i class="large material-icons color-warning">remove_red_eye</i>Articles</a></span> --}}
                                            <span><a href="{{route('fournisseur.edit',Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $fournisseur->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                        <span><a  href="{{route('fournisseur.edit',$fournisseur->id)}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $fournisseur->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
@extends('layouts.app')
@section('content')
    @section ('page_title')
    Articles / Abonnement Chez {{$fournisseur->nom}}
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
                <div class="col-lg-12">
                    <a href="{{route('fournisseur.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des fournisseurs')</a> <br>
                 </div>
                <!-- table -->
            <a href="{{route('article.create', Crypt::encrypt($fournisseur->id))}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un article')</a>
                
                <div class="card-body">
                        <div class="panel panel-warning m-t-15" id="cont" >
                                <div class="panel-heading">Listes des articles</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                
                                    <tr>
                                        <th>@lang('libelle')</th>
                                        <th>@lang('description')</th>
                                        <th>@lang('quantite')</th>
                                        <th>@lang('prix d\'achat')</th>
                                        <th>@lang('coefficient')</th>
                                        <th>@lang('expiration')</th>
                                        <th>@lang('date_achat')</th>
                                        <th>@lang('action')</th>

                                    </tr>
                                </thead>
                                <tbody>
                   
                                @foreach ($articles as $article)
                                    <tr>

                                        <td style="color: #e05555; ">
                                        <strong>{{$article->libelle}}</strong> 
                                        </td>
                                        <td style="color: #32ade1;">
                                            <strong>{{$article->description}}</strong> 
                                            </td>
                                        <td style="color: #32ade1;">
                                             {{$article->quantite}}  
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$article->prix_achat}}
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$article->coefficient}}
                                        </td>
                                        <td >
                                           @if ($article->a_expire == true) <span style="color: #e05555;">Oui </span>   @else  <span style="color: #32ade1;">Non </span>    @endif
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$article->date_achat->format('d/m/yy')}}
                                        </td>
                                        
                                     
                                     
                                                                         
                                
                                        <td>
                                            <span><a href="{{route('article.edit',Crypt::encrypt($article->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $article->description }}"><i class="large material-icons color-warning">edit</i></a></span>
                                        <span><a  href="{{route('article.edit',$article->id)}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $article->description }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
            title: '@lang('Vraiment archiver cet article  ?')',
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
                'L\'article a bien été archivé.',
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
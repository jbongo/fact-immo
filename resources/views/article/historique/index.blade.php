@extends('layouts.app')
@section('content')
    @section ('page_title')
    Historique de l'article  << {{$article->libelle}} >>
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
                    <a href="{{route('article.index', Crypt::encrypt($article->fournisseur->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des articles')</a> <br>
                 </div>
                <!-- table -->
                <br><br>
                <br><br>
            {{-- <a href="{{route('article.create', Crypt::encrypt($article->id))}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un article')</a> --}}
                
                <div class="card-body">
                        <div class="panel panel-warning m-t-15" id="cont" >
                                <div class="panel-heading">Listes des articles</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                
                                    <tr>
                                        <th>libelle</th>
                                        <th>description</th>
                                        <th>quantite</th>
                                        <th>prix d\'achat</th>
                                        <th>coefficient</th>
                                        <th>expiration</th>
                                        <th>date d\'achat</th>
                                        <th>date d\'expiration</th>
                                        <th>date de modification</th>
                                        <th>action</th>

                                    </tr>
                                </thead>
                                <tbody>
                   
                                @foreach ($articles as $arti)
                                    <tr>

                                        <td style="color: #e05555; ">
                                        <span @if($arti->modif_libelle == true ) style="background:#eea" @endif >{{$arti->libelle}}</span> 
                                        </td>
                                        <td style="color: #32ade1;">
                                            <span @if($arti->modif_description == true ) style="background:#eea" @endif >{{$arti->description}}</span> 
                                            </td>
                                        <td style="color: #32ade1;">
                                              <span @if($arti->modif_quantite == true ) style="background:#eea" @endif > {{$arti->quantite}} </span> 
                                        </td>
                                        <td style="color: #32ade1;">
                                             <span @if($arti->modif_prix_achat == true ) style="background:#eea" @endif > {{$arti->prix_achat}}</span>
                                        </td>
                                        <td style="color: #32ade1;">
                                             <span @if($arti->modif_coefficient == true ) style="background:#eea" @endif > {{$arti->coefficient}}</span>
                                        </td>
                                        <td >
                                            <span @if($arti->modif_a_expire == true ) style="background:#eea" @endif >  @if ($arti->a_expire == true) <span style="color: #e05555;">Oui </span>   @else  <span style="color: #32ade1;">Non </span>    @endif </span>
                                        </td>
                                        <td style="color: #32ade1;">
                                            <span @if($arti->modif_date_achat == true ) style="background:#eea" @endif > {{$arti->date_achat->format('d/m/Y')}}</span>
                                        </td>
                                        <td style="color: #e1323e;">
                                           <span @if($arti->modif_date_expiration == true ) style="background:#eea" @endif > @if($arti->date_expiration!= null)  {{$arti->date_expiration->format('d/m/Y')}} @endif</span>
                                        </td>
                                        <td style=" color: #800a14;">
                                           <span>  @if($arti->created_at!= null)  {{$arti->created_at->format('d/m/Y')}} @endif</span>
                                        </td>            
                                
                                        <td>
                                            {{-- <span><a href="{{route('article.historique.show',Crypt::encrypt($article->id))}}" data-toggle="tooltip" title="@lang('voir l\'article' ) "><i class="large material-icons color-warning">visibility</i></a></span> --}}
                                        </td>
                                    </tr>
                            @endforeach
                            
                            <tr style="background: #eebbff">

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
                                    {{$article->date_achat->format('d/m/Y')}}
                                </td>
                                <td style="color: #e1323e;">
                                   @if($article->date_expiration!= null)  {{$article->date_expiration->format('d/m/Y')}} @endif
                                </td>
                                <td style="background:#bdbdbd; color: #800a14;">
                                    
                                 </td>
                             
                             
                                                                 
                        
                                <td>
                                    <span><a href="{{route('article.edit',Crypt::encrypt($article->id))}}" data-toggle="tooltip" title="@lang('voir l\'article' ) "><i class="large material-icons color-danger">visibility</i></a></span>
                                </td>
                            </tr>
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
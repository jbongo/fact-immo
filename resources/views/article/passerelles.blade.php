@extends('layouts.app')
@section('content')
    @section ('page_title')
   passerelles
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
                    <a href="{{route('fournisseur.index')}}" class="btn btn-warning btn-flat btn-addon m-b-30 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des fournisseurs')</a> 
                 </div>
                <!-- table -->
                <br><br><br>
                

                <div class="card-body">
                        <div class="panel panel-defaukt m-t-15" id="cont" >
                            
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                
                                    <tr style="background-color: #2a596d;">
                                        <th   style=" color:#fff">Fournisseur</th>
                                        <th   style=" color:#fff">Quantité</th>
                                        <th   style=" color:#fff">Prix d'achat</th>
                                        <th   style=" color:#fff">Date d'achat</th>
                                        <th   style=" color:#fff">Fin de contrat</th>
                                        <th   style=" color:#fff">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                   
                                @foreach ($articles as $article)
                                    <tr>
                                        <td style="color: #450854; ">
                                            <strong>{{$article->fournisseur->nom}}</strong> 
                                        </td>
                                      
                                        <td style="font-weight: bold;">
                                            <span style="color: #450854; " >{{$article->quantite - $annonces_consommee}}</span>  /  <span style="color: #a50707;"> {{$article->quantite}}  </span>
                                        </td>
                                        <td style="color: #32ade1;">
                                            {{$article->prix_achat}}
                                        </td>
                                                                              
                                        <td style="color: #32ade1;">
                                            @if($article->date_achat!= null)  {{$article->date_achat->format('d/m/Y')}} @endif
                                        </td>
                                        <td style="color: #e1323e;">
                                            @if($article->date_expiration!= null)  {{$article->date_expiration->format('d/m/Y')}} @endif
                                        </td>
                                        
                                        <td>
                                            <span><a href="{{route('article.edit',Crypt::encrypt($article->id))}}" data-toggle="tooltip"  title="@lang('Modifier ') {{ $article->libelle }}"><i class="large material-icons color-warning">edit</i></a></span>
                                            <span><a href="" data-href="{{route('article.edit',$article->id)}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $article->libelle }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                            <span><a href="{{route('article.historique', Crypt::encrypt($article->id))}}" data-toggle="tooltip" target="_blank" title="@lang('Voir l\'historique ') "><i class="large material-icons color-success">history</i>  </a></span>
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
                        url: that.attr('data-href'),
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
                'L\'article n\'a pas été archivé :)',
                'error'
                )
            }
        })
            })
        })
    </script>
@endsection
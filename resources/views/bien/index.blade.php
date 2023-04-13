@extends('layouts.app')
@section('content')
@section ('page_title')
Biens
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
            <a href="{{route('bien.add')}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-home"></i>@lang('Ajouter un bien')</a>
                
                <div class="card-body">
                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('#')</th>                                        
                                        <th>@lang('')</th>                
                                        <th>@lang('')</th>                
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($biens as $bien)
                                    <tr>
                                        <td width="20%">

                                        @foreach($bien->photosbiens as $photos)
                                            @if($photos->visibilite == "visible" && $photos->image_position == 1)
                                                <img src="{{asset("images/photos_bien/".$photos->filename)}}" width="200px" height="150px" alt="">  
                                                @break
                                            @endif
                                        @endforeach
                                       

                                        </td>
                                        <td  width="60%">
                                       
                                            <h4>
                                                <b> {{$bien->type_bien}}</b>  
                                                @if($bien->type_bien != "terrain")
                                                - {{$bien->nombre_piece}} @lang('pièces') 
                                                @endif
                                                - {{$bien->surface_habitable}} @lang('m²')
                                            </h4>
                                            
                                            <h5> {{$bien->ville}} ({{$bien->code_postal}})</h5><br><br>
                                            <h6> {{$bien->titre_annonce}}</h6>
                                        </td>
                                                        
                                        <td>
                                            @if($bien->type_offre == "vente")
                                            <h4><b> <span style="color:blue">{{$bien->prix_public}} @lang('€')</b> </span> </h4>
                                            @else
                                            <h4><b> <span style="color:blue">{{$bien->loyer}} @lang('€')</b> </span> </h4>
                                            @endif
                                            <h6>@lang('Ajouté le '){{$bien->created_at->format("d-m-y")}} </h6>
                                            </h5>
                                            <h6>
                                                @if(isset($bien->biendetail->dossier_dispo_numero))
                                                    @lang('Dossier n° '){{$bien->biendetail->dossier_dispo_numero}} 
                                                @else
                                                @lang('Pas de n° de dossier ')
                                                @endif
                                            </h6>

                                        </td>
                                        <td>
                                            @php
                                                 $bien_id = Crypt::encrypt($bien->id);
                                            @endphp
                                            <span><a href="{{route('bien.show',$bien_id)}}" title="@lang('Détails') {{ $bien->nom }}">
                                            <img src="{{asset("images/fleche-direction.png")}}" width="50px" height="55px" alt="">  

                                            </a> </span>
        
                                        </td>
                                    </tr>
                            @endforeach
                              </tbody>
                            </table>
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
            title: '@lang('Vraiment archiver cet utilisateur  ?')',
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
                'L\'utilisateur a bien été archivé.',
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
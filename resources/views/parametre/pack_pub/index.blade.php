@extends('layouts.app')
@section('content')
    @section ('page_title')
    Publicité
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
            <a href="{{route('pack_pub.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Ajouter un pack pub')</a>
                
                <div class="card-body">
                        <div class="panel panel-info m-t-15" id="cont" >
                                <div class="panel-heading">Listes des packs pub</div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('Nom Pack')</th>
                                        <th>@lang('Quantité annonce ')</th>
                                        <th>@lang('Tarif HT')</th>
                                        <th>@lang('Tarif TTC')</th>
                                        <th>@lang('Type du pack')</th>
                                        <th>@lang('Archivé')</th>                                        
                                        <th>@lang('Action')</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($packs as $pack)
                                    <tr>

                                        <td style="color: #32ade1; ">
                                        <strong>{{$pack->nom}}</strong> 
                                        </td>
                                        <td style="color: #33460c;">
                                            <strong>{{$pack->qte_annonce}}</strong> 
                                        </td>
                                        <td style="color: #e05555;;">
                                            <strong> {{$pack->tarif_ht}} €</strong> 
                                        </td>
                                        <td style="color: #e05555;;">
                                            <strong> {{$pack->tarif}} €</strong> 
                                        </td>
                                        
                                        <td style="color: #3811c7;;">
                                            <strong> {{$pack->type}} </strong> 
                                        </td>
                                        
                                        <td>
                                            @if($pack->archive == true)
                                            <span class="badge badge-success">Oui</span>
                                            @else 
                                            <span class="badge badge-danger">Non</span>
                                            
                                            @endif
                                         </td>                       
                                
                                        <td>
                                            <span><a href="{{route('pack_pub.edit',Crypt::encrypt($pack->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $pack->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                            @if($pack->archive == true)
                                                <span><a  style="cursor: pointer;" data-href="{{route('pack_pub.archiver',[$pack->id, 2])}}" class="desarchive" data-toggle="tooltip" title="@lang('Désarchiver ') {{ $pack->nom }}"><i class="large material-icons color-success">settings_backup_restore</i> </a></span>
                                            @else 
                                                <span><a style="cursor: pointer;"  data-href="{{route('pack_pub.archiver',$pack->id)}}" class="archive" data-toggle="tooltip" title="@lang('Archiver ') {{ $pack->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
        // ################ Archiver un pack ################ 

        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('a.archive').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })
    
            swalWithBootstrapButtons({
                title: '@lang('Vraiment archiver cet pack_pub  ?')',
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
                            type: 'GET',
                            success: function (result) {
                                swal(
                                     'Archivé',
                                     'Pack archivé ',
                                     'success'
                                  )
                                  .then(function() {
                                           window.location.href = "{{route('pack_pub.index')}}";
                                    })
                               },
                            error: function(error){
                                  console.log(error);
                                  
                                  swal(
                                           'Echec',
                                           'Vous avez une erreur '+error,
                                           'error'
                                        )
                                        
                                  
                               }
                        })
    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Le Pack n\'a pas été archivé :)',
                    'error'
                    )
                }
            })
            })
        })
        
        
        
        
        // ################ Désarchiver un pack ################ 
        
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('a.desarchive').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })
    
            swalWithBootstrapButtons({
                title: '@lang('Vraiment désarchiver cet pack_pub  ?')',
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
                            type: 'GET',
                            success: function (result) {
                                swal(
                                     'Désarchivé',
                                     'Pack désarchivé ',
                                     'success'
                                  )
                                  .then(function() {
                                           window.location.href = "{{route('pack_pub.index')}}";
                                    })
                               },
                            error: function(error){
                                  console.log(error);
                                  
                                  swal(
                                           'Echec',
                                           'Vous avez une erreur '+error,
                                           'error'
                                        )
                                        
                                  
                               }
                        })
    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Le Pack n\'a pas été désarchivé :)',
                    'error'
                    )
                }
            })
            })
        })
    </script>
@endsection
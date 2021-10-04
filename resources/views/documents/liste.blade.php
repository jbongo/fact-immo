@extends('layouts.app')
@section('content')
    @section ('page_title')
    Liste des documents à fournir par les mandataires
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
                <a href="{{route('document.create')}}" class="btn btn-warning btn-rounded btn-addon btn-lg m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Créer un nouveau document')</a>

              
            
                
            <div class="card-body">
                <div class="panel panel-info m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example00" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Nom')</th>
                                <th>@lang('Référence')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Date d\'expiration')</th>
                                <th>@lang('Suppression après démission')</th>
                
                               
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($documents as $document)
                        
                            <tr>
                                
                               
                                <td>
                                    {{$document->nom}} 
                                </td>
                                <td>
                                    {{$document->reference}} 
                                </td>
                                <td>
                                    {{$document->description}}
                                </td>
                                
                      
                                <td>
                                    @if($document->a_date_expiration == true)
                                    <span class="badge badge-success">Oui</span>
                                    @else 
                                    <span class="badge badge-danger">Non</span>
                                    
                                    @endif
                                 </td> 
                                 
                                 <td>
                                    @if($document->supprime_si_demissionne== true)
                                    <span class="badge badge-success">Oui</span>
                                    @else 
                                    <span class="badge badge-danger">Non</span>
                                    
                                    @endif
                                 </td> 
                                
                             
                                <td width="15%">
                                    {{-- <span><a href="{{route('document.show',Crypt::encrypt($document->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $document->nom }}"><i class="large material-icons color-info">visibility</i></a> </span> --}}
                                    <span><a href="{{route('document.edit',Crypt::encrypt($document->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $document->nom }}"><i class="large material-icons color-warning">edit</i></a></span>                                    
                                    <span><a  href="{{route('document.archiver',$document->id)}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $document->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                </td>
                            </tr>
                            
  
                            
                            
                    @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>

            </div>


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
        
        
        $('body').on('click','a.archiver',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({   
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
                 })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment archiver cet document  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        
                        
        
                    $.ajax({
                        type: "GET",
                        // url: "{{route('document.create')}}",
                        url: that.attr('href'),
                       
                        // data: data,
                        success: function(data) {
                            
                            swal(
                                    'Archivé',
                                    'Le document a été archivé \n ',
                                    'success'
                                )
                                
                            
                              
                        },
                        error: function(data) {
                            console.log(data);
                            
                            swal(
                                'Echec',
                                'Le document n\'a pas été archivé :)',
                                'error'
                            );
                        }
                    })
                    .done(function () {
                               that.parents('tr').remove()
                            })
                    ;
                    
                  
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Le document n\'a pas été archivé :)',
                    'error'
                    )
                }
            })
         })
    })
</script>


@endsection
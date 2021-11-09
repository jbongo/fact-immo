@extends('layouts.app')
@section('content')
    @section ('page_title')
    Historique des Documents  de | {{$mandataire->prenom}} {{$mandataire->nom}}
    @endsection
    
    
<style>

.btn-addon i {
    background: rgba(218, 228, 233, 0);
  
}
</style>
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
                @if(Auth::user()->role == "admin")
                <a href="{{route('document.show', Crypt::encrypt($mandataire->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a>
                @endif
              
            <div class="card-body">
                <div class="panel panel-default m-t-15" id="cont">
                    <div class="panel-heading"></div>
                        <div class="panel-body">
                        
                      
                    
                            <div class="table-responsive" style="overflow-x: inherit !important;">
                                <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('Nom du document')</th>
                                            <th>@lang('Date de modification')</th>
                                            <th>@lang('Date d\'expiration du document')</th>
                                            <th>@lang('Document')</th>
                                    
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                 
                                    <form action="{{route('document.save_doc', $mandataire->id)}}" method="POST" enctype="multipart/form-data">
                        
                                        @csrf
                                        
                                        @foreach ( $historiqueDocuments as $historique )
                                        <tr>
                                            
                                            
                                            <td><label class="col-lg-4 col-md-4 col-sm-4 control-label" for="{{$historique->document()->reference}}">{{$historique->document()->nom}}</label></td>
                                            <td> <label class="text-danger "><small> <i> * Modifié le {{$historique->created_at->format('d/m/Y')}} </i>  </small></label></td>
                                            <td>   
                                                @if ($historique->document()->a_date_expiration == true)
                                                    <label class=" control-label"> @if($historique->date_expiration != null ) {{$historique->date_expiration->format('d/m/Y')}} @endif</label>
                                                    <br>
                                                @endif
                                          </td>
                                            <td>
                                                @if($mandataire->document($historique->document()->id) != null)
                                                {{$historique->extension}}
                                                    <a href="{{route('document.telecharger.historique',  $historique->id)}}"data-toggle="tooltip" title="Télécharger {{$historique->document()->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>{{$historique->document()->nom}}</a> 
                                                    @else 
                                                    
                                                    <label for=""><i>Aucun document</i></label>
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
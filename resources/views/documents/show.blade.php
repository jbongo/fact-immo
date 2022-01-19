@extends('layouts.app')
@section('content')
    @section ('page_title')
    Documents | {{$mandataire->prenom}} {{$mandataire->nom}} 
    <a href="{{route('bibliotheque.index')}}" class="btn btn-default btn-rounded btn-addon btn-lg m-b-10 m-l-5" ><i class="ti-list"></i>@lang('Voir la bibliothèque')</a>
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
                <a href="{{route('document.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> <---->
                <a href="{{route('document.historique', Crypt::encrypt($mandataire->id))}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-timer"></i>@lang('Historique des docs')</a>
                @endif
              
            <div class="card-body">
                <div class="panel panel-default m-t-15" id="cont">
                    <div class="panel-heading"></div>
                        <div class="panel-body">
                        
                      
                    
                            
                            
                            <div class="row">
                            
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    
                                    <div class="row form-group ">
                                        <label class="col-lg-12 col-md-12 col-sm-12 control-label" for="">Contrat Signé + annexes</label>
                    
                                        
                                        <br>
                             
                                  </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-4" style="text-align: right">
                                    @if($mandataire->contrat != null && $mandataire->contrat->contrat_pdf != null)
                                    <a href="{{route('contrat.telecharger', Crypt::encrypt($mandataire->contrat->id))}}"data-toggle="tooltip" title="Télécharger le contrat"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>télécharger le contrat + annexes</a>
                                    @else 
                                    
                                    <label for=""><i>Aucun document</i></label>
                                    @endif
                                
                                </div>
                            </div>
                            <hr style="border-top: 3px solid #272213;">

                            
                            <br><br>
                              
                            <form action="{{route('document.save_doc', $mandataire->id)}}" method="POST" enctype="multipart/form-data">
                            
                            @csrf
                            
                            @foreach ( $documents as $document )
                                
                                <div class="row">
                                
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    
                                        <div class="row form-group ">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="{{$document->reference}}">{{$document->nom}}</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <input type="file" class="form-control" value="" id="{{$document->reference}}" name="{{$document->reference}}" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.xls" >
                                                @if ($errors->has($document->reference))
                                                  <br>
                                                  <div class="alert alert-warning ">
                                                     <strong>{{$errors->first($document->reference)}}</strong> 
                                                  </div>
                                               @endif  
                                            </div>
                                            
                                            <br>
                                            
                                            <small> <i> * {{$document->description}} </i>  </small>
                                      </div>
                                    
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        @if ($document->a_date_expiration == true)
                                    
                                        <div class="row form-group ">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_expiration_{{$document->reference}}">Date d'expiration</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <input type="date" class="form-control" value="{{$mandataire->document($document->id) != null && $mandataire->document($document->id)->date_expiration != null  ? $mandataire->document($document->id)->date_expiration->format("Y-m-d")  : null }}" id="date_expiration_{{$document->reference}}" name="date_expiration_{{$document->reference}}" accept=".pdf" >
                                                @if ($errors->has("date_expiration_".$document->reference))
                                                  <br>
                                                  <div class="alert alert-warning ">
                                                     <strong>{{$errors->first("date_expiration_".$document->reference)}}</strong> 
                                                  </div>
                                               @endif  
                                            </div>
                                            
                                            <br>
                              
                                      </div>
                                      @endif
                                    </div>
                                   
                                    
                                    
                                    <div class="col-lg-4 col-md-4 col-sm-4" style="text-align: right">
                                        @if($mandataire->document($document->id) != null)
                                        
                                            @if($mandataire->document($document->id)->valide < 2)
                                            
                                                {{$mandataire->document($document->id)->extension }}
                                                
                                                
                                                @if($mandataire->document($document->id)->est_image())
                                                
                                                <a href="{{$mandataire->document($document->id)->lien_public_image()}}" data-toggle="tooltip" target="_blank" title="Télécharger {{$document->nom}}"  class="btn btn-success btn-flat btn-addon "><i class="ti-download"></i>{{$document->nom}}</a> 
                                                @else 
                                                
                                                <a href="{{route('document.telecharger', [$mandataire->id, $document->id])}}"data-toggle="tooltip" title="Télécharger {{$document->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>{{$document->nom}}</a> 
                                                
                                                @endif
                                                
                                              <br>  @if($mandataire->document($document->id)->valide == 0)  <label for="" class="text-success"><i>Document en attente de validation</i></label> @endif
                                                
                                            @elseif($mandataire->document($document->id)->valide == 2)
                                                <label for="" class="text-danger"><i>Document refusé</i></label> <br>
                                                <small> * Motif: <i> {{$mandataire->document($document->id)->motif_refu}} </i>  </small>
                                                
                                            @endif
                                        @else 
                                        
                                        <label for=""><i>Aucun document</i></label>
                                        @endif
                                    
                                    </div>
                                
                                </div>
                                
                                <hr style="border-top: 3px solid #272213;">
                            @endforeach
                            
                         
                                <div class="row">
                                    <div class="col lg-12 col-md-12">
                                    <button class="btn btn-success btn-rounded btn-addon btn-lg m-b-10 m-l-5"><i class="ti-save"></i>Enregistrer</button>
                                    </div>
                                </div>
                            
                            </form>
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
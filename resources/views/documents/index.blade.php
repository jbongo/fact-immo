@extends('layouts.app')
@section('content')
    @section ('page_title')
    Documents mandataires
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
            <a href="{{route('document.liste')}}" class="btn btn-default btn-rounded btn-addon btn-lg m-b-10 m-l-5" target="_blank"><i class="ti-list"></i>@lang('Liste des documents à fournir')</a>
            <a href="{{route('bibliotheque.index')}}" class="btn btn-default btn-rounded btn-addon btn-lg m-b-10 m-l-5" ><i class="ti-list"></i>@lang('Voir la bibliothèque')</a>
              
              <br><br>
            
                
            <div class="card-body">
                <div class="panel panel-danger m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Mandataire')</th>
                                <th>@lang('Contrat')</th>
                                
                                @foreach ($documents as $document)
                                
                                <th>{{$document->nom}}</th>
                                    
                                @endforeach
                                
                        
                               
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($mandataires as $mandataire)
                        
                            @if($mandataire->contrat != null && $mandataire->contrat->est_fin_droit_suite == false )
                            <tr>
                                
                               
                                <td>
                                    {{$mandataire->nom}}  {{$mandataire->prenom}}   
                                </td>
                                <td>
                                    @if($mandataire->contrat != null && $mandataire->contrat->contrat_pdf != null)
                                        <a href="{{route('contrat.telecharger', Crypt::encrypt($mandataire->contrat->id))}}"data-toggle="tooltip" title="Télécharger le contrat + annexes"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>Voir</a> 
                                    @endif
                                </td>
                                
                                @foreach ($documents as $document)
                                
                                <td>
                                    @if($mandataire->document($document->reference) != null && $mandataire->document($document->reference)->valide == 1)
                                         
                                        
                                        @if($mandataire->document($document->id)->expire == 0)                                            
                                            <a href="{{$mandataire->document($document->id)->lien_public_image()}}" data-toggle="tooltip" target="_blank" title="Télécharger {{$document->nom}}"  class="btn btn-success btn-flat btn-addon "><i class="ti-download"></i>{{$document->nom}}</a> 
                                        @else                                        
                                            <a href="{{route('document.telecharger', [$mandataire->id, $document->reference])}}" data-toggle="tooltip" title="Télécharger {{$document->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>Expiré</a>
                                        @endif
                                        
                                    @endif
                                </td>
                                    
                                @endforeach
                                
                                
                          
                                
                                
                                

                                <td width="15%">
                                    <span><a href="{{route('document.show',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" target="_blank" title="@lang('Détails de ') {{ $mandataire->nom }}"><i class="large material-icons color-info">visibility</i> Voir les documents</a>  </span>

                                </td>
                            </tr>
                            
                            @endif
  
                            
                            
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
   
</script>


@endsection
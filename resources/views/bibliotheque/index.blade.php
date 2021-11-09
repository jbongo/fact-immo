@extends('layouts.app')
@section('content')
    @section ('page_title')
    Bibliothèque
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
            <a href="{{route('bibliotheque.create')}}" class="btn btn-default btn-rounded btn-addon btn-lg m-b-10 m-l-5" ><i class="ti-plus"></i>Ajouter un document</a>
              
              <br><br>
            
                
            <div class="card-body">
                <div class="panel panel-danger m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Nom document')</th>
                                <th>@lang('référence')</th>
                                <th>@lang('description')</th>
                                <th>date d'expiration</th>
                                
                             
                        
                               
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
                                   @if($document->date_expiration != null)  {{$document->date_expiration->format('d/m/Y')}} @endif 
                                </td>
                                
                              

                                <td width="15%">
                                    @if($document->reference != null)
                                        <a href="{{route('bibliotheque.telecharger', $document->id)}}" data-toggle="tooltip" title="Télécharger {{$document->nom}}"  class="btn btn-default btn-flat btn-addon "><i class="ti-download"></i>Voir</a>    
                                    @endif
                                    <span><a  href="{{route('bibliotheque.edit',$document->id)}}" class="delete" data-toggle="tooltip" title="@lang('Modifier ') {{ $document->nom }}"><i class="large material-icons color-success">edit</i> </a></span>
                                    <span><a  href="{{route('bibliotheque.delete',$document->id)}}" class="delete" data-toggle="tooltip" title="@lang('Supprimer ') {{ $document->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                    
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
   
</script>


@endsection
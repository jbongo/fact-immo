@extends('layouts.app')
@section('content')
    @section ('page_title')
    Liste des codes analytiques et clients
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
                <a href="{{route('winfic.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a>
              
            <div class="row">
              
                    <!-- Content -->
                    <div class=" col-lg-8 col-md-8 col-sm-8">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                               
                               
                               
                               
                
                <div class="card-body">
                    <div class="panel panel-info m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="example" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                            <thead>
                                <tr>
                                    <th>@lang('Nom')</th>
                                    <th>@lang('Code client')</th>
                                    <th>@lang('Code analytique')</th>
                                   
                                 
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mandataires as $mandataire)
                            
                            @if(($mandataire->contrat != null && $mandataire->contrat->a_demission == false && $mandataire->contrat->est_fin_droit_suite == false) ) 
                                <tr>
                                    
                                    <td>
                                        <a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}">{{$mandataire->nom}} {{$mandataire->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                    </td>
                                  
                                    
                                
                                    <td style="color: #e05555;; text-decoration: underline;">
                                        <strong> {{$mandataire->code_client}} </strong> 
                                    </td>
                                    <td style="color: #e05555;; text-decoration: underline;">
                                        <strong> {{$mandataire->code_analytic}} </strong> 
                                    </td>
                                   
                                    <td width="13%">
                                        <span><a href="{{route('mandataire.show',Crypt::encrypt($mandataire->id) )}}" target="_blank" data-toggle="tooltip" title="@lang('Détails de ') {{ $mandataire->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                        <span><a href="{{route('mandataire.edit',Crypt::encrypt($mandataire->id) )}}" target="_blank" data-toggle="tooltip" title="@lang('Modifier ') {{ $mandataire->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                                        {{-- <span><a href="{{route('switch_user',Crypt::encrypt($mandataire->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $mandataire->nom }}"><i class="large material-icons color-success">person_pin</i></a></span> --}}
                                        
                                    {{-- <span><a  href="{{route('mandataire.archive',[$mandataire->id,1])}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $mandataire->nom }}"><i class="large material-icons color-danger">delete</i> </a></span> --}}
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




               </div>
         </div>
      </div>
    </div>
@endsection


@section('js-content')




@endsection
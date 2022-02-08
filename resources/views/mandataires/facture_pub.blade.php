@extends('layouts.app')
@section('content')
    @section ('page_title')
    Gestions des Factures pub
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
            @if (Auth()->user()->role == "admin")
				<a href="{{route('mandataire.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> 

            @endif
            <br>
            
                <!-- table -->
                

                <div class="row"> 
       
                    <div class="col-lg-12">
                           
                        <div class="card alert">
                            <!-- table -->
                          
                            
							<div class="row"> 
	   
								<div class="col-lg-12">
										 
									<div class="card alert">
										<!-- table -->
								@php $grise =""@endphp
										
                                <div class="card-body">
                                    <div class="panel panel-info m-t-15" id="cont">
                                            <div class="panel-heading"></div>
                                            <div class="panel-body">
            
                                    <div class="table-responsive" style="overflow-x: inherit !important;">
                                        <table  id="example00" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Nom')</th>                                               
                                                    <th>@lang('Statuts pub')</th>                                                  
                                                    <th>@lang('Facts en attente de payement')</th>
                                               
                                                   
                                                  
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($contrats as $contrat)
                                            
                                            @if(($contrat != null ) ) 
                                                <tr>
                                                    
                                                    <td>
                                                        <a href="{{route('switch_user',Crypt::encrypt($contrat->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $contrat->user->nom }}">{{$contrat->user->nom}} {{$contrat->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                                    </td>
                                                    
                                                    <td>
                                                        @if($contrat->user->nb_facture_pub_retard > 0)  <span class="badge badge-danger">retard</span> @else  <span class="badge badge-success">à jour</span> @endif
                                                    </td>   

                                                   
                                                    <td>
                                                       <span style="color:#32ade1; font-size:18px"> {{$contrat->user->nb_facture_pub_retard}} </span>    
                                                    </td>   
                                               
                                                  
                                                    <td width="13%">
                                                        <span><a href="{{route('mandataire.historique_facture_pub', Crypt::encrypt($contrat->user->id))}}" data-toggle="tooltip" title="@lang('Détails des factures pub ') {{ $contrat->user->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                                       
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
    </div>
@endsection
@section('js-content')

@endsection
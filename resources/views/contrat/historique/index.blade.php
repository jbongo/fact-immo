@extends('layouts.app')
@section('content')
    @section ('page_title')
    Historique de contrat de  {{$contra->user->nom}} {{$contra->user->prenom}}
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
         
            @if(Auth::user()->role == "admin")
				<a href="{{route('contrat.edit', Crypt::encrypt($contra->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> 
			@else 
				<a href="{{route('mandataire.show', Crypt::encrypt($contra->user->id))}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> 
			
			@endif
          
            <br>
    
                

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
									<div class="panel panel-default m-t-15" id="cont">
											<div class="panel-heading"></div>
											<div class="panel-body">
							
									<div class="table-responsive" >
										<table  id="example2" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
											<thead>
												<tr>
											
													<th>@lang('Date d\'entrée')</th>
													<th>@lang('Date début activité')</th>
													<th>@lang('Pack')</th>
													<th>@lang('Pourcentage de départ')</th>
													<th>@lang('est soumis TVA')</th>
													<th>@lang('Déduis jétons')</th>
													<th>@lang('Date de modification')</th>
													<th>@lang('Action')</th>
												
												
													
												
													
							
													
							
												</tr>
											</thead>
											<tbody>
												@foreach ($contrats as $contrat)
							
												<tr>
                                                    <td><label >{{$contrat->date_entree->format('d/m/Y')}} </label> </td>
                                                    <td><label >{{$contrat->date_deb_activite->format('d/m/Y')}} </label> </td>
							
							
							
													<td  >
														<label class="color-info">{{$contrat->user->pack_actuel}} </label> 
													</td>
													
													<td><label >
													@if($contrat->user->pack_actuel == "expert")
													    {{$contrat->pourcentage_depart_expert}} 
													@else 
                                                        {{$contrat->pourcentage_depart_starter}} 
													
													@endif
													
													%</label> </td>
													
                                                    <td  >
														<label class="color-info">
														
                                                            @if($contrat->est_soumis_tva == true)
                                                                <span class="badge badge-success">Oui</span>
                                                            @else 
                                                                <span class="badge badge-danger">Non</span>
                                                            @endif
                                                        
                                                        
														</label> 
													</td>
                                                    
                                                    <td  >
														<label class="color-info">
														
                                                            @if($contrat->deduis_jeton == true)
                                                                <span class="badge badge-success">Oui</span>
                                                            @else 
                                                                <span class="badge badge-danger">Non</span>
                                                            @endif
                                                        
                                                        
														</label> 
													</td>
												
                                                    <td><label  class="color-danger">{{$contrat->created_at->format('d/m/Y')}} </label> </td>
													
													<td width="13%">
                                                        <span><a href="{{route('contrat.historique.show',Crypt::encrypt($contrat->id) )}}" data-toggle="tooltip" title="@lang('Détails ')"><i class="large material-icons color-info">visibility</i></a> </span>
                                                    </td>
												
							
											  
												</tr> 
										   
										@endforeach
										@if(Auth::user()->role == "admin")
										<tr style="background: #eebbff">
                                            <td><label >{{$contra->date_entree->format('d/m/Y')}} </label> </td>
                                            <td><label >{{$contra->date_deb_activite->format('d/m/Y')}} </label> </td>
                                        
                                        
                                        
                                            <td  >
                                                <label class="color-info">{{$contra->user->pack_actuel}} </label> 
                                            </td>
                                            
                                            <td><label >
                                            @if($contra->user->pack_actuel == "expert")
                                                {{$contra->pourcentage_depart_expert}} 
                                            @else 
                                                {{$contra->pourcentage_depart_starter}} 
                                            
                                            @endif
                                            
                                            %</label> </td>
                                            
                                            <td  >
                                                <label class="color-info">
                                                
                                                    @if($contra->est_soumis_tva == true)
                                                        <span class="badge badge-success">Oui</span>
                                                    @else 
                                                        <span class="badge badge-danger">Non</span>
                                                    @endif
                                                
                                                
                                                </label> 
                                            </td>
                                            
                                            <td  >
                                                <label class="color-info">
                                                
                                                    @if($contra->deduis_jeton == true)
                                                        <span class="badge badge-success">Oui</span>
                                                    @else 
                                                        <span class="badge badge-danger">Non</span>
                                                    @endif
                                                
                                                
                                                </label> 
                                            </td>
                                        
                                            <td><label  class="color-danger">{{$contra->updated_at->format('d/m/Y')}} </label> </td>
                                            
                                            <td width="13%">
                                                <span><a href="{{route('contrat.edit',Crypt::encrypt($contra->id) )}}" data-toggle="tooltip" title="@lang('Détails ')"><i class="large material-icons color-info">visibility</i></a> </span>
                                            </td>
                                        
                                        
                                        
                                        </tr> 
                                        @endif
										  </tbody>
										</table>
									</div>
								</div>
							</div>
							
							
							{{-- <div class="container"> --}}
							
							<!-- Trigger the modal with a button -->
							{{-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button> --}}
							
							<!-- Modal -->
							<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog modal-sm">
							
							<!-- Modal content-->
							<div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Date de règlement</h4>
							</div>
							<div class="modal-body">
							<p><form action="" id="form_regler">
									<div class="modal-body">
									  @csrf
											<div class="">
												<div class="form-group row">
													<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_reglement">Date de règlement <span class="text-danger">*</span> </label>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<input type="date"  class="form-control {{ $errors->has('date_reglement') ? ' is-invalid' : '' }}" value="{{old('date_reglement')}}" id="date_reglement" name="date_reglement" required >
														@if ($errors->has('date_reglement'))
														<br>
														<div class="alert alert-warning ">
															<strong>{{$errors->first('date_reglement')}}</strong> 
														</div>
														@endif   
													</div>
												</div>
											</div>
									  </p>
							</div>
							<div class="modal-footer">
							<input type="submit" class="btn btn-success" id="valider_reglement"  value="Valider" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
							</div>
							</form> 
							</div>
							</div>
							
							{{-- </div>               --}}
							
							
							</div>
							</div>
							<!-- end table -->
							
										<!-- end table -->
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
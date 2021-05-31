@extends('layouts.app')
@section('content')
    @section ('page_title')
    Historique des jetons de  {{$mandataire->nom}} {{$mandataire->prenom}}
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
            
            <div class="row">
				<div class="col-lg-6 col-sm-6">
					<span>Total jetons déduits : </span> <label class="color-success" style="font-size: 20px">{{$total_deduis}} </label> <br>
					<span>Total jetons restants : </span> <label class="color-danger" style="font-size: 20px">{{$total_restant}} </label> <br>
					@if($mandataire->etat_jeton()['retard'] > 0 )    <span class="badge badge-danger">retard</span> <-- ({{$mandataire->etat_jeton()['retard']}} mois de retards)-->  @else    <span class="badge badge-success">à jour</span> @endif  Sur les jetons
				</div>
				<div class="col-lg-6 col-sm-6">
					<span>Date d'anniversaire : </span> <label class="color-primary" style="font-size: 20px">{{$mandataire->date_anniv("fr")}} </label>
					@if(Auth::user()->role == "admin")
						<form action="{{route('jetons.update', Crypt::encrypt($mandataire->id))}}" method="POST">
						@csrf
						<div class="row">
							<div class="col-lg-4 col-md-4">
								<span>  Ajouter/réduire jetons : </span>
							</div>
							<div class="col-lg-2 col-md-2">
							<input type="number" min="{{$total_restant*-1}}" class="form-control col-lg-2 col-md-2" name="jetons" required>
							</div>
							
							<div class="col-lg-4 col-md-4">
								<button type="submit" class="btn btn-danger">Valider</button>
							</div>
						</div>
							
					
						
						</form>
						
						@endif
				
				</div>
			</div>
            
           
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
									<h2>Déductions des jetons sur les factures</h2>
								
									<div class="panel panel-default m-t-15" id="cont">
											<div class="panel-heading"></div>
											<div class="panel-body">
							
									<div class="table-responsive" >
										<table  id="example2" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
											<thead>
												<tr>
												   
													<th>@lang('Facture Honoraire')</th>
													{{-- <th>@lang('Facture Stylimmo')</th> --}}
											
													@if(auth()->user()->role == "admin")
													{{-- <th>@lang('Mandataire')</th> --}}
													@endif
													<th>@lang('Type Facture')</th>
													<th>@lang('Jetons déduits ')</th>
													<th>@lang('Date Déduction')</th>
												
													
												</tr>
											</thead>
											<tbody>
												@foreach ($factures as $facture)
							
												<tr>
													
							
													<td  >
														@if($facture->statut == "valide" && $facture->numero != null )
															<a class="color-info" title="Télécharger la facture d'honoraire "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> </a>                                        
														@elseif($facture->statut == "en attente de validation" && $facture->numero != null) 
															<label class="color-default"><strong> En attente de validation </strong></label> 
														@elseif($facture->statut == "refuse" && $facture->numero != null) 
															<label class="color-success"><strong>Réfusée </strong></label>
														@else
															<label class="color-danger"><strong>Non ajoutée </strong></label> 
							
														@endif 
													</td>
							
							
							
							
													{{-- <td  > --}}
														{{-- <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label>  --}}
													{{-- <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </a> --}}
														
													{{-- </td> --}}
											
													{{-- @if(auth()->user()->role == "admin")
													<td  >
														<label class="color-info">
															@if($facture->user !=null)
															<a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   
															@endif
														   
														</label> 
													</td>
													@endif --}}
													<td  >
														<label class="color-info">{{$facture->type}} </label> 
													</td>
													<td><label class="color-danger" style="font-size: 20px">{{$facture->nb_mois_deduis}} </label> </td>
													<td><label >{{$facture->created_at->format('d/m/Y')}} </label> </td>
												
													
													
												
							
											  
												</tr> 
										   
										@endforeach
										  </tbody>
										</table>
									</div>
								</div>
							</div>
							
							
							
							<h2>Jetons déduits ou ajouté par l'administrateur</h2>
								
							<div class="panel panel-danger m-t-15" id="cont">
									<div class="panel-heading"></div>
									<div class="panel-body">
					
							<div class="table-responsive" >
								<table  id="example" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
									<thead>
										<tr>
										   
						
											<th>@lang('Nb de Jetons avant déduction ')</th>
											<th>@lang('Nb de Jetons déduits ')</th>
											<th>@lang('Ajouté automatiquement à la date d\'anniv ')</th>
											<th>@lang('Date Déduction')</th>
										
											
					
											
					
										</tr>
									</thead>
									<tbody>
										@foreach ($updatejetons as $updatejeton)
					
										<tr>
											
					
					
					
										
											<td  >
												<label class="color-info">{{$updatejeton->jetons_avant_deduction}} </label> 
											</td>
											<td><label class="color-danger" style="font-size: 20px">{{$updatejeton->jetons_deduis}} </label> </td>
											<td>@if($updatejeton->est_ajout_cronjob)  <span class="badge badge-success">Oui</span> @else  <span class="badge badge-danger">Non</span> @endif </td>
											<td><label >{{$updatejeton->created_at->format('d/m/Y')}} </label> </td>
										
											
											
										
					
									  
										</tr> 
								   
								@endforeach
								  </tbody>
								</table>
							</div>
						</div>
					</div>
							
				
							
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
<script>

// $('.restaurer').on('click',function(e){
//       archive_id = $(this).attr('id');
//    });
   
  

   $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','a.restaurer',function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

swalWithBootstrapButtons({
    title: 'Confirmez-vous la restauration de cette affaire (Mandat '+that.attr("data-mandat")+' )  ?',
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
                type: 'POST',
                success: function(data){
                document.location.reload();
                },
                error : function(data){
                console.log(data);
                }
            })
            .done(function () {
                    that.parents('tr').remove()
            })

        swalWithBootstrapButtons(
        'Restaurée!',
        'L\'affaire a bien été restaurée.',
        'success'
        )
        
        
    } else if (
        // Read more about handling dismissals
        result.dismiss === swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons(
        'Annulé',
        'L\'affaire n\'a pas été restaurée.',
        
        'error'
        )
    }
})
    })
}) 



































// $('#valider_archive').on('click',function(e){
//  e.preventDefault();

// if($("#motif_archive").val() != ""){

//     $.ajaxSetup({
//                 headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
//             })
//    $.ajax({

//          type: "POST",
//          url: "compromis/archiver/"+archive_id ,
//          data:  $("#form_archive").serialize(),
//          success: function (result) {
//             console.log(result); 
//             document.location.reload();
//          },
//          error: function(error){
//             console.log(error);
            
//          }
//    });
// }


// });
    </script>
@endsection
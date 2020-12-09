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
            <span>Total jetons déduis : </span> <label class="color-success" style="font-size: 20px">{{$total_deduis}} </label> <br>
            <span>Total jetons restants : </span> <label class="color-danger" style="font-size: 20px">{{$total_restant}} </label> <br>
            <span>Date d'anniversaire : </span> <label class="color-primary" style="font-size: 20px">{{$mandataire->date_anniv()}} </label>
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
													<th>@lang('Mandataire')</th>
													@endif
													<th>@lang('Type Facture')</th>
													<th>@lang('Jetons déduis ')</th>
													<th>@lang('Date Déduction')</th>
												
													
							
													
							
												</tr>
											</thead>
											<tbody>
												@foreach ($factures as $facture)
							
												<tr>
													{{-- <td  >
														@if($facture->statut != "en attente de validation" && $facture->url != null) 
														<label class="color-info"> </label> 
															<a class="color-info" title="Télécharger la facture d'honoraire "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> </a>
														@else 
															<label class="color-danger" ><strong> Non dispo </strong> </label>
														@endif
							
													   
													</td> --}}
							
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
											
													@if(auth()->user()->role == "admin")
													<td  >
														<label class="color-info">
															@if($facture->user !=null)
															<a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   
															@endif
														   
														</label> 
													</td>
													@endif
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
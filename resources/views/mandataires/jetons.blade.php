@extends('layouts.app')
@section('content')
    @section ('page_title')
    Gestions des jetons
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
                                                    <th>@lang('Date anniv')</th>
                                                    <th>@lang('Statuts jetons')</th>
                                                    <th>@lang('Jetons restants')</th>
                                                    <th>@lang('Nb mois de retards')</th>
                                                    <th>@lang('Min à déduire sur prochaine facture')</th>
                                            
                                                   
                                                  
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($contrats as $contrat)
                                            
                                            @if(($contrat != null && $contrat->a_demission == false && $contrat->est_fin_droit_suite == false) ) 
                                                <tr>
                                                    
                                                    <td>
                                                        <a href="{{route('switch_user',Crypt::encrypt($contrat->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{ $contrat->user->nom }}">{{$contrat->user->nom}} {{$contrat->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> 
                                                    </td>
                                                    <td>
                                                        {{$contrat->user->date_anniv('fr')}}   
                                                    </td>  
                                                    
                                                    <td>
                                                        @if($contrat->user->etat_jeton()['retard'] > 0 )    <span class="badge badge-danger">retard</span>  @else    <span class="badge badge-success">à jour</span> @endif  
                                                    </td>   

                                                    <td style="color: #32ade1;  ">
                                                        @if($contrat->user->contrat != null)
                                                            @if($contrat->user->contrat->deduis_jeton == true)
                                                    <a href="{{route('mandataire.historique_jeton', Crypt::encrypt($contrat->user->id))}}" class="badge badge-default"><i style="font-size: 15px" class="material-icons color-success ">launch</i>  <span style="font-size: 22px"> {{$contrat->user->nb_mois_pub_restant}} </span></a>
                                                            @else 
                                                                <span class="badge badge-danger">Non</span>
                                                            @endif
            
            
                                                              
                                                        @endif
                                                        
                                                    </td>
                                                  
                                                    <td>
                                                        <span style="color:#ff006c; font-size:18px"> {{$contrat->user->etat_jeton()['retard']}} </span>    
                                                    </td>      
                                                    <td>
                                                        <span style="color:#32ade1; font-size:18px"> {{$contrat->user->etat_jeton()['jeton_min_a_deduire']}} </span>    
                                                    </td>   
                                               
                                                  
                                                    <td width="13%">
                                                        <span><a href="{{route('mandataire.historique_jeton', Crypt::encrypt($contrat->user->id))}}" data-toggle="tooltip" title="@lang('Détails des jetons ') {{ $contrat->user->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                                       
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

    </script>
@endsection
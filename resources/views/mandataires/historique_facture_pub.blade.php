@extends('layouts.app')
@section('content')
    @section ('page_title')
    Historique des factures pub de  {{$mandataire->nom}} {{$mandataire->prenom}}
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
				<a href="{{route('mandataires.facture_pub')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Retour')</a> 

            @endif
            <br>
            
            <div class="row">
				<div class="col-lg-6 col-sm-6">
					<br>
					 <span class="badge badge-danger">retard</span>   Sur les factures  pub
				</div>
				<div class="col-lg-6 col-sm-6">
					<span>Montant TTC Total Dû:  </span> <label class="color-primary" style="font-size: 20px"> {{number_format($montant_du,'2','.','')}} €</label>
					
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
									<h2>Factures Pub</h2>
								
									<div class="panel panel-default m-t-15" id="cont">
											<div class="panel-heading"></div>
											<div class="panel-body">
							
									<div class="table-responsive" >
                                        <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsivexxxx display    "  style="width:100%"  >
                                            <thead>
                                                <tr>
                                                   
                                                    <th>@lang('Facture')</th>
                                                    <th>@lang('Période')</th>
                                                    @if(auth()->user()->role == "admin")
                                                    <th>@lang('Mandataire')</th>
                                                    @endif

                                                    <th>@lang('Montant HT ')</th>
                                                    <th>@lang('Montant TTC ')</th>
                                                    <th>@lang('Alerte paiement')</th>
                                                    @if(auth()->user()->role == "admin")
                                                    <th>@lang('Encaissement')</th>
                                                    
                                                    
                                                    @endif
                                                 
                                                    <th>@lang('Relances de paiement')</th>
                                                    <th>@lang('Actions')</th>
                
                                                </tr>
                                            </thead>
                                            @php 
                                                    
                                            $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                                        @endphp
                                            <tbody>
                                                @foreach ($factures as $facture)
                                                @if($facture->type == "pack_pub")
                                                <tr>
                                                    <td width="" >
                                                       @if($facture->type != "avoir")
                                                            @if($facture->compromis != null)
                                                              
                                                                <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                            
                                                            @else 
                                                                
                                                                @if($facture->type == "pack_pub" )
                                                                    <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_fact_pub', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                                
                                                                @else 
                                                                    <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                                @endif
                                                                
                                                            @endif
                                                        @else 
                                                        <a class="color-info" title="Télécharger la facture d'avoir" href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> AV</a>
                
                                                        @endif
                                                    </td>
                                                    
                                                    <td  width="" >
                                                        <span class="badge badge-warning"> @if($facture->factpublist()) {{ $mois[$facture->factpublist()->created_at->format('m')*1]}} @endif</span>
                                                     </td>
                                              
                                               
                                                    @if(auth()->user()->role == "admin")
                                                    <td width="" >
                                                       
                                                            @if($facture->user !=null)
                                                            <label class="color-info"><a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                            
                                                            </label> 
                                                            @endif
                                                       
                                                    </td>
                                                    @endif
                                                    {{-- <td width="" >
                                                        <label class="color-info">{{$facture->type}} </label> 
                                                    </td> --}}
                                                    <td width="" >
                                                    {{number_format($facture->montant_ht,'2','.','')}}
                                                    </td>
                                                    <td  width="" >
                                                    {{number_format($facture->montant_ttc,'2','.','')}}
                                                    </td>
                                                   
                                                    {{--  alert paiement--}}
                                                    @php
                                                     if($facture->compromis != null){
                                                         $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                                        $diff_jours = $interval / 86400 ;
                                                     }
                                                        
                                                    
                                                    @endphp
                                                   
                                                    @if($facture->type == "stylimmo" && $facture->a_avoir == false)
                                                    <td width="" >
                
                                                        @if($facture->compromis != null)
                                                            @if( $facture->encaissee == false && $diff_jours < 3)
                                                                <label  style="color:lime">En attente de paiement</label>
                                                            @elseif( $facture->encaissee == false && $diff_jours >=3 && $diff_jours <=6)
                                                                <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                                            @elseif($facture->encaissee == false && $diff_jours >6) 
                                                                <label class="danger" style="background-color:#FF0633;color:white;visibility:visible;">Danger !!! &nbsp;&nbsp;</label>
                                                            @elseif($facture->encaissee == true)
                                                                <label  style="background-color:#EDECE7">En banque  </label>
                                                            @endif
                                                        @endif
                                                    </td>
                
                                                    @elseif($facture->type == "pack_pub" && $facture->reglee == true) 
                                                        
                                                    <td width=""  >
                                                        <label data-toggle="tooltip" title="Facture pub réglée par le mandataire"  style="color:rgb(255, 4, 0);">Réglée le {{$facture->date_reglement->format('d/m/Y')}} </label>
                                                    </td>
                                                    
                                                    @else 
                                                    <td width="" style="background-color:#DCD6E1" >
                                                       
                                                    </td>
                                                    @endif
                                                {{-- fin alert paiement --}}
                                                    {{-- encaissement seulement par admin --}}
                                                    @if(auth()->user()->role == "admin")
                                                    <td width="" >
                                                        {{-- si c'est une facture d'avoir --}}
                                                        @if($facture->type == "avoir")
                                                            <label class="color-danger"> Avoir sur {{$facture->facture_avoir()->numero}}</label> 
                                                        @else
                                                            {{-- Si la facture stylimmo a un avoir --}}
                                                            @if($facture->a_avoir == 1 && $facture->avoir() != null)
                                                                <label class="color-primary"> annulée par AV {{$facture->avoir()->numero}}</label> 
                
                                                            @else
                                                                @if($facture->encaissee == 0)
                                                                <button   data-toggle="modal" data-target="#myModal2" class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" onclick="getId({{$facture->id}})"  id="{{$facture->id}}"><i class="ti-wallet"></i>Encaisser</button>
                                                                @else 
                                                                <label class="color-danger"> @if($facture->date_encaissement != null) encaissée le {{$facture->date_encaissement->format('d/m/Y')}} @else encaissée @endif  </label> 
                                                                @endif 
                                                            @endif
                
                                                        @endif
                                                    </td>
                                                    
                                                  
                                                    @endif
                                                  
                                                    <td>
                                                        @if($facture->date_relance_paiement != null ) <span class="badge badge-danger"> {{$facture->nb_relance_paiement}}</span> <span> , dernière: {{$facture->date_relance_paiement->format('d/m/Y')}}     </span> @endif
                                                    </td>
                                                    
                                                    
                                                    <td width="" >
                                                       
                                                        
                                                        {{-- @if($facture->type == "pack_pub" && $facture->reglee == true) --}}
                                                        
                                                        {{-- <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}" target="_blank" title="Confirmez que vous avez bien reçu le virement du mandataire" data-toggle="tooltip"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-help"></i>Confirmer l'encaissement</a> --}}
                                                        
                                                        @if($facture->type == "pack_pub" && $facture->reglee == false && $facture->encaissee == false  && $facture->a_avoir != 1  )
                                                            
                                                        <a data-href="{{route('facture.relancer_paiement_facture', $facture->id)}}" title="Relancer le mandataire pour le payement de la facture" data-toggle="tooltip"  class="btn btn-danger  btn-flat btn-addon  m-b-10 m-l-5 relancer" id=""><i class="ti-email"></i>Relancer</a>
                                                            
                                                        
                                                        @endif
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
							<!-- end table -->
							
										<!-- end table -->
									</div>
								</div>
							</div>
							
                        </div>
                    </div>
                </div>
                

     <!-- Modal d'encaissement de la facture stylimmo-->
     <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-xs">
        
           <!-- Modal content-->
           <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Date d'encaissement</h4>
              </div>
              <div class="modal-body">
                 <form action="" method="get" id="form_encaissement">
                       <div class="modal-body">
                          
                          <div class="">
                             <div class="form-group row">
                                   <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_encaissement">Date d'encaissement <span class="text-danger">*</span> </label>
                                   <div class="col-lg-8 col-md-8 col-sm-8">
                                      <input type="date"  class="form-control {{ $errors->has('date_encaissement') ? ' is-invalid' : '' }}" value="{{old('date_encaissement')}}" max="{{date('Y-m-d')}}" id="date_encaissement" name="date_encaissement" required >
                                      @if ($errors->has('date_encaissement'))
                                      <br>
                                      <div class="alert alert-warning ">
                                         <strong>{{$errors->first('date_encaissement')}}</strong> 
                                      </div>
                                      @endif   
                                   </div>
                             </div>
                          </div>
                       
                       </div>
                       <div class="modal-footer">
                          <input type="submit" class="btn btn-success" id="valider_encaissement"  value="Valider" />
                          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                       </div>
                 </form> 
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



{{-- Relancer un mandataire pour une facture PUB --}}

  
$(function() {
 $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
 })
 

 $('[data-toggle="tooltip"]').tooltip()
 $('body').on('click','a.relancer',function(e) {
    let that = $(this)

    e.preventDefault()
    const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false,
    })

swalWithBootstrapButtons({
 title: 'Le mandataire va recevoir un mail de relance, continuer ?',
 type: 'warning',
 showCancelButton: true,
 confirmButtonColor: '#DD6B55',
 confirmButtonText: '@lang('Oui')',
 cancelButtonText: '@lang('Non')',
 
}).then((result) => {
 if (result.value) {
    $('[data-toggle="tooltip"]').tooltip('hide')
          $.ajax({                        
             url: that.attr('data-href'),
             type: 'GET',
             success: function(data){
               document.location.reload();
             },
             error : function(data){
                console.log(data);
             }
          })
          .done(function () {
            console.log(data);
                
          })

    swalWithBootstrapButtons(
    'Relancé!',
    'Le mandatataire sera notifié par mail.',
    'success'
    )
    
    
 } else if (
    // Read more about handling dismissals
    result.dismiss === swal.DismissReason.cancel
 ) {
    swalWithBootstrapButtons(
    'Annulé',
    'Aucune action effectuée :)',
    'error'
    )
 }
})
 })
})
</script>

{{-- ##### Encaissement de la facture stylimmo --}}
<script>

    function getId(id){
       facture_id = id;
       // console.log(id);
       
    }
    
    
       // $('.encaisser').click(function(){
       //    facture_id = $(this).attr('data-id');
       //    console.log("okok");
          
       //    console.log(facture_id);
       // })
          
          
          
    $('#valider_encaissement').on('click',function(e){
      e.preventDefault();
    
    if($("#date_encaissement").val() != ""){
      
    
       $.ajax({
             type: "GET",
             url: "/encaisser/factures-stylimmo/"+facture_id ,
             data:  $("#form_encaissement").serialize(),
             success: function (result) {
                console.log(result);
                
                      swal(
                         'Encaissée',
                         'Vous avez encaissé la facture '+result,
                         'success'
                      )
                      .then(function() {
                        //  window.location.href = "{{route('facture.index')}}";
                        location.reload();
                      })
             },
             error: function(error){
                console.log(error);
                
                swal(
                         'Echec',
                         'la facture '+error+' n\'a pas été encaissée',
                         'error'
                      )
                      .then(function() {
                         // window.location.href = "{{route('facture.index')}}";
                      })
                
             }
       });
    }
    
    });
    
    </script>


@endsection
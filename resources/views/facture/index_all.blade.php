@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures 
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
                @if(Auth::user()->role == "admin")
                
                  <a href="{{route('facture.create_libre')}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Créer facture STYL\'IMMO')</a>
                  <br> <hr>
             
               @endif
            <div class="row">
            
               <nav class="navbar navbar-default">
                  <div class="container-fluid">
                   
                  
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                      <ul class="nav navbar-nav">
                        <li class="active"><a href="{{route('facture.index')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Styl'immo <span class="sr-only">(current)</span></a></li>
                        <li><a href="{{route('facture.index_honoraire')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Honoraires</a></li>
                        <li><a href="{{route('facture.index_communication')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif</a></li>
                        
                      </ul>
                
                     
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
                </nav>
            
                  
                    
                  <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                
                                
                                
                 
                                                
                                <div class="card-body">
                                        <div class="panel panel-default m-t-15" id="cont">
                                                <div class="panel-heading"></div>
                                                <div class="panel-body">
                
                                        <div class="table-responsive " >
                                            <table  id="example1" class=" table student-data-table   table-striped table-hover dt-responsivexxxxxxxx display    "  style="width:100%"  >
                                                <thead class="test">
                                                    <tr>
                                                       
                                                        <th>@lang('Fact Stylimmo')</th>
                                                        <th>@lang('Mandat')</th>
                                                      
                                                        <th>@lang('Mandataire')</th>
                                                 
                                                     
                                                  
                                                        <th>@lang('Montant HT ')</th>
                                                        <th>@lang('Montant TTC ')</th>                                                   
                                                     
                                                        <th>@lang('Encaissement')</th>
                                                        
                                                     
                
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($factureStylimmos as $facture)
                
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
                                                        <td width="" >
                                                            {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                                            @if($facture->compromis != null)
                                                                 <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>
                                                            @else 
                                                                <label class="color-danger">{{$facture->type}}  </label>
                                                            @endif
                                                        </td>
                                                   
                                                        
                                                     
                                                        <td width="" >
                                                            <label class="color-info">
                                                                @if($facture->user !=null)
                                                                <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                                @endif
                                                            </label> 
                                                        </td>
                                                     
                                                        
                                                        
                                                            
                                                    
                                                        
                                                        <td  width="" >
                                                        {{number_format($facture->montant_ht,'2','.','')}}
                                                        </td>
                                                        <td  width="" >
                                                        {{number_format($facture->montant_ttc,'2','.','')}}
                                                        </td>
                                                       
                
                                                   
                                                       
                                                    
                
                                                     
                                                    {{-- fin alert paiement --}}
                                                        {{-- encaissement seulement par admin --}}
                                                       
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
                                                        
                                                       
                                                      
                                                  
                                                    </tr> 
                                               
                                            @endforeach
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                                <!-- end table -->
            


          
                                
                                
                                
                                
                                
                                                     
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
    </div>
@endsection

@section('js-content')


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
                     window.location.href = "{{route('facture.index_all')}}";
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

{{--  Reglement de la facture stylimmo--}}
<script>
   // $('.payer').on('click',function(e){
   //    facture_id = $(this).attr('id');  
   //    console.log(facture_id);
   // });

   function getIdPayer(id){
      facture_id = id;
      // console.log(id);
      
   }




   
   
   
   // Règlement de la facture de pub
   $('#valider_reglement_pub').on('click',function(e){
       e.preventDefault();
 
      if($("#date_reglement_pub").val() != ""){

         $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
         $.ajax({
               type: "GET",
               url: "regler/factures-honoraire/"+facture_id ,
               data:  $("#form_regler_pub").serialize(),
               success: function (result) {
                  swal(
                     'Réglée',
                     'Vous avez reglé la facture ',
                     'success'
                  )
                  .then(function(data) {
                     window.location.href = "{{route('facture.index')}}";
                  })
               },
               error: function(error){
                  console.log(error);
                  
                  swal(
                           'Echec',
                           'la facture  n\'a pas été reglé '+error,
                           'error'
                        )
                        .then(function() {
                           window.location.href = "{{route('facture.index_all')}}";
                        })
                  
               }
         });
      }


   });
   
   
   
   
   
 
</script>






@endsection
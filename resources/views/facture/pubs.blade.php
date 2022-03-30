
 
                
                
 
 
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
                            
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                     
                    
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                          <li ><a href="{{route('facture.index')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Styl'immo <span class="sr-only">(current)</span></a></li>
                          <li><a href="{{route('facture.index_honoraire')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Honoraires</a></li>
                          <li class="active"><a href="{{route('facture.index_communication')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif</a></li>
                            @if(Auth()->user()->role == "admin") <li><a href="{{route('facture.index_fournisseur')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  @lang('Factures Fournisseurs')  <span class="badge badge-danger"></span></a></li> @endif
                          
                        </ul>
                  
                       
                      </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                  </nav>
                  
                  <br>
             <div class="row">
 
 
 
                <!-- table -->
                <label class="color-danger" style="font-size:16px; font-weight: bold">NB: Ajoutez le numéro de la facture à régler dans la description de votre virement ! </label> 
                <!-- table -->
                
                <div class="card-body">
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
                                    {{-- <th>@lang('Type Facture')</th> --}}
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>
                                    {{-- @if(auth()->user()->role == "admin") --}}
                                    <th>@lang('Alerte paiement')</th>
                                    @if(auth()->user()->role == "admin")
                                    <th>@lang('Encaissement')</th>
                                    
                                    
                                    @endif
                                    {{-- @endif --}}
                                    {{-- <th>@lang('Télécharger')</th> --}}
                                    <th>@lang('Avoir')</th>
                                    <th>@lang('Relances de paiement')</th>
                                    <th>@lang('Actions')</th>

                                </tr>
                            </thead>
                            @php 
                                    
                            $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                        @endphp
                            <tbody>
                                @foreach ($facturePubs as $facture)
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
                                   {{-- Avoir --}}
                                    <td width="" >

                                        @if($facture->type != "avoir")
                                            @if($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis != null  && auth()->user()->role == "admin") 

                                                <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>

                                            @elseif($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis == null  && auth()->user()->role == "admin") 

                                                <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
                                            @elseif($facture->a_avoir == 1 && $facture->avoir() != null)
                                                <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->avoir()->id))}}"  class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5 " id=""><i class="ti-download"></i>avoir {{$facture->avoir()->numero}}</a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($facture->date_relance_paiement != null ) <span class="badge badge-danger"> {{$facture->nb_relance_paiement}}</span> <span> , dernière: {{$facture->date_relance_paiement->format('d/m/Y')}}     </span> @endif
                                    </td>
                                    
                                    
                                    <td width="" >
                                       
                                        
                                        {{-- @if($facture->type == "pack_pub" && $facture->reglee == true) --}}
                                        
                                        {{-- <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}" target="_blank" title="Confirmez que vous avez bien reçu le virement du mandataire" data-toggle="tooltip"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-help"></i>Confirmer l'encaissement</a> --}}
                                        
                                        @if($facture->type == "pack_pub" && $facture->reglee == false && $facture->encaissee == false  && $facture->a_avoir != 1  )
                                            
                                        <a href="{{route('facture.relancer_paiement_facture', $facture->id)}}" target="_blank" title="Relancer le mandataire pour le payement de la facture" data-toggle="tooltip"  class="btn btn-danger  btn-flat btn-addon  m-b-10 m-l-5 relancer" id=""><i class="ti-email"></i>Relancer</a>
                                            
                                        
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
            
            
            
                        <!-- Modal d'encaissement de la facture Pub-->
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
                                     @csrf
                                           <div class="modal-body">
                                              
                                              <div class="">
                                                 <div class="form-group row">
                                                       <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_encaissement">Date d'encaissement <span class="text-danger">*</span> </label>
                                                       <div class="col-lg-8 col-md-8 col-sm-8">
                                                          <input type="date"  class="form-control {{ $errors->has('date_encaissement') ? ' is-invalid' : '' }}" value="{{old('date_encaissement')}}" id="date_encaissement" name="date_encaissement" required >
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
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                     </form> 
                                  </div>
                               </div>
                            </div>
                         </div>

        </div>
            <!-- end table -->
        
        </div>
        <!-- end table -->


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
               window.location.href = "{{route('facture.index_communication')}}";
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
{{-- Alertes paiement  --}}
<script type="text/javascript">
var clignotement = function(){

var element = document.getElementsByClassName('danger');


Array.prototype.forEach.call(element, function(el) {
   if (el.style.visibility=='visible'){
      el.style.visibility='hidden';
   }
   else{
      el.style.visibility='visible';
   }
});


};

periode = setInterval(clignotement, 1500);

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










</script>






{{-- Relancer un mandataire pour une facture PUB --}}
<script>      
  
  
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
             url: that.attr('href'),
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

@endsection
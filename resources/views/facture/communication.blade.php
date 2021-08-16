
 
 
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
                          
                        </ul>
                  
                       
                      </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                  </nav>
                  
                  <br>
             <div class="row">
 
 
 
                <!-- table -->
                <label class="color-danger" style="font-size:16px; font-weight: bold">NB: Ajoutez le numéro de la facture à régler dans la description de votre virement ! </label> 
                
                <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">


                    <div class="table-responsive" >
                        <table  id="example3" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                            <thead>
                                <tr>
                                   
                                    <th>@lang('Numéro ')</th>
                                    <th>@lang('Type ')</th>
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>
                                    <th>@lang('Pour le mois de')</th>
                                   
                                    <th>@lang('Régler')</th>
                                    {{-- <th>@lang('Action')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            
                                @php 
                                $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                                @endphp
                            
                            
                                @foreach ($factureCommunications as $facture)

                                <tr>
                                
                                    <td  >
                                        <a class="color-info" data-toggle="tooltip"  title="Télécharger la facture {{$facture->numero}} "  href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> </a>                                        
                                    </td>
                                    <td  >
                                        <label class="color-info">{{$facture->type}} </label> 
                                    </td>
                                    <td  >
                                        <label class="color-warning">{{$facture->montant_ht}} </label> 
                                    </td>
                                    
                                    <td  >
                                        <label class="color-warning">{{$facture->montant_ttc}} </label> 
                                    </td>
                                    
                                    <td >
                                        @if($facture->type == "pack_pub")
                                            <span class="badge badge-warning"> @if($facture->factpublist() != null ) {{ $mois[$facture->factpublist()->created_at->format('m')*1]}} @endif</span> 
                                        @else 
                                            <span class="badge badge-warning"> {{ $mois[$facture->created_at->format('m')*1]}}</span> 
                                        @endif
                                    </td>
                                   
                                  

                                    <td>
                                        @if($facture->reglee == 0)
                                   
                                            <button data-toggle="modal"   data-target="#myModal2" onclick="getIdPayer('{{Crypt::encrypt($facture->id)}}')" id="{{Crypt::encrypt($facture->id)}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 payer" ><i class="ti-wallet"></i>
                                               A payer</button>
                                        
                                        @else 
                                            <label class="color-warning">@if($facture->date_reglement != null) Réglée le {{$facture->date_reglement->format('d/m/Y')}} @else Réglée @endif</label> 
                                        @endif 
                                    </td>
                                  
                                    {{--  paiement--}}
                                    @php
                                        // $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                        // $today = date_create(date('Y-m-d'));
                                        // $interval = date_diff($today, $datevente);
                                    @endphp
                                  
                           

                                    
                               
                                    
                                  

                              
                                </tr> 
                           
                        @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>



{{-- Règlement dela facture --}}
            <div class="modal fade" id="myModal2" role="dialog">
                <div class="modal-dialog modal-sm">
                
                  <!-- Modal content-->
                  <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Date de règlement</h4>
                    </div>
                    <div class="modal-body">
                    <p><form action="" id="form_regler_pub">
                              <div class="modal-body">
                                @csrf
                                      <div class="">
                                          <div class="form-group row">
                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_reglement_pub">Date de règlement <span class="text-danger">*</span> </label>
                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                  <input type="date"  class="form-control {{ $errors->has('date_reglement_pub') ? ' is-invalid' : '' }}" value="{{old('date_reglement_pub')}}" id="date_reglement_pub" name="date_reglement_pub" required >
                                                  @if ($errors->has('date_reglement_pub'))
                                                  <br>
                                                  <div class="alert alert-warning ">
                                                      <strong>{{$errors->first('date_reglement_pub')}}</strong> 
                                                  </div>
                                                  @endif   
                                              </div>
                                          </div>
                                      </div>
                                </p>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-success" id="valider_reglement_pub"  value="Valider" />
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
              </form> 
                </div>
              </div>

{{-- <div class="container"> --}}


    
  {{-- </div>               --}}


            </div>
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
   url: "encaisser/factures-stylimmo/"+facture_id ,
   data:  $("#form_encaissement").serialize(),
   success: function (result) {
      console.log(result);
      
            swal(
               'Encaissée',
               'Vous avez encaissé la facture '+result,
               'success'
            )
            .then(function() {
               window.location.href = "{{route('facture.index')}}";
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



// Règlement de la note d'honoraire
$('#valider_reglement').on('click',function(e){
 e.preventDefault();

if($("#date_reglement").val() != ""){

   $.ajaxSetup({
 headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 }
});
   $.ajax({
         type: "GET",
         url: "regler/factures-honoraire/"+facture_id ,
         data:  $("#form_regler").serialize(),
         success: function (result) {
            swal(
               'Réglée',
               'Vous avez reglé la facture ',
               'success'
            )
            .then(function() {
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
                     window.location.href = "{{route('facture.index')}}";
                  })
            
         }
   });
}


});





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
                     window.location.href = "{{route('facture.index')}}";
                  })
            
         }
   });
}


});






</script>

<script>
// ######### Réitérer une affaire


$(function() {
 $.ajaxSetup({
     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
 })
 $('[data-toggle="tooltip"]').tooltip()
 $('body').on('click','a.cloturer',function(e) {
     let that = $(this)
     e.preventDefault()
     const swalWithBootstrapButtons = swal.mixin({
 confirmButtonClass: 'btn btn-success',
 cancelButtonClass: 'btn btn-danger',
 buttonsStyling: false,
})

swalWithBootstrapButtons({
 title: 'Confirmez-vous la réitération de cette affaire (Mandat '+that.attr("data-mandat")+' )  ?',
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
                 that.parents('tr').remove()
         })

     swalWithBootstrapButtons(
     'Réitérée!',
     'L\'affaire a bien été réitérée.',
     'success'
     )
     
     
 } else if (
     // Read more about handling dismissals
     result.dismiss === swal.DismissReason.cancel
 ) {
     swalWithBootstrapButtons(
     'Annulé',
     'L\'affaire n\'a pas été réitérée.',
   
     'error'
     )
 }
})
 })
})
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
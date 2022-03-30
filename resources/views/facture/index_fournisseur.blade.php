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
                
             
                <br>
            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_stylimmo" class=""><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Factures Styl\'immo')</a></li>
                          <li><a href="{{route('facture.index_honoraire')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Honoraires</a></li>
                          <li><a href="{{route('facture.index_communication')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif</a></li>
                            @if(Auth()->user()->role == "admin") <li  class="active"><a href="{{route('facture.index_fournisseur')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i>  @lang('Factures Fournisseurs')  <span class="badge badge-danger"></span></a></li> @endif
                          
                         
                       </ul>
                    </div>
                    <!-- Content -->
                    <div class=" col-lg-12 col-md-12 col-sm-12">
                       <div class="card">
                          <div class="card-body">
                             <div class="tab-content">
                                <div class="tab-pane active" id="stylimmo"> 
                                
                                
                                
                                
 
                <!-- table -->
                
                <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                            <thead>
                                <tr>
                                   
                                    <th>@lang('Numéro')</th>                             
                                    <th>@lang('Fournisseur')</th>                        
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>                           
                                    <th>@lang('Date de facture')</th>            
                                    <th>@lang('Description')</th>
                                    <th>@lang('Actions')</th>
                                 

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factureFournisseurs as $facture)

                                <tr>
                                    <td width="" >
                                        <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                    </td>
                                    
                                    <td width="" >                                   
                                            <label class="color-danger">{{$facture->fournisseur->nom}}  </label>                                    
                                    </td>
                                    <td  width="" >
                                        {{number_format($facture->montant_ht,'2','.','')}}
                                    </td>
                                    <td  width="" >
                                        {{number_format($facture->montant_ttc,'2','.','')}}
                                    </td>                               
                                  
                                
                                    <td width=""  >
                                        <label class="color-info"> @if($facture->date_facture != null) {{$facture->date_facture->format('d/m/Y')}} @endif</label> 
                                    </td>
                                  
                                    <td width=""  >
                                        <label class="color-info">{!!$facture->description_produit!!} </label> 
                                    </td>
                              
                                    <td>
                                        <span><a href="{{route('fournisseur.facture.edit',Crypt::encrypt($facture->id))}}" data-toggle="tooltip" title="@lang('Modifier facture') {{ $facture->numero }}"><i class="large material-icons color-warning">edit</i></a></span>                     
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


@endsection
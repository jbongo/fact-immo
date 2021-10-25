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
          
            <div class="row">
                    <!-- Navigation Buttons -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                       <ul class="nav nav-pills nav-tabs" id="myTabs">
                          <li id="li_stylimmo" class="active"><a href="#stylimmo" data-toggle="pill"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @lang('Factures Pubs')</a></li>
                          
                         
                         
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
                                   
                                    <th>@lang('Facture Stylimmo')</th>
                                    <th>@lang('Période')</th>
                                   
                                    @if(auth()->user()->role == "admin")
                                    <th>@lang('Mandataire')</th>
                                    @endif
                                    {{-- <th>@lang('Type Facture')</th> --}}
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>
                                    {{-- <th>@lang('Date Facture')</th> --}}
                                    {{-- @if(auth()->user()->role == "admin") --}}
                                    <th>@lang('Alerte paiement')</th>
                                    @if(auth()->user()->role == "admin")
                                    <th>@lang('Encaissement')</th>


                                    @endif
                                    {{-- @endif --}}
                                    {{-- <th>@lang('Télécharger')</th> --}}
                                    <th>@lang('Avoir')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    
                                $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                            @endphp
                                @foreach ($facturePubs as $facture)

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
                                                    <span class="badge badge-warning"> {{ $mois[$facture->created_at->format('m')*1]}}</span> 
                                    </td>
                                   
                                    @if(auth()->user()->role == "admin")
                                    <td width="" >
                                        <label class="color-info">
                                            @if($facture->user !=null)
                                            <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                            @endif
                                        </label> 
                                    </td>
                                    @endif
                                    {{-- <td width="" >
                                        <label class="color-info">{{$facture->type}} </label> 
                                    </td> --}}
                                    <td  width="" >
                                    {{number_format($facture->montant_ht,'2','.','')}}
                                    </td>
                                    <td  width="" >
                                    {{number_format($facture->montant_ttc,'2','.','')}}
                                    </td>
                                    {{-- <td  width="" class="color-info">
                                            {{$facture->created_at->format('d/m/Y')}}
                                    </td> --}}
                                    {{-- @if($facture->type == "stylimmo") --}}
                                  

                                    {{-- @else 
                                    <td width="" style="background-color:#DCD6E1" >
                                        
                                    </td>
                                    @endif --}}
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
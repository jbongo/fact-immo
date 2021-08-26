
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
                          <li class="active"><a href="{{route('facture.index_honoraire')}}"> <i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> Factures Honoraires</a></li>
                          <li><a href="{{route('facture.index_communication')}}"><i class="material-icons" style="font-size: 15px;">account_balance_wallet</i> @if(Auth()->user()->role == "admin") @lang('Factures Pubs') @else @lang('Factures Communication')  <span class="badge badge-danger">{{ $nb_comm_non_regle}}</span> @endif</a></li>
                          
                        </ul>
                  
                       
                      </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                  </nav>
             <div class="row">
             
             
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" >
                            <table  id="example2" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Facture Honoraire')</th>
                                        <th>@lang('Facture Stylimmo')</th>
                                        <th>@lang('Mandat')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        <th>@lang('Type Facture')</th>
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        <th>@lang('Commision (%)')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        <th>@lang('Date de l\'acte')</th>
                                        <th>@lang('Etat (Fac Stylimmo)')</th>
                                        {{-- <th>Validation (Fac honoraire)</th> --}}
                                        <th>@lang('Paiement')</th>

                                        {{-- @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
                                        @endif --}}

                                        <th>@lang('Note honoraire')</th>
                                        {{-- <th>@lang('Télécharger')</th> --}}

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureHonoraires as $facture)

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




                                        <td  >
                                            {{-- <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label>  --}}
                                        <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </a>
                                            
                                        </td>
                                        <td  >
                                           
                                        <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>

                                        </td>
                                        @if(auth()->user()->role == "admin")
                                        <td  >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                    @if($facture->type == "partage_externe")
                                                    <a href="#" data-toggle="tooltip" style="color: red; font-weight:bold" > {{$facture->compromis->nom_agent}}</a>   
                                                    
                                                    @else 
                                                    
                                                    <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   
                                                    
                                                    @endif
                                                @endif
                                               
                                            </label> 
                                        </td>
                                        @endif
                                        <td  >
                                            <label class="color-info">{{$facture->type}} </label> 
                                        </td>
                                        <td   >
                                            @if (auth()->user()->role != "admin" && $facture->compromis->cloture_affaire == 0 && $facture->compromis->demande_facture == 2 )
                                            <span style="color:#751a97; font-size:12px">  Affaire à réitérer </span>
                                            @else
                                            {{number_format($facture->montant_ht,2,'.','')}} €
                                      
                                            @endif
                                        </td>
                                        <td   >
                                            
                                            @if (auth()->user()->role != "admin" && $facture->compromis->cloture_affaire == 0 && $facture->compromis->demande_facture == 2 )
                                            <span style="color:#751a97; font-size:12px">  Affaire à réitérer </span>
                                            @else
                                            {{number_format($facture->montant_ttc,2,'.','')}} €
                                            @endif
                                        </td>
                                        <td>
                                        @if($facture->pourcentage_actuel() != "")                                        
                                            <span style="color:#751a97; font-size:18px">  {{$facture->pourcentage_actuel()}} % </span>
                                        @endif
                                        
                                        </td>
                                        {{-- <td   class="color-info">
                                                {{$facture->created_at->format('d/m/Y')}}
                                        </td> --}}
                                       
                                        <td >
                                            <label class="color-info">
                                                {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                            </label> 
                                        </td>
                                        <td  >
                                            @if($facture->compromis->getFactureStylimmo()->encaissee == 0 )
                                                <label class="color-danger" ><strong> Non encaissée </strong> </label>                                            
                                            @else 
                                            <label class="color-danger"> @if($facture->compromis->getFactureStylimmo()->date_encaissement != null) encaissée le {{$facture->compromis->getFactureStylimmo()->date_encaissement->format('d/m/Y')}} @else encaissée @endif  </label> 
                                                
                                            @endif 
                                        </td>
                                  

                                        {{--  paiement--}}
                                        @php
                                            $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                            $today = date_create(date('Y-m-d'));
                                            $interval = date_diff($today, $datevente);
                                        @endphp
                                        {{-- @if($facture->type == "stylimmo") --}}
                                        <td  >
                                            @if($facture->reglee == 0)
                                                @if(Auth()->user()->role == "admin")
                                                    <button data-toggle="modal" @if($facture->compromis->getFactureStylimmo()->encaissee == 0 || $facture->statut != "valide")disabled style="background:#bdbdbd" @endif data-target="#myModal" onclick="getIdPayer('{{Crypt::encrypt($facture->id)}}')" id="{{Crypt::encrypt($facture->id)}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 payer" ><i class="ti-wallet"></i>
                                                        @if($facture->compromis->getFactureStylimmo()->encaissee == 0 || $facture->statut != "valide") A payer @else .A Payer @endif</button>
                                                @else
                                                    <label class="color-danger">Non réglée </label> 
                                                @endif
                                            @else 
                                                <label class="color-success">@if($facture->date_reglement != null) Réglée le {{$facture->date_reglement->format('d/m/Y')}} @else Réglée @endif</label> 
                                            @endif 
                                        </td>

                                        
                                        {{-- {{dd('dd')}} --}}
                                        
                                        <td  >
                                            {{-- @if(auth::user()->role=="admin") --}}
                                            {{-- @if ($facture->compromis->je_porte_affaire == 0  || $facture->compromis->agent_id == auth::user()->id || ($facture->compromis->je_porte_affaire == 1 && $facture->compromis->est_partage_agent == 1) ) --}}
                                            @if ( $facture->compromis->user_id == auth()->user()->id && auth()->user()->role != "admin" && $facture->compromis->cloture_affaire == 0 && $facture->compromis->demande_facture == 2 && $facture->compromis->agent_id != Auth()->user()->id)
                                                <a class="cloturer" href="{{route('compromis.cloturer',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" data-mandat="{{$facture->compromis->numero_mandat}}" title="@lang('Réitérer l\'affaire  ')"> <img src="{{asset('images/logo-notaire.png')}}" width="25px" height="30px" alt=""> <!-- <i class="large material-icons color-success ">thumb_up_alt</i> --> </a> 
                                            @elseif($facture->compromis->user_id != auth()->user()->id && auth()->user()->role != "admin" && $facture->compromis->cloture_affaire == 0 && $facture->compromis->demande_facture == 2 )
                                              
                                                <a class="cloturer" href="#" data-toggle="tooltip"  title="Affaire à réitérer par le porteur d'affaire "> <img src="{{asset('images/logo-notaire.png')}}" width="25px" height="30px" alt=""> <!-- <i class="large material-icons color-success ">thumb_up_alt</i> --> </a> 


                                            @else
                                                @if ($facture->type == "partage" )
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                @elseif ($facture->type == "partage_externe" )
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage_externe',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note partage externe  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 


                                                @elseif($facture->type == "parrainage" || $facture->type == "parrainage_partage")
                                                    {{-- @if($facture->filleul_id != null)
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($facture->compromis->id), $facture->filleul_id])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    @else --}}
                                                        <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($facture->compromis->id), $facture->user_id])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    {{-- @endif --}}
                                                
                                                @else 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    
                                                @endif
                                            {{-- @else
                                                <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>

                                            @endif --}}
                                                
                                            @endif
                                        </td> 

                                  
                                    </tr> 
                               
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>




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
                   window.location.href = "{{route('facture.index_honoraire')}}";
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
                         window.location.href = "{{route('facture.index_honoraire')}}";
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
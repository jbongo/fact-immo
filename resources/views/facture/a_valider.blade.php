@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures à valider
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
                <div class="card-body">
                    <div class="panel panel-default m-t-15" id="cont">
                            <div class="panel-heading"></div>
                            <div class="panel-body">

                    <div class="table-responsive" >
                        <table  id="example2" class=" table table-striped table-hover dt-responsive "  >
                            <thead>
                                <tr>
                                   
                                    <th>@lang('Fact Hono')</th>
                                    <th>@lang('Date Ajout ')</th>
                                    <th>@lang('Fact Styl')</th>
                                    <th>@lang('Mandat')</th>
                                    @if(auth()->user()->role == "admin")
                                    <th>@lang('Mandataire')</th>
                                    @endif
                                    <th>@lang('Type Fact')</th>
                                    <th>@lang('Montant HT ')</th>
                                    <th>@lang('Montant TTC ')</th>

                                    <th>@lang('Note hono')</th>
                                    <th>@lang('Télécharger')</th>
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)

                                <tr>
                                    <td  >
                                        <label class="color-info">{{$facture->numero}} </label> 
                                    </td>
                                    <td  style="color: #342867;" >
                                        <strong>@if($facture->date_ajout_facture != null) {{$facture->date_ajout_facture->format('d/m/Y')}} @endif</strong> 
                                        </td>
                                    <td  >
                                        {{-- <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label>  --}}
                                    <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter"><label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </label></a>
                                        
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
                                    {{number_format($facture->montant_ht,2,'.',' ')}} €
                                    </td>
                                    <td >
                                    {{number_format($facture->montant_ttc,2,'.',' ')}} €
                                    </td>
                                   
                                    
                                    <td  >
                                
                                        {{-- @if ($facture->compromis->je_porte_affaire == 0  || $facture->compromis->agent_id == auth::user()->id || ($facture->compromis->je_porte_affaire == 1 && $facture->compromis->est_partage_agent == 1) ) --}}
                                            @if ($facture->type == "partage" )
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                            @elseif ($facture->type == "partage_externe" )
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage_externe',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note partage externe  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                          
                                            @elseif($facture->type == "parrainage_partage" || $facture->type == "parrainage")
                                            
                                                @if($facture->filleul_id != null)
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($facture->compromis->id), $facture->filleul_id])}}" data-toggle="tooltip" title="@lang('Note honoraire parrainnage ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                @else 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',[Crypt::encrypt($facture->compromis->id), $facture->user_id])}}" data-toggle="tooltip" title="@lang('Note honoraire parrainnage ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                @endif 
                                            
                                            @else 
                                                <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                
                                            @endif
                        
                                    </td> 
                                    <td width="" >                                            
                                        <a href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class=" btn btn-warning btn-flat btn-addon m-b-10 m-l-5 " id="telecharger"><i class="ti-download"></i> Télécharger</a>
                                    </td>

                                    <td width="" >
                                        <a href="{{route('facture.valider_honoraire', [1,Crypt::encrypt($facture->id)] )}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider" id="valider"><i class="ti-check"></i>Valider</a>
                                        <a  data-toggle="modal" data-target="#modal_refus"  onclick="getId({{$facture->id}})"  id="{{$facture->id}}"  href="#"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 " ><i class="ti-close"></i>Refuser</a>
                                    </td>
                                </tr> 
                           
                        @endforeach
                          </tbody>
                        </table>
                        
                        <!-- Modal refus fichier -->
                        <div class="modal fade" id="modal_refus" role="dialog">
                            <div class="modal-dialog modal-xs">
                            
                               <!-- Modal content-->
                               <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
                                  <div class="modal-header">
                                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                                     <h4 class="modal-title">Refuser la facture</h4>
                                  </div>
                                  <div class="modal-body">
                                     <form action="" method="" id="form_valider">
                                           <div class="modal-body">
                                            
                                              <div class="">
                                                 <div class="form-group row">
                                                       <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="motif">Motif du refus <span class="text-danger">*</span> </label>
                                                       <div class="col-lg-8 col-md-8 col-sm-8">
                                                            
                                                        <select name="motif" id="motif" class="form-control">
                                                            <option value="Absence de TVA">Absence de TVA</option>
                                                            <option value="Absence de numéro TVA">Absence de numéro TVA</option>
                                                            <option value="Erreur de saisie de date">Erreur de saisie de date</option>
                                                            <option value="Erreur de montant ">Erreur de montant </option>
                                                            <option value="Autre">Autre</option>
                                                        </select>
                                                            
                                                          @if ($errors->has('motif'))
                                                          <br>
                                                          <div class="alert alert-warning ">
                                                             <strong>{{$errors->first('motif')}}</strong> 
                                                          </div>
                                                          @endif   
                                                       </div>
                                                 </div>
                                              </div>
                                           
                                           </div>
                                           <div class="modal-footer">
                                              <input type="submit" class="btn btn-success" id="valider_facture"  value="Valider" />
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
        </div>
    </div>
@endsection

@section('js-content')


      
  <script>

//###Valider la facture      

    $(function() {
       $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
       })
       
      
       $('[data-toggle="tooltip"]').tooltip()
       $('body').on('click','a.valider',function(e) {
          let that = $(this)
      
          e.preventDefault()
          const swalWithBootstrapButtons = swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          })

    swalWithBootstrapButtons({
       title: '@lang('Voulez-vous vraiment valider la facture ?')',
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
                      
                })

          swalWithBootstrapButtons(
          'Validée!',
          'Le mandatataire sera notifié par mail.',
          'success'
          )
          
          
       } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
       ) {
          swalWithBootstrapButtons(
          'Annulé',
          'Aucune validation effectuée :)',
          'error'
          )
       }
    })
       })
    })



// ###  Refuser la facture



// ### Refuser le fichier

function getId(id){
    facture_id = id;
   
}

      
$('#valider_facture').on('click',function(e){
  e.preventDefault();

if($("#motif").val() != ""){
  
    let url = "/facture/honoraire/valider/0/"+facture_id;

   $.ajax({
         type: "POST",
         url: url,
         data:  $("#form_valider").serialize(),
         success: function (result) {
            console.log(result);
            
                  swal(
                     'Refusé',
                     'Le mandataire recevra un mail de refus',
                     'success'
                  )
                  .then(function() {
                     window.location.href = "{{route('facture.honoraire_a_valider')}}";
                  })
         },
         error: function(error){
            console.log(error);
            
            swal(
                     'Echec',
                     'la facture '+error+' n\'a pas été refusé',
                     'error'
                  )
                  .then(function() {
                     // window.location.href = "{{route('document.a_valider')}}";
                  })
            
         }
   });
}

});

    
</script>
@endsection
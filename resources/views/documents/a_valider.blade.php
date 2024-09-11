@extends('layouts.app')
@section('content')
    @section ('page_title')
    Documents à valider
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
            <a href="{{route('document.index')}}" class="btn btn-default btn-rounded btn-addon btn-lg m-b-10 m-l-5" ><i class="ti-list"></i>@lang('Documents validés')</a>
              
              <br><br>
            
                
            <div class="card-body">
                <div class="panel panel-danger m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example2" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Mandataire')</th>
                                <th>@lang('Document')</th>
                                <th>@lang('Date d\'expiration')</th>
                                <th>@lang('Date d\'ajout du doc')</th>
                                <th>@lang('Action')</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($fichiers as $fichier)
                        
                        @if($fichier->user != null)
                            
                            <tr>
                                
                               
                                <td>
                                    {{$fichier->user->prenom}}    {{$fichier->user->nom}} 
                                </td>
                                <td>
                                    @if($fichier->user->document($fichier->document->reference) != null)
                                         
                                        
                                        @if($fichier->user->document($fichier->document->id)->est_image())                                            
                                            <a href="{{$fichier->user->document($fichier->document->id)->lien_public_image()}}" data-toggle="tooltip" target="_blank" title="Télécharger {{$fichier->document->nom}}"  class="btn btn-success btn-flat btn-addon "><i class="ti-download"></i>{{$fichier->document->nom}}</a> 
                                        @else                                        
                                                <a href="{{route('document.telecharger', [$fichier->user->id, $fichier->document->reference])}}" data-toggle="tooltip" title="Télécharger {{$fichier->document->nom}}"  class="btn btn-danger btn-flat btn-addon "><i class="ti-download"></i>{{$fichier->document->nom}}</a>
                                        @endif
                                        
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="text-danger "> <strong> @if($fichier->date_expiration != null) {{$fichier->date_expiration->format('d/m/Y')}} @endif</strong></span>
                                </td>
                                
                                <td>
                                    <span class="text-default">{{$fichier->updated_at->format('d/m/Y')}}</span>
                                </td>
                                    

                                <td width="">
                                    <a href="{{route('document.valider', [1,$fichier->id] )}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider" id="valider"><i class="ti-check"></i>Valider</a>
                                    <button   data-toggle="modal" data-target="#modal_refus"  onclick="getId({{$fichier->id}})"  id="{{$fichier->id}}"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 refuser" id="refuser"><i class="ti-close"></i>Refuser</button>
                                </td>
                            </tr>
                            
                         
                        @endif
                            
                            
                    @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>




                      

                <!-- Modal refus fichier -->
                <div class="modal fade" id="modal_refus" role="dialog">
                    <div class="modal-dialog modal-xs">
                    
                       <!-- Modal content-->
                       <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
                          <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                             <h4 class="modal-title">Refuser le fichier</h4>
                          </div>
                          <div class="modal-body">
                             <form action="" method="get" id="form_valider">
                                   <div class="modal-body">
                                      
                                      <div class="">
                                         <div class="form-group row">
                                               <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="motif">Motif du refus <span class="text-danger">*</span> </label>
                                               <div class="col-lg-8 col-md-8 col-sm-8">
                                                    
                                                <select name="motif" id="motif" class="form-control">
                                                    <option value="Fichier non valide">Fichier non valide</option>
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


<script>
   
//###Valider le fichier      

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
       title: '@lang('Voulez-vous vraiment valider le fichier ?')',
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
          '',
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



// ### Refuser le fichier

function getId(id){
   fichier_id = id;
   // console.log(id);
   
}

      
$('#valider_encaissement').on('click',function(e){
  e.preventDefault();

if($("#date_encaissement").val() != ""){
  

   $.ajax({
         type: "GET",
         url: "/documents/valider/2/"+fichier_id ,
         data:  $("#form_valider").serialize(),
         success: function (result) {
            console.log(result);
            
                  swal(
                     'Refusé',
                     'Le mandataire recevra un mail de refus',
                     'success'
                  )
                  .then(function() {
                     window.location.href = "{{route('document.a_valider')}}";
                  })
         },
         error: function(error){
            console.log(error);
            
            swal(
                     'Echec',
                     'le fichier '+error+' n\'a pas été refusé',
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
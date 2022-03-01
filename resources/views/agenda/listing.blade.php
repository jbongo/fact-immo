@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Profil du prospect 
@endsection
<style>
.modal-content {
    border-radius: 50px;
    width: 90%;
}
</style>
<div class="row">

   <div class="col-lg-12">
   
      <div class="card">
    <a href="{{route('agendas.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Agenda général')</a>
      
         <div class="card-body">
           
            


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="media">

              
               <div class="media-left media-middle">
                  <i class="ti-list f-s-48 color-danger m-r-1"></i> <label for="" style="font-weight: bold">Toutes les tâches </label>  
               
               </div>
                <div class="col-lg-12">
                  <div class="card alert">
                      <div class="card-header">
                         
                          
                   
                      </div>
                      <div class="recent-comment m-t-20">
                      
                      
                      
                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                
                                    <tr>
                                        <th>Tâche prévu pour</th>
                                        <th>Type</th>
                                        <th>Type</th>
                                        <th>Tâche</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                       

                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($agendas as $agenda)
                                       
                                            <tr>
                                                
                                                <td style="color: #450854; ">
                                                   <span>
                                                        @if($agenda->prospect_id != null) {{$agenda->prospect->nom}} {{$agenda->prospect->prenom}}   @elseif($agenda->mandataire_id != null ) {{$agenda->user->nom}} {{$agenda->user->prenom}}  @else  @endif
                                                   
                                                   </span>  
                                                   
                                                </td>
        
                                                <td style="color: #450854; ">
                                                    <p class="media-heading">{{$agenda->type_rappel}} <span> <a href="#" data-toggle="modal" data-target="#add-agenda-{{$agenda->id}}" data-toggle="tooltip" title="@lang('Modifier ')"><i class=" material-icons color-warning">edit</i></a></span>  </p>
                                                </td>
                                                <td style="color: #e05555; font-weight:bold; ">
                                                    <p>{{$agenda->titre}} : <i>{{$agenda->description}} </i>  </p> 
                                                </td>
                                                <td style="color: #32ade1;">
                                                    <div class="comment-action">
                                                        @if($agenda->est_terminee == true )
                                                           <div class="badge badge-success">Terminée</div>
                                                        @else 
                                                           <div class="badge badge-danger">Non Terminée</div>
                                                        @endif
                                                        
                                                     </div>
                                                </td>
                                                <td style="color: #32ade1;">
                                                    @php 
                                                        $date_deb = new DateTime($agenda->date_deb);
                                                   @endphp
                                                   <p class="text-danger">{{$date_deb->format('d/m/Y')}} à {{$agenda->heure_deb}}</p>
                                                </td>
                                             
                                             
                                            </tr>
                                          
                                          
                                             <!-- Modal Add agenda -->
                         <div class="modal fade none-border" id="add-agenda-{{$agenda->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Ajouter un évènement</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('prospect.agenda.update')}}" method="post">
                                        
                                        @csrf
                                        <input type="hidden" name="id" value="{{$agenda->id}}" />
                                       
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Date début</label>
                                                <input class="form-control form-white" placeholder="" value="{{$agenda->date_deb}}" type="date" name="date_deb" />
                                            </div><div class="col-md-6">
                                                <label class="control-label">Date Fin</label>
                                                <input class="form-control form-white" placeholder="" value="{{$agenda->date_fin}}" type="date" name="date_fin" />
                                            </div>
                                            
                                            <div class="col-md-6">
                                              <label class="control-label">Type de rappel</label>
                                              <select name="type_rappel"  class="form-control form-white" id="type_rappel" required>
                                                  <option value="{{$agenda->type_rappel}} ">{{$agenda->type_rappel}} </option>
                                                  <option value="appel">appel</option>                                                    
                                                  <option value="rappel">rappel</option>
                                                  <option value="rdv">rdv</option>
                                                  <option value="autre">autre</option>
                                              </select>
                                          </div>
                                          
                                            <div class="col-md-6">
                                                <label class="control-label">Heure début</label>
                                                <input class="form-control form-white" placeholder="" type="time" value="{{$agenda->heure_deb}}"  min="06:00" max="23:00" required name="heure_deb" />
                                            </div>
                      
                                        </div>
                                        <hr>
                                        <div class="row">
                                        
                                            
                                            
                                            <div class="col-md-6">
                                                <label class="control-label text-danger">Tâche terminée ?</label>
                                                <select name="est_terminee" class="form-control form-white" id="est_terminee" required>
                                                    <option value="{{$agenda->est_terminee == true ? 'true' : 'false'}}">{{$agenda->est_terminee == true ? 'Oui' : 'Non'}}</option>
                                                   
                                                    <option value="true">Oui </option>                                    
                                                    <option value="false">Non</option>                                    
                                                  
                                                </select>
                                            </div>
                                        
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="control-label">Titre</label>
                                                <input class="form-control form-white" placeholder="" value="{{$agenda->titre}} " type="text" name="titre" />
                                            </div>
                                            <div class="col-md-12">
                                                <label class="control-label">Description</label>
                                               <textarea name="description" class="form-control" id="" cols="30" rows="5">{{$agenda->description}} </textarea>
                                            </div>
                                        </div>
                                        
                                        
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                        
                                        <input type="submit" class="btn btn-success waves-effect waves-light save-agenda"  value="Modifier">
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
                                    @endforeach
                              </tbody>
                            </table>
                        </div>
                      

                      
                      </div>
                  </div>
                  <!-- /# card -->
              </div>
              
              
     
           <hr>
              
              
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

 $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.send-access').click(function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
})

    swalWithBootstrapButtons({
        title: '@lang('Le prospect recevra ses accès. Continuer ?')',
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
                    type: 'get'
                })
                .done(function () {
                        that.parents('tr').remove()
                })

            swalWithBootstrapButtons(
            'Envoyé!',
            'Un email a été envoyé au prospect.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Envoi annulé',
            'error'
            )
        }
    })
        })
    })

</script>
@endsection
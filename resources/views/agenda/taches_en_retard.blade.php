@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Agenda général en listing
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
    <a href="{{route('agendas.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Agenda général en calendrier')</a>
      
         <div class="card-body">
           
            


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="media">

              
                <div style="display:flex; flex-direction: row; justify-content:space-around; ">
              
                    <div class="media-left media-middle">
                        <i class="ti-list f-s-48 color-primary m-r-1"></i> <label for="" ><a style="font-weight: bold; color:#2483ac; " href="{{route('agendas.listing')}}">Toutes les tâches 
                            <span class="badge badge-danger">{{\App\Agenda::nb_taches("toutes")}}</span> 
                        </a></label>                    
                    </div>
                    
                    <div class="media-left media-middle">
                        <i class="ti-list f-s-48 color-success m-r-1"></i> <label for="" ><a style="font-weight: bold; color:#14893f;" href="{{route('agendas.listing_a_faire')}}">Tâches à faire
                            <span class="badge badge-danger">{{\App\Agenda::nb_taches("a_faire")}}</span>
                        </a></label>                    
                    </div>
                    
                    <div class="media-left media-middle">                       
                        <i class="ti-list f-s-48 color-danger m-r-1"></i> <label for="" ><a style="font-weight: bold; color:#8b0f06;  font-size:18px" href="{{route('agendas.listing_en_retard')}}">Tâches en retard 
                            <span class="badge badge-danger">{{\App\Agenda::nb_taches("en_retard")}}</span>
                        </a></label> <hr style="border-top: 5px solid #240c9a; margin-top: 10px">                   
                    </div>
                
              
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
                                        <th>Tâche</th>
                                        {{-- <th>Tâche</th> --}}
                                        <th>Date prévue de réalisation</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                       

                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($agendas as $agenda)
                                       
                                            <tr>
                                                
                                                <td style="color: #450854; ">
                                                   <span>
                                                        @if($agenda->liee_a =="prospect") 
                                                                @if($agenda->prospect != null) {{$agenda->prospect->nom}} {{$agenda->prospect->prenom}} @endif  
                                                        @elseif($agenda->liee_a =="mandataire" ) 
                                                                @if($agenda->user != null) {{$agenda->user->nom}} {{$agenda->user->prenom}} @endif  
                                                        @else 
                                                        
                                                        
                                                        @endif
                                                   
                                                   </span>  
                                                   
                                                </td>
        
                                                <td style="color: #450854; ">
                                                    <p class="media-heading">{{$agenda->type_rappel}} <span> <a href="#" data-toggle="modal" data-target="#add-agenda-{{$agenda->id}}" data-toggle="tooltip" title="@lang('Modifier ')"><i class=" material-icons color-warning">edit</i></a></span>  </p>
                                                </td>
                                                <td style="color: #e05555; font-weight:bold; ">
                                                    <p>{{$agenda->titre}} : <i>{{$agenda->description}} </i>  </p> 
                                                </td>
                                                
                                                <td style="color: #32ade1;">
                                                    @php 
                                                        $date_deb = new DateTime($agenda->date_deb);
                                                   @endphp
                                                   <p class="text-danger" style="font-weight: bold;">{{$date_deb->format('d/m/Y')}} à {{$agenda->heure_deb}}</p>
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
                                            
                                                <td>
                                                    <span><a  href="{{route('agenda.delete',$agenda->id)}}" class="supprimer" data-toggle="tooltip" title="@lang('Supprimer ') "><i class="large material-icons color-danger">delete</i> </a></span>
                                                </td>
                                             
                                            </tr>
                                          
                                          
                                             <!-- Modal Add agenda -->
                         <div class="modal fade none-border" id="add-agenda-{{$agenda->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Modifier la tâche</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('agenda.update')}}" method="post">
                                        
                                        @csrf
                                        <input type="hidden" name="id" value="{{$agenda->id}}" />
                                       
                                        @if($agenda->liee_a == "mandataire")
            
                                            <div class="row " style="font-size:17px;">
                                                <div class="col-md-12">
                                                    <label class="text-primary"> {{$agenda->user->nom}} {{$agenda->user->prenom}}</label>
                                                    <label class="control-label">/ </label> <label class="text-danger">   {{$agenda->user->telephone1}}</label>
                                                </div>
                                            </div> </br>
                                        @elseif($agenda->liee_a == "prospect")
                                        
                                            <div class="row " style="font-size:17px;">
                                                <div class="col-md-12">
                                                    <label class="text-primary"> {{$agenda->prospect->nom}} {{$agenda->prospect->prenom}}</label>
                                                    <label class="control-label">/ </label> <label class="text-danger">  {{$agenda->prospect->telephone_portable}}</label>
                                                </div>
                                            </div> </br>
                                        @endif
                                    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Date début</label>
                                                <input class="form-control form-white" placeholder="" value="{{$agenda->date_deb->format('Y-m-d')}}" required type="date" name="date_deb" />
                                            </div><div class="col-md-6">
                                                <label class="control-label">Date Fin</label>
                                                <input class="form-control form-white" placeholder="" value="{{$agenda->date_fin->format('Y-m-d')}}" required type="date" name="date_fin" />
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
                                                        <label class="control-label">Tâche liée à :</label>
                                                        <select name="liee_a" class="form-control liee_a_edit " agenda-id="{{$agenda->id}}"  >
                                                            <option value="{{$agenda->liee_a}}">{{$agenda->liee_a}}</option>
                                                            <option value="mandataire">Mandataire</option>
                                                            <option value="prospect">Prospect</option>
                                                            <option value="aucun">Aucun</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 {{$agenda->liee_a == "mandataire" ? '' : 'div_non_liee'}} div_mandataire_edit_{{$agenda->id}} "  >
                                                        <div class="form-group row" >
                                                            <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="mandataire_id">Choisir un mandataire </label> 
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <select class="selectpickerx form-control " id="mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                                    @if($agenda->user != null) 
                                                                        <option value="{{ $agenda->user->id }}" >{{ $agenda->user->nom }} {{ $agenda->user->prenom }}</option>
                                                                    @endif
                                                                
                                                                    @foreach ($mandataires as $mandataire )
                                                                        <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                                                    @endforeach 
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 {{$agenda->liee_a == "prospect" ? '' : 'div_non_liee'}} div_prospect_edit_{{$agenda->id}} "  >
                                                        <div class="form-group row" >
                                                            <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="prospect_id">Choisir un prospect  </label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <select class="selectpickerx form-control " id="prospect_id" name="prospect_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                                    @if($agenda->prospect != null) 
                                                                        <option value="{{ $agenda->prospect->id }}" data-tokens="{{ $agenda->prospect->nom }} {{ $agenda->prospect->prenom }}">{{ $agenda->prospect->nom }} {{ $agenda->prospect->prenom }}</option>
                                                                    @endif
                                                                    @foreach ($prospects as $prospect )
                                                                        <option value="{{ $prospect->id }}" data-tokens="{{ $prospect->nom }} {{ $prospect->prenom }}">{{ $prospect->nom }} {{ $prospect->prenom }}</option>
                                                                    @endforeach 
                                                                </select>
                                                            </div>
                                                        </div>
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
                                        <button type="button" class="btn btn-danger delete-event waves-effect waves-light supprimer" href="/agenda/delete/{{$agenda->id}}" data-dismiss="modal">Supprimer</button>
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

<script>



$('.div_non_liee').hide();


function selectIdNew(){

     
// #########
        
    if($('#liee_a_add_new').val() == "mandataire"){
        $('#div_mandataire_add_new').show();
        $('#div_prospect_add_new').hide();
        
        
    }else if($('#liee_a_add_new').val() == "prospect"){
        $('#div_prospect_add_new').show();
        $('#div_mandataire_add_new').hide();
        
    }else{        
        $('#div_prospect_add_new').hide();
        $('#div_mandataire_add_new').hide();
        
    }
}


$('.liee_a_edit').on('change', function(el) {
   
    
    let liee_a = $(this).val() ;    
    let agenda_id = $(this).attr('agenda-id') ;
    
    if(liee_a == "mandataire"){
    
        $('.div_mandataire_edit_'+agenda_id).show();
        $('.div_prospect_edit_'+agenda_id).hide();
        
    }else if(liee_a == "prospect"){
    
        $('.div_mandataire_edit_'+agenda_id).hide();
        $('.div_prospect_edit_'+agenda_id).show();
    }else{        
        $('.div_mandataire_edit_'+agenda_id).hide();
        $('.div_prospect_edit_'+agenda_id).hide();
    }


})




// Supprimer une tâche

$(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','.supprimer',function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

            swalWithBootstrapButtons({
                title: 'Confirmez-vous la suppression de cette tâche  ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    // $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({                        
                            url: that.attr('href'),
                            type: 'GET',
                            success: function(data){
                                that.parents('tr').remove()
                            
                                document.location.reload();
                         },
                         error : function(data){
                            console.log(data);
                         }
                        })
                        .done(function () {
                                // that.parents('tr').remove()
                        })
    
                    swalWithBootstrapButtons(
                    'Supprimée!',
                    'Tâche success'
                    )
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'La tâche n\'a pas été supprimée.',
                  
                    'error'
                    )
                }
            })
        })
    })



</script>
@endsection
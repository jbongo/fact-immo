@extends('layouts.app')
@section('content')
    @section ('page_title')
    Prospects
    @endsection
    
    <style>
    .fc-toolbar.fc-header-toolbar {
        /* display: none; */
    }
    .fc th.fc-widget-header {
    background: #855757;
    color: #fff;
    font-size: 14px;
    line-height: 20px;
    padding: 10px 0;
    text-transform: uppercase;
}

.rdv{
    background: #ff4949;
    color: #fff;
}
.appel{
    background: #0b7de8;
    color: #fff;
}
.rappel{
    background: #425f7e;
    color: #fff;
}
.autre{
    background: #136557;
    color: #fff;
}
    
    </style>
    
    <div class="row" >
        <div class="col-lg-12" >
            <div class="card alert">
                <div class="card-header">
                    {{-- <h4>Agenda</h4> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-lg-3">
                            <a href="#" data-toggle="modal" data-target="#add-agenda" class="btn btn-lg btn-danger btn-block waves-effect waves-light">
                                <i class="fa fa-plus"></i> Nouveau rappel
                            </a>
                            <div id="external-events" class="m-t-20">
                                <br>
                             
                              
                              
                            </div>



                        </div> --}}
                        <div class="col-md-12">
                            <div class="card-box">
                                <div id="calendar" ></div>
                            </div>
                        </div>
                        <!-- end col -->
                        <!-- BEGIN MODAL -->
                        <div class="modal fade none-border" id="event-modal" >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Rappel</strong></h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                        <input type="submit" class="btn btn-success waves-effect waves-light save-agenda"  value="Enregistrer">
                                        
                                        <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Supprimer</button>
                                       
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Modal Add agenda -->
                        <div class="modal fade none-border" id="add-agenda">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Ajouter un évènement</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('prospect.agenda.store')}}" method="post">
                                        
                                        @csrf
                                        
                                        <div class="row">
                                          
                                            <div class="col-md-6">
                                                <label class="control-label">Date début</label>
                                                <input class="form-control form-white" placeholder="" type="date" name="date_deb" />
                                            </div>
                                            </div><div class="col-md-6">
                                                <label class="control-label">Date Fin</label>
                                                <input class="form-control form-white" placeholder="" type="date" name="date_fin" />
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="control-label">Type de rappel</label>
                                                <select name="type_rappel"  class="form-control form-white" id="type_rappel" required>
                                                    <option value="appel">appel</option>                                                    
                                                    <option value="rappel">rappel</option>
                                                    <option value="rdv">rdv</option>
                                                    <option value="autre">autre</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Heure début</label>
                                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" />
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <label class="control-label">Heure Fin</label>
                                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_fin" />
                                            </div> --}}
                                        
                                        </div>
                                        <hr>
                                        <div class="row">
                        
                                            <div class="col-md-6">
                                                <label class="control-label">Choisir le prospect</label>
                                                <select name="prospect_id" class="form-control form-white" id="prospect_id" required>
                                                    @foreach($prospects as $prosp)
                                                    <option value="{{$prosp->id}}">{{$prosp->nom}} {{$prosp->prenom}}</option>                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="control-label">Titre</label>
                                                <input class="form-control form-white" placeholder="" type="text" name="titre" />
                                            </div>
                                            <div class="col-md-12">
                                                <label class="control-label">Description</label>
                                               <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                        
                                        <input type="submit" class="btn btn-primary waves-effect waves-light save-agenda"  value="Enregistrer">
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
                    </div>
                </div>
            </div>
            <!-- /# card -->
        </div>
        <!-- /# column -->
    </div>

    
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
            <a href="{{route('prospect.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouveau prospect')</a>
            <a href="{{route('prospect.agenda')}}" class="btn btn-warning btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-calendar"></i>@lang('Agenda général')</a>
              
            {{-- <label for="">Légende:</label><br> --}}
            
            {{-- <span>Non envoyé :</span> <i class="large material-icons color-danger">highlight_off</i> <br>
            <span> Envoyé mais non lu :</span> <i class="large material-icons color-warning">visibility_off</i>  <br>
            <span> Lu:</span> <i class="large material-icons color-success">visibility_on</i> <br>
            <span> Questionnaire renseigné:</span> <i class="large material-icons color-success">done</i>  --}}
                
            <div class="card-body">
                <div class="panel panel-info m-t-15" id="cont">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table  id="example00" class=" table student-d+ata-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('&Eacute;tape')</th>
                                <th>@lang('Nom')</th>
                                {{-- @foreach ($bibliotheques as $biblio )
                                <th>
                                    {{$biblio->reference}}
                                </th>
                                @endforeach --}}
                                <th>@lang('Email')</th>
                                <th>@lang('Téléphone')</th>
                                <th>@lang('Code postal')</th>
                                <th>@lang('Ville')</th>
                                <th>@lang('Fiche prospect')</th>
                                <th>@lang('Fiche consultée')</th>
                                <th>@lang('Fiche renseignée')</th>
                                <th>@lang('Contrat')</th>
                                <th>@lang('Date de création')</th>
                               
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($prospects as $prospect)
                        
                            <tr>
                                
                                <td>
                                   
                                    @if($prospect->modele_contrat_envoye == true && $prospect->fiche_envoyee == false)
                                        <span style="background-color:#0e65b7; color:#fff; background-raduis: 25px; width:15px; height: 15px;">2</span>
                                    
                                    @elseif($prospect->modele_contrat_envoye == true && $prospect->fiche_envoyee == true)
                                        <span style="background-color:#e8bc0b; color:#fff; border-radius:40px; padding: 6px">3</span>
                                    @else
                                        <span style="background-color:#e80bce; color:#fff; border-radius:40px; padding: 6px;">1</span>
                                    @endif
                                </td>
                                
                                <td>
                                    {{$prospect->prenom}} {{$prospect->nom}} 
                                </td>
                                
                                {{-- @foreach ($bibliotheques as $biblio )
                                    <td>
                                    
                                    @if($biblio->getProspect($prospect->id))
                                    
                                  
                                        @if($biblio->getProspect($prospect->id)->pivot->est_fichier_vu == true && $biblio->getProspect($prospect->id)->pivot->question1 == null)
                                         
                                        <i class="large material-icons color-success">visibility_on</i>
                                        
                                        
                                        @elseif($biblio->getProspect($prospect->id)->pivot->est_fichier_vu == true && $biblio->getProspect($prospect->id)->pivot->question1 != null)
                                            <i class="large material-icons color-success">done</i>
                                        
                                        @else                                        
                                            <i class="large material-icons color-warning">visibility_off</i>
                                            
                                        
                                        
                                        @endif
                                    @else 
                                    
                                    <i class="large material-icons color-danger">highlight_off</i>
                                    
                                    
                                    
                                    @endif
                                    </td>
                                @endforeach --}}
                                
                                {{-- <td>
                                    
                                        @if($prospect->fiche_envoyee == true)
                                        
                                      
                                            @if($prospect->a_ouvert_fiche == true && $prospect->renseigne == false)
                                             
                                            <i class="large material-icons color-success">visibility_on</i>
                                            
                                            
                                            @elseif($prospect->a_ouvert_fiche == true && $prospect->renseigne == true)
                                                <i class="large material-icons color-success">done</i>
                                            
                                            @else                                        
                                                <i class="large material-icons color-warning">visibility_off</i>                                            
                                            @endif
                                        @else 
                                        
                                        <i class="large material-icons color-danger">highlight_off</i>                              
                                        
                                        
                                        @endif
                                     
                                
                                </td> --}}
                                
                                <td>
                                    {{$prospect->email}} 
                                </td>
                                <td>
                                    {{$prospect->telephone_portable}}
                                </td>
                                <td>
                                    {{$prospect->code_postal}}
                                </td>
                                <td>
                                    {{$prospect->ville}}
                                </td>
                                
                              
                                <td>
                                    <a href="{{route('prospect.envoi_mail_fiche',Crypt::encrypt($prospect->id) )}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Envoyer la fiche à remplir à ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->fiche_envoyee == true) Renvoyer @else Envoyer @endif  fiche </a>
                                    </td>
                                <td>
                                    @if($prospect->a_ouvert_fiche == true)
                                    <span class="badge badge-success">Oui</span>
                                    @else 
                                    <span class="badge badge-danger">Non</span>
                                    
                                    @endif
                                 </td> 
                                 
                                <td>
                                   @if($prospect->renseigne == true)
                                   <span class="badge badge-success">Oui</span>
                                   @else 
                                   <span class="badge badge-danger">Non</span>
                                   
                                   @endif
                                </td>  
                                
                                <td>
                                    <a href="{{route('prospect.envoyer_modele_contrat',Crypt::encrypt($prospect->id) )}}"  style="background: #3b4842" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Envoyer le modèle de contrat à  ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->modele_contrat_envoye == true) Renvoyer @else Envoyer @endif modèle </a>
                                
                                </td>
                              
                                
                                <td>
                                    <span>{{$prospect->created_at->format('d/m/Y')}}</span>
                                </td>
                                <td width="15%">
                                    <span><a href="{{route('prospect.agenda.show', $prospect->id)}}" data-toggle="tooltip" title="@lang('Agenda du mandataire') {{ $prospect->nom }}"><i class="large material-icons color-danger">event_note</i></a> </span>
                                    <span><a href="{{route('prospect.show',Crypt::encrypt($prospect->id) )}}" data-toggle="tooltip" title="@lang('Détails de ') {{ $prospect->nom }}"><i class="large material-icons color-info">visibility</i></a> </span>
                                    <span><a href="{{route('prospect.edit',Crypt::encrypt($prospect->id) )}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $prospect->nom }}"><i class="large material-icons color-warning">edit</i></a></span>                                    
                                    <span><a  href="{{route('prospect.archiver',[Crypt::encrypt($prospect->id),1])}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $prospect->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                </td>
                            </tr>
                            
  
                            
                            
                    @endforeach
                      </tbody>
                    </table>
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
        
        
        $('body').on('click','a.archiver',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({   
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
                 })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment archiver ce prospect  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        
                        
        
                    $.ajax({
                        type: "GET",
                        // url: "{{route('prospect.add')}}",
                        url: that.attr('href'),
                       
                        // data: data,
                        success: function(data) {
                            
                            swal(
                                    'Archivé',
                                    'Le prospect a été archivé \n ',
                                    'success'
                                )
                                
                            
                              
                        },
                        error: function(data) {
                            console.log(data);
                            
                            swal(
                                'Echec',
                                'Le prospect n\'a pas été archivé :)',
                                'error'
                            );
                        }
                    })
                    .done(function () {
                               that.parents('tr').remove()
                            })
                    ;
                    
                  
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Le prospect n\'a pas été archivé :)',
                    'error'
                    )
                }
            })
         })
    })
</script>



{{-- ################ AGENDA ######################### --}}


<script src="{{ asset("js/lib/jquery-ui/jquery-ui.min.js")}}"></script>
<script src="{{ asset("js/lib/moment/moment.js")}}"></script> 

<script>


</script>
<script src="{{ asset("js/lib/calendar/fullcalendar.min.js")}}">


</script>




{{-- FULLCALENDAR INIT  --}}

<script>

var agendas = "{{$agendas}}";
var tab_id_nom_prospect = "{{$tab_id_nom_prospect}}";

agendas = JSON.parse(agendas.replaceAll('&quot;','"') );
tab_id_nom_prospect = JSON.parse(tab_id_nom_prospect.replaceAll('&quot;','"') );



! function($) {
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$modal = $('#event-modal'),
            this.$event = ('#external-events div.external-event'),
            this.$calendar = $('#calendar'),
            this.$saveAgendaBtn = $('.save-agenda'),
            this.$categoryForm = $('#add-agenda form'),
            this.$extEvents = $('#external-events'),
            this.$calendarObj = null
    };


    /* on drop */
    CalendarApp.prototype.onDrop = function(eventObj, date) {
            var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
        },
        
        
        
        
        /* Lorsqu'on click sur l'évènement  */
        CalendarApp.prototype.onEventClick = function(calEvent, jsEvent, view) {
            var $this = this;
            
            var form = $(`<form action="{{route('prospect.agenda.update')}}" method="post" ></form>`);
     
            form.append(`@csrf <div class="row">
                        <input type="hidden" name="id" value="${calEvent.extendedProps.id}" />
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Date début <span class="text-danger">*</span>  </label>
                                <input class="form-control form-white" placeholder="" type="date" required name="date_deb" value="${calEvent.extendedProps.date_deb}" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Date Fin <span class="text-danger">*</span>  </label>
                                <input class="form-control form-white" placeholder="" type="date" required name="date_fin" value="${calEvent.extendedProps.date_fin}" />
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label">Type de rappel</label>
                                <select name="type_rappel" class="form-control form-white" id="type_rappel" required>
                                    <option value="${calEvent.extendedProps.type_rappel}">${calEvent.extendedProps.type_rappel}</option>
                                    <option value="appel">appel</option>                                    
                                    <option value="rappel">rappel</option>
                                    <option value="rdv">rdv</option>
                                    <option value="autre">autre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Heure début <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" value="${calEvent.extendedProps.heure_deb}" />
                            </div>
                            
                         
                        
                        </div>
                        <hr>
                        <div class="row">
                        
                            <div class="col-md-6">
                                <label class="control-label">Choisir le prospect</label>
                                <select name="prospect_id" class="form-control form-white" id="prospect_id" required>
                                    <option value="${calEvent.extendedProps.prospect_id}">${calEvent.extendedProps.nom_prospect}</option>
                                    @foreach($prospects as $prosp)
                                    <option value="{{$prosp->id}}">{{$prosp->nom}} {{$prosp->prenom}}</option>                                    
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label text-danger">Tâche terminée ?</label>
                                <select name="est_terminee" class="form-control form-white" id="est_terminee" required>
                                    <option value="${calEvent.extendedProps.est_terminee}">${calEvent.extendedProps.est_terminee == true ? 'Oui' : 'Non'}</option>
                                   
                                    <option value="true">Oui </option>                                    
                                    <option value="false">Non</option>                                    
                                  
                                </select>
                            </div>
                        
                        </div>
                        
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Titre <span class="text-danger">*</span>  </label>
                                <input class="form-control form-white" placeholder="" value=" ${calEvent.title}"  type="text" required name="titre" />
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Description</label>
                               <textarea name="description" class="form-control" id="" cols="30" rows="5">${calEvent.extendedProps.description}</textarea>
                            </div>
                            <br>
                            
                            
                        </div> 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                            <input type="submit" class="btn btn-success waves-effect waves-light save-agenda"  value="Modifier">
                            
                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Supprimer</button>
                           
                        </div>
                        `);
            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').on("click", function() {
                $this.$calendarObj.fullCalendar('removeEvents', function(ev) {
                    return (ev._id == calEvent._id);
                });
                $this.$modal.modal('hide');
            });
            $this.$modal.find('form').on('submit', function() {
               
            });
        },
        
        
        
        
        /* Lorsqu'on selection une case dans l'agenda */
        CalendarApp.prototype.onSelect = function(start, end, allDay) {
            var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            
            
            var form = $(`<form action="{{route('prospect.agenda.store')}}" method="post"></form>`);
            form.append(" <div class='row'></div>");
            form.find(".row")
                .append(` @csrf <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Date début <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" value="${start.format('YYYY-MM-DD')}" required type="date" name="date_deb" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Date Fin <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" value="${start.format('YYYY-MM-DD')}" required type="date" name="date_fin" />
                            </div>
                            
                            
                            <div class="col-md-6">
                                <label class="control-label">Type de rappel</label>
                                <select name="type_rappel" class="form-control form-white" id="type_rappel" required>
                   
                                    <option value="appel">appel</option>                                    
                                    <option value="rappel">rappel</option>
                                    <option value="rdv">rdv</option>
                                    <option value="autre">autre</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label">Heure début <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" />
                            </div>
                            
                          
                        
                        </div>
                        
                        <hr>
                        <div class="row">
                        
                        <div class="col-md-6">
                            <label class="control-label">Choisir le prospect</label>
                            <select name="prospect_id" class="form-control form-white" id="prospect_id" required>
                               
                                @foreach($prospects as $prosp)
                                <option value="{{$prosp->id}}">{{$prosp->nom}} {{$prosp->prenom}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                    
                    </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Titre <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" required type="text" name="titre" />
                            </div>
                            <div class="col-md-12">
                                <label class="control-label">Description</label>
                               <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        
                        
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                        <input type="submit" class="btn btn-primary waves-effect waves-light save-agenda"  value="Enregistrer">
                                               
                    </div> `)
                

            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').on("click", function() {
                form.submit();
            });
            $this.$modal.find('form').on('submit', function() {
                var title = form.find("input[name='title']").val();
                var beginning = form.find("input[name='beginning']").val();
                var ending = form.find("input[name='ending']").val();
                var categoryClass = form.find("select[name='category'] option:checked").val();
                if (title !== null && title.length != 0) {
                    $this.$calendarObj.fullCalendar('renderEvent', {
                        title: title,
                        start: start,
                        end: end,
                        allDay: false,
                        className: categoryClass
                    }, true);
                    $this.$modal.modal('hide');
                } else {
                    alert('Titre Obligatoire');
                }
                return false;

            });
            $this.$calendarObj.fullCalendar('unselect');
        },
        
        
        CalendarApp.prototype.enableDrag = function() {
            //init events
            $(this.$event).each(function() {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            });
        }
        
        
        /* Initializing */
    CalendarApp.prototype.init = function() {
            this.enableDrag();
            /*  Initialize the calendar  */
         
            
            var list = Array();
            var val;
            agendas.forEach( function (agenda)  {
                    
                                     
                    if(agenda.est_terminee == true){
                        var color = "bg-success";
                    }else{
                        var color = "bg-danger";
                    } 
                    var nom_prospect = tab_id_nom_prospect[agenda.prospect_id];
                    
                 
                    var date_deb = agenda.date_deb.substring(0,10);
                    var date_fin = agenda.date_fin.substring(0,10);
                    
                    // console.log(date_deb.length);
                    val = {
                    title:agenda.titre,
                    start: agenda.date_deb+'T',
                    // start: agenda.date_deb+'T'+agenda.heure_deb,
                    end: agenda.date_fin+'T',
                    // end: agenda.date_fin+'T'+agenda.heure_fin,
                    extendedProps: {
                        id:agenda.id,
                        type_rappel:agenda.type_rappel,
                        prospect_id:agenda.prospect_id,
                        est_terminee:agenda.est_terminee,
                        nom_prospect:nom_prospect,
                        date_deb:date_deb,
                        date_fin:date_fin,
                        heure_deb:agenda.heure_deb,
                        // heure_fin:agenda.heure_fin,
                        description:agenda.description,
                    },
                   
                    className:color,
                    };
                                        
                    list.push(val)
   
                });
                
            
            var defaultEvents = list;
            

            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                defaultDate: Date.now(),
                slotDuration: '00:15:00',
                buttonText: {
                    year: "Année",
                    month: "Mois",
                    week: "Semaine",
                    day: "Jour",
                    today: "Aujourd'hui",
                },
                allDayHtml: "Toute la<br/>journée",
                eventLimitText: "en plus",
                noEventsMessage: "Aucun événement à afficher",
                /* If we want to split day time each 15minutes */
                minTime: '08:00:00',
                maxTime: '19:00:00',
                defaultView: 'month',
                handleWindowResize: true,
                height: $(window).height() - 400,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
  
                events: defaultEvents,
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                drop: function(date) { $this.onDrop($(this), date); },
                select: function(start, end, allDay) { $this.onSelect(start, end, allDay); },
                eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

            });

            //on new event
            this.$saveAgendaBtn.on('click', function() {
                var titre = $this.$categoryForm.find("input[name='titre']").val();
                var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                if (titre !== null && titre.length != 0) {
                    $this.$extEvents.append('<div class="external-event bg-warning" data-class="bg-warning" style="position: relative;"><i class="fa fa-move"></i>' + titre + '</div>')
                    $this.enableDrag();
                }

            });
        },

        //init CalendarApp
        $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";

    $.CalendarApp.init()

}(window.jQuery);


</script>

@endsection
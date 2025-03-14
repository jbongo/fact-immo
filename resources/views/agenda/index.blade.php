@extends('layouts.app')
@section('content')
    @section ('page_title')
    <span class="control-label">Agenda Général </span> 
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
                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-header">
                            {{-- <h4>Agenda</h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="#" data-toggle="modal" data-target="#add-agenda" class="btn btn-lg btn-danger btn-block waves-effect waves-light"><i class="fa fa-plus"></i>Nouvelle tâche</a>
                                </div>
                                <div class="col-lg-3">
                                        <a href="{{route('agendas.listing')}}"  class="btn btn-lg btn-default"><i class="fa fa-list"></i>  Affichage en listing</a>
                                </div>
                                <div class="col-md-12">
                                    <div class="card-box">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <!-- BEGIN MODAL -->
                                <div class="modal fade none-border" id="event-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"><strong>Tâche</strong></h4>
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
                                                <h4 class="modal-title"><strong>Ajouter une tâche</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('agenda.store')}}" method="post">
                                                
                                                @csrf
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date début  <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" placeholder="" type="date" required name="date_deb" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date Fin  <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" placeholder="" type="date" required name="date_fin" />
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="control-label">Heure début  <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" />
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <label class="control-label">Heure Fin</label>
                                                        <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" name="heure_fin" />
                                                    </div> --}}
                                                
                                                </div>
                                                  <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Type de rappel</label>
                                                        <select name="type_rappel" class="form-control form-white " id="type_rappel" required>
                                                         
                                                            <option value="appel">appel</option>                                    
                                                            <option value="rappel">rappel</option>
                                                            <option value="rdv">rdv</option>
                                                            <option value="autre">autre</option>
                                                        </select>
                                                    </div>
                                                </div>
                                              
                                                
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Tâche liée à :</label>
                                                        <select name="liee_a" onchange="selectIdNew()" class="form-control " id="liee_a_add_new"  >
                                                            <option value="mandataire">Mandataire</option>
                                                            <option value="prospect">Prospect</option>
                                                            <option value="aucun">Aucun</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 " id="div_mandataire_add_new" >
                                                        <div class="form-group row" >
                                                            <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="mandataire_id">Choisir un mandataire </label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <select class="selectpicker " id="mandataire_id_add" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                                     @foreach ($mandataires as $mandataire )
                                                                        <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                                                    @endforeach 
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 " id="div_prospect_add_new" >
                                                        <div class="form-group row" >
                                                            <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="prospect_id">Choisir un prospect  </label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <select class="selectpicker " id="prospect_id" name="prospect_id" data-live-search="true" data-style="btn-warning btn-rounded" >
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
                                                    <div class="col-md-12">
                                                        <label class="control-label">Titre  <span class="text-danger">*</span></label>
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


         </div>
      </div>
    </div>
@endsection


@section('js-content')


<script src="{{ asset("js/lib/jquery-ui/jquery-ui.min.js")}}"></script>
<script src="{{ asset("js/lib/moment/moment.js")}}"></script> 

<script>


</script>
<script src="{{ asset("js/lib/calendar/fullcalendar.min.js")}}">


</script>




{{-- FULLCALENDAR INIT  --}}

<script>

var agendas = "{{$agendas}}";

agendas = JSON.parse(agendas.replaceAll('&quot;','"') );

tab_mandataires = "{{$tab_mandataires}}";
tab_prospects = "{{$tab_prospects}}";

tab_mandataires = JSON.parse(tab_mandataires.replaceAll('&quot;','"') );
tab_prospects = JSON.parse(tab_prospects.replaceAll('&quot;','"') );


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
            
            var form = $(`<form action="{{route('agenda.update')}}" method="post" ></form>`);
            
            if(calEvent.extendedProps.liee_a == "mandataire"){
            
                var contact = ` <div class="row " style="font-size:17px;">
                                    <div class="col-md-12">
                                        <label class="text-primary"> ${calEvent.extendedProps.mandataire}</label>
                                        <label class="control-label">/ </label> <label class="text-danger">  ${calEvent.extendedProps.contact_mandataire} </label>
                                    </div>
                                </div> </br`
            }else if(calEvent.extendedProps.liee_a == "prospect"){
            
                var contact = ` <div class="row " style="font-size:17px;">
                                    <div class="col-md-12">
                                        <label class="text-primary"> ${calEvent.extendedProps.prospect}</label>
                                        <label class="control-label">/ </label> <label class="text-danger">  ${calEvent.extendedProps.contact_prospect} </label>
                                    </div>
                                </div> </br`
            }
     
            form.append(`@csrf 
                            
                        
                        ${contact}
                        <div class="row">
                            <input type="hidden" name="id" value="${calEvent.extendedProps.id}" />
            
                            <div class="col-md-6">                            
                                <label class="control-label">Date début ${calEvent.extendedProps.date_deb} <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_deb" required value="${calEvent.extendedProps.date_deb}" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Date Fin ${calEvent.extendedProps.date_fin} <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_fin" required value="${calEvent.extendedProps.date_fin}" />
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label">Heure début  <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" value="${calEvent.extendedProps.heure_deb}" />
                            </div>
                          
                        
                        </div>
                        <hr>
                        <div class="row">
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
                            <div class="col-md-6">
                                <label class="control-label">Tâche liée à :</label>
                                <select name="liee_a" onchange="selectIdEdit()" class="form-control liee_a_edit"  id="liee_a">
                                    <option value="${calEvent.extendedProps.liee_a}">${calEvent.extendedProps.liee_a}</option>
                                    <option value="mandataire">Mandataire</option>
                                    <option value="prospect">Prospect</option>
                                    <option value="aucun">Aucun</option>
                                </select>
                            </div>
                            
                            <div id="div_mandataire_edit">
                            <div class="col-lg-6 col-md-6 col-sm-6 div_mandataire_edit"  >
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="mandataire_id">Choisir un mandataire  </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="selectpickerx form-control " id="mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                            <option value="${calEvent.extendedProps.mandataire_id}" data-tokens="${calEvent.extendedProps.mandataire}">${calEvent.extendedProps.mandataire}</option>
                                        
                                             @foreach ($mandataires as $mandataire )
                                                <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div id="div_prospect_edit" >
                            <div class="col-lg-6 col-md-6 col-sm-6 div_prospect_edit" >
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="prospect_id">Choisir un prospect </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="selectpickerx form-control" id="prospect_id" name="prospect_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                            <option value="${calEvent.extendedProps.prospect_id}" data-tokens="${calEvent.extendedProps.prospect}">${calEvent.extendedProps.prospect}</option>
                                        
                                            @foreach ($prospects as $prospect )
                                                <option value="{{ $prospect->id }}" data-tokens="{{ $prospect->nom }} {{ $prospect->prenom }}">{{ $prospect->nom }} {{ $prospect->prenom }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Titre  <span class="text-danger">*</span></label>
                                <input class="form-control form-white" placeholder="" value=" ${calEvent.titre}" type="text" required name="titre" />
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
                            
                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light supprimer" href="/agenda/delete/${calEvent.extendedProps.id}" data-dismiss="modal">Supprimer</button>
                           
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
            
            if(calEvent.extendedProps.liee_a =="mandataire"){
                document.getElementById('div_prospect_edit').style.display= 'none';
            }else if (calEvent.extendedProps.liee_a =="prospect"){
                document.getElementById('div_mandataire_edit').style.display= 'none';
                
            }else{
                document.getElementById('div_mandataire_edit').style.display= 'none';
                document.getElementById('div_prospect_edit').style.display= 'none';
                
                
            }
        },
        
        
        
        
        /* Lorsqu'on selection une case dans l'agenda */
        CalendarApp.prototype.onSelect = function(start, end, allDay) {
            var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            var form = $(`<form action="{{route('agenda.store')}}" method="post"></form>`);
            form.append(" <div class='row'></div>");
            form.find(".row")
                .append(`@csrf <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Date début  <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_deb" value="${start.format('YYYY-MM-DD')}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Date Fin  <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_fin" value="${start.format('YYYY-MM-DD')}"  required />
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label">Heure début  <span class="text-danger">*</span> </label>
                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00"  required name="heure_deb" />
                            </div>
                           
                        
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Type de rappel</label>
                                <select name="type_rappel" class="form-control form-white" id="type_rappel" required>
                                    <option value="appel">appel</option>                                    
                                    <option value="rappel">rappel</option>
                                    <option value="rdv">rdv</option>
                                    <option value="autre">autre</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Tâche liée à :</label>
                                <select name="liee_a" onchange="selectId()" class="form-control liee_a_add"  >
                                    <option value="mandataire">Mandataire</option>
                                    <option value="prospect">Prospect</option>
                                    <option value="aucun">Aucun</option>
                                </select>
                            </div>
                            
               
                            <div class="col-lg-6 col-md-6 col-sm-6 "  id="div_mandataire_add" >
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="mandataire_id1">Choisir un mandataire </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                    
                                        <select class="selectpickerx form-control " id="mandataire_id1" name="mandataire_id1" data-live-search="true" data-style="btn-warning btn-rounded" >
                                             @foreach ($mandataires as $mandataire )
                                                <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                            </div>
                         
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 "  id="div_prospect_add">
                                <div class="form-group row" >
                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label"  for="prospect_id1">Choisir un prospect  </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select class="selectpickerx form-control " id="prospect_id1" name="prospect_id1" data-live-search="true" data-style="btn-warning btn-rounded" >
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
                            <div class="col-md-12">
                                <label class="control-label">Titre  <span class="text-danger">*</span></label>
                                <input class="form-control form-white" placeholder="" type="text" name="titre" required />
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
            
            document.getElementById('div_prospect_add').style.display= 'none';
            
          
            
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
                    
                    var date_fin = new Date(agenda.date_fin);
                    var date_deb = new Date(agenda.date_deb);
                    
                    var jour_deb = date_deb.getDate() < 10 ? '0'+date_deb.getDate(): date_deb.getDate() ;
                    var mois_deb = date_deb.getMonth() < 10 ? '0'+ (date_deb.getMonth() + 1): date_deb.getMonth() +1 ;
                    var annee_deb = date_deb.getFullYear();
                    
                    var jour_fin = date_fin.getDate() < 10 ? '0'+date_fin.getDate(): date_fin.getDate() ;
                    var mois_fin = date_fin.getMonth() < 10 ? '0'+ (date_fin.getMonth() + 1): date_fin.getMonth() +1 ;
                    var annee_fin = date_fin.getFullYear();
                    
                    date_deb = annee_deb+'-'+(mois_deb)+'-'+jour_deb;
                    date_fin = annee_fin+'-'+(mois_fin)+'-'+jour_fin;
                    
                    
                    if(agenda.liee_a == "mandataire" && tab_mandataires[agenda.user_id]  != "null" ){
                        var title = agenda.type_rappel+" - "+tab_mandataires[agenda.user_id]["nom"]  ;
                    }
                    else if(agenda.liee_a == "prospect" &&  tab_prospects[agenda.prospect_id] != "null" ){
                        var title = agenda.type_rappel+" - "+tab_prospects[agenda.prospect_id]["nom"]  ;
                    
                    }else{
                        var title = agenda.type_rappel+" - "+agenda.titre ; 
                    }
                         
                   
                    
                    val = {
                    title: title,
                    titre:agenda.titre,
                    start: date_deb,
                    end: date_fin,
                    extendedProps: {
                        id:agenda.id,
                        date_deb:date_deb,
                        date_fin:date_fin,
                        heure_deb:agenda.heure_deb,
                        heure_fin:agenda.heure_fin,
                        type_rappel:agenda.type_rappel,
                        liee_a:agenda.liee_a,
                        mandataire: tab_mandataires[agenda.user_id] ? tab_mandataires[agenda.user_id]["nom_prenom"] : "",
                        contact_mandataire: tab_mandataires[agenda.user_id] ? tab_mandataires[agenda.user_id]["contact"] : "",
                        mandataire_id:agenda.user_id,
                        prospect: tab_prospects[agenda.prospect_id] ? tab_prospects[agenda.prospect_id]["nom_prenom"] : "",
                        contact_prospect: tab_prospects[agenda.prospect_id] ? tab_prospects[agenda.prospect_id]["contact"] : "",
                        prospect_id:agenda.prospect_id,
                        est_terminee:agenda.est_terminee,
                        description:agenda.description,
                    },
                   
                    className: color
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
                height: $(window).height() - 100,
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
                    $this.$extEvents.append('<div class="external-event bg-warning" data-class="bg-warning" style="position: relative;"><i class="fa fa-move"></i>' +  titre + '</div>')
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



<script type="text/javascript">


$('#div_prospect_add_new').hide();



function selectId() {

//  #########
    
    if($('.liee_a_add').val() == "mandataire"){
        document.getElementById('div_mandataire_add').style.display= 'inline';
        document.getElementById('div_prospect_add').style.display= 'none';
     
        
    }else if($('.liee_a_add').val() == "prospect"){
    
        document.getElementById('div_mandataire_add').style.display= 'none';
        document.getElementById('div_prospect_add').style.display= 'inline';
      
    }else{        
 
        document.getElementById('div_mandataire_add').style.display= 'none';
        document.getElementById('div_prospect_add').style.display= 'none';
    }

    

}

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
function selectIdEdit(){

    
    // ############
    
    if($('.liee_a_edit').val() == "mandataire"){
        
        document.getElementById('div_mandataire_edit').style.display= 'inline';
        document.getElementById('div_prospect_edit').style.display= 'none';
        
    }else if($('.liee_a_edit').val() == "prospect"){
    
        document.getElementById('div_mandataire_edit').style.display= 'none';
        document.getElementById('div_prospect_edit').style.display= 'inline';
    }else{        
        document.getElementById('div_mandataire_edit').style.display= 'none';
        document.getElementById('div_prospect_edit').style.display= 'none';
    }

}


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
@extends('layouts.app')
@section('content')
    @section ('page_title')
    Agenda de {{$prospect->nom}} {{$prospect->prenom}}
    @endsection
    <div class="row"> 
       
       <style>
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
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
            <div class="card alert">
                <!-- table -->
              
                <div class="col-lg-10">
                    <a href="{{url()->previous()}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-arrow-left "></i>@lang('Retour')</a> <---->
                    <span><a href="{{route('prospect.show',Crypt::encrypt($prospect->id) )}}" class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Détails de ') {{ $prospect->nom }}"><i class="ti-eye "></i>
                        Voir profil
                    </a> </span>
                    
                </div>
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-header">
                            {{-- <h4>Agenda</h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    {{-- <a href="#" data-toggle="modal" data-target="#add-agenda" class="btn btn-lg btn-danger btn-block waves-effect waves-light">
                                        <i class="fa fa-plus"></i> Nouvelle tâche
                                    </a> --}}
                                    <div id="external-events" class="m-t-20">
                                        <br>
                                     
                                      
                                      
                                    </div>

                                   

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
                                                    <input type="hidden" name="prospect_id" value="{{$prospect->id}}" />
                                                
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date début</label>
                                                        <input class="form-control form-white" placeholder="" type="date" name="date_deb" />
                                                    </div><div class="col-md-6">
                                                        <label class="control-label">Date Fin</label>
                                                        <input class="form-control form-white" placeholder="" type="date" name="date_fin" />
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label class="control-label">Heure début</label>
                                                        <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" />
                                                    </div><div class="col-md-6">
                                                        <label class="control-label">Heure Fin</label>
                                                        <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_fin" />
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


console.log(agendas);

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
                        <input type="hidden" name="prospect_id" value="${calEvent.extendedProps.prospect_id}" />
            
                            <div class="col-md-6">
                                <label class="control-label">Date début</label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_deb" value="${calEvent.extendedProps.date_deb}" />
                            </div><div class="col-md-6">
                                <label class="control-label">Date Fin</label>
                                <input class="form-control form-white" placeholder="" type="date" name="date_fin" value="${calEvent.extendedProps.date_fin}" />
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
                                <label class="control-label">Heure début</label>
                                <input class="form-control form-white" placeholder="" type="time"  min="06:00" max="23:00" required name="heure_deb" value="${calEvent.extendedProps.heure_deb}" />
                            </div>
                            
                           
                        
                        </div>
                            <hr>
                        <div class="row">
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
                                <label class="control-label">Titre</label>
                                <input class="form-control form-white" placeholder="" value=" ${calEvent.title} " type="text" required name="titre" />
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
                            
                            <a type="button" class="btn btn-danger delete-event waves-effect waves-light agenda-supprimer" agenda-id= ${calEvent.extendedProps.id} data-dismiss="modal">Supprimer</a>
                           
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
                            <input type="hidden" name="prospect_id" value="{{$prospect->id}}" />

                            <div class="col-md-6">
                                <label class="control-label">Date début</label>
                                <input class="form-control form-white" placeholder="" value="${start.format('YYYY-MM-DD')}"  type="date" name="date_deb" />
                            </div><div class="col-md-6">
                                <label class="control-label">Date Fin</label>
                                <input class="form-control form-white" placeholder="" value="${start.format('YYYY-MM-DD')}"  type="date" name="date_fin" />
                            </div>
                            
                            <div class="col-md-6">
                                <label class="control-label">Type de rappel</label>
                                <select name="type_rappel" class="form-control form-white" id="type_rappel" required>
                                    <option value=""></option>
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
            
            
                if(agenda.type_rappel == "rdv"){
                        var bgclass = "rdv";
                    }
                    else if(agenda.type_rappel == "appel"){
                        var bgclass = "appel";
                    }
                    else if(agenda.type_rappel == "rappel"){
                        var bgclass = "rappel";
                    }
                    else{
                        var bgclass = "autre";
                    }
                    
                    val = {title:agenda.titre,
                    start: agenda.date_deb+'T'+agenda.heure_deb,
                    // end: agenda.date_fin+'T'+agenda.heure_fin,
                    extendedProps: {
                        id:agenda.id,
                        prospect_id:agenda.prospect_id,
                        date_deb:agenda.date_deb,
                        date_fin:agenda.date_fin,
                        heure_deb:agenda.heure_deb,
                        est_terminee:agenda.est_terminee,
                        type_rappel:agenda.type_rappel,
                        // heure_fin:agenda.heure_fin,
                        description:agenda.description,
                    },
                   
                    className:bgclass
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



{{-- Suppression d'un évènement --}}


<script>
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        
        
        $('body').on('click','.agenda-supprimer',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({   
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
                 })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment supprimer cet évènement ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')

                    $.ajax({
                        type: "POST",
                        // url: "{{route('prospect.add')}}",
                        url: "/agenda/delete/"+that.attr('agenda-id'),
                       
                        // data: data,
                        success: function(data) {
                            swal(
                                    'Supprimé',
                                    'Suppression terminée \n ',
                                    'success'
                                )
                        },
                        error: function(data) {
                            console.log(data);
                            swal(
                                'Echec',
                                'Suppression annulée :)',
                                'error'
                            );
                        }
                    })
                    .done(function () {
                               that.parents('tr').remove()
                            });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Suppression annulée :)',
                    'error'
                    )
                }
            })
         })
    })


</script>

@endsection
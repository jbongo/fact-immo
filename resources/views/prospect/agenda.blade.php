@extends('layouts.app')
@section('content')
    @section ('page_title')
    Agenda
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
                            <h4>Agenda</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-success btn-block waves-effect waves-light">
                                        <i class="fa fa-plus"></i> Nouveau rappel
                                    </a>
                                    <div id="external-events" class="m-t-20">
                                        <br>
                                        {{-- <p>Drag and drop your event or click in the calendar</p>
                                        <div class="external-event bg-primary" data-class="bg-primary">
                                            <i class="fa fa-move"></i>New Theme Release
                                        </div> --}}
                                        {{-- <div class="external-event bg-pink" data-class="bg-pink">
                                            <i class="fa fa-move"></i>My Event
                                        </div>
                                        <div class="external-event bg-warning" data-class="bg-warning">
                                            <i class="fa fa-move"></i>Meet manager
                                        </div>
                                        <div class="external-event bg-dark" data-class="bg-dark">
                                            <i class="fa fa-move"></i>Create New theme
                                        </div> --}}
                                    </div>

                                    {{-- <!-- checkbox -->
                                    <div class="checkbox m-t-40">
                                        <input id="drop-remove" type="checkbox">
                                        <label for="drop-remove">
                                            Remove after drop
                                        </label>
                                    </div> --}}

                                </div>
                                <div class="col-md-9">
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
                                                <h4 class="modal-title"><strong>Ajouter un nouvel évènement</strong></h4>
                                            </div>
                                            <div class="modal-body"></div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Ajouter</button>
                                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Add Category -->
                                <div class="modal fade none-border" id="add-category">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"><strong>Ajouter un évènement</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="control-label">évènement</label>
                                                            <input class="form-control form-white" placeholder="" type="text" name="category-name" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label">Choix</label>
                                                            <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                        <option value="success">xxxx</option>
                                                        <option value="danger">xxxxx</option>
                                                       
                                                    </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Enrtegistrer</button>
                                            </div>
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

<script src="{{ asset("js/lib/calendar/fullcalendar.min.js")}}"></script>
<script src="{{ asset("js/lib/calendar/fullcalendar-init.js")}}"></script>

<script>


</script>
@endsection
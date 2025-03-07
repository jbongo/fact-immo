@extends('layouts.app')
@section('content')
@section('page_title')
    Mandats
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
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <a href="{{route('mandat.select_type')}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i> @lang('Nouveau mandat')</a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <a href="" class="btn btn-info btn-flat btn-addon m-b-10 m-l-5" data-toggle="modal" data-target="#modalReservation"><i class="ti-calendar"></i> @lang('Nouvelle réservation')</a>
                </div>
                @if(Auth::user()->role == 'admin')
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <a href="{{ route('mandat.parametres') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
                            <i class="ti-settings"></i> Paramètres mandats
                        </a>
                    </div>
                @endif
            </div>
           

            <!-- Ajouter la modal après le bouton -->
            <div class="modal fade none-border " id="modalReservation" tabindex="-1" role="dialog" style="width: 60%; margin: auto;">
                <div class="modal-dialog ">
                    <div class="modal-content modal-md">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>@lang('Nouvelle réservation')</strong></h4>
                        </div>
                        <div class="modal-body">
                            <form id="reservationForm" action="{{ route('mandat.reserver') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Nom de la réservation') <span class="text-danger">*</span></label>
                                            <input class="form-control form-white" type="text" id="nom_reservation" name="nom_reservation" required>
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->role == 'admin')
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Suivi par') <span class="text-danger">*</span></label>
                                            <select class="selectpicker form-control form-white" id="mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" required>
                                                <option value="">@lang('Sélectionner')</option>
                                                @foreach(App\User::where('role', 'mandataire')->get() as $mandataire)
                                                    <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <input type="hidden" name="mandataire_id" value="{{ Auth::user()->id }}">
                                @endif
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('Fermer')</button>
                            <button type="submit" form="reservationForm" class="btn btn-primary waves-effect waves-light save-agenda">@lang('Enregistrer')</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @include('mandat.composants.index_mandats')

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Reservation -->
<div class="modal fade none-border" id="editReservationModal" tabindex="-1" role="dialog"  style="width: 60%; margin: auto;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>@lang('Modifier la réservation')</strong></h4>
            </div>
            <div class="modal-body">
                <form id="editReservationForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">@lang('Nom de la réservation') <span class="text-danger">*</span></label>
                                <input class="form-control form-white" type="text" id="edit_nom_reservation" name="nom_reservation" required>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'admin')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">@lang('Suivi par') <span class="text-danger">*</span></label>
                                <select class="selectpicker form-control form-white" id="edit_mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" required>
                                    <option value="">@lang('Sélectionner')</option>
                                    @foreach(App\User::where('role', 'mandataire')->get() as $mandataire)
                                        <option value="{{ $mandataire->id }}" data-tokens="{{ $mandataire->nom }} {{ $mandataire->prenom }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('Fermer')</button>
                <button type="submit" form="editReservationForm" class="btn btn-primary waves-effect waves-light save-reservation">@lang('Enregistrer')</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js-content')
<script>
    // Ajouter la classe sidebar-hide pour masquer la sidebar
    $('body').addClass('sidebar-hide');
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('[data-toggle="tooltip"]').tooltip()


        $('body').on('click', 'a.activer', function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment réactiver cet mandat  ?')',
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
                   
                        url: that.attr('href'),

                        // data: data,
                        success: function(data) {
                            console.log(data);

                            swal(
                                    'Activé',
                                    'Le mandat a été réactivé \n Veuillez mettre à jour son contrat',
                                    'success'
                                )
                                .then(function() {
                                    window.location.href = that.attr('contrat');
                                })
                            // setInterval(() => {
                            //     window.location.href = "{{ route('mandat.index') }}";

                            // }, 5);
                        },
                        error: function(data) {
                            console.log(data);

                            swal(
                                'Echec',
                                'Le mandat n\'a pas été activé :)',
                                'error'
                            );
                        }
                    });




                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Annulé',
                        'Le mandat n\'a pas été activé :)',
                        'error'
                    )
                }
            })
        })

        // Ajouter la gestion du formulaire de réservation
        $('#reservationForm').on('submit', function(e) {
           e.preventDefault();
  
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modalReservation').modal('hide');
                    swal(
                        'Succès',
                        'La réservation a été créée avec succès',
                        'success'
                    ).then(function() {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    let message = 'Une erreur est survenue';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if(xhr.responseJSON && xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }
                    
                    swal(
                        'Erreur',
                        message,
                        'error'
                    );
                }
            });
        });

        // Gestion du clic sur le bouton d'édition
        $('.btn-edit-reservation').click(function(e) {
            e.preventDefault();
            
            let id = $(this).data('id');
            let nom = $(this).data('nom');
            let suivi = $(this).data('suivi');
            
            $('#edit_nom_reservation').val(nom);
            $('#edit_mandataire_id').val(suivi).selectpicker('refresh');
            $('#editReservationForm').attr('action', '/mandats/update-reservation/' + id);
            
            $('#editReservationModal').modal('show');
        });

        // Gestion de la soumission du formulaire d'édition
        $('#editReservationForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editReservationModal').modal('hide');
                    swal(
                        'Succès',
                        'La réservation a été modifiée avec succès',
                        'success'
                    ).then(function() {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    let message = 'Une erreur est survenue';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    
                    swal(
                        'Erreur',
                        message,
                        'error'
                    );
                }
            });
        });
    })
</script>
@endsection

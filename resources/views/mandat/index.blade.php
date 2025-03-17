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
                    <a href="{{route('mandat.select_type')}}" class="btn btn-success btn-addon">
                        <i class="ti-plus"></i>
                        <span class="ml-2">@lang('Nouveau mandat')</span>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4">
                    <a href="" class="btn btn-info btn-addon" data-toggle="modal" data-target="#modalReservation">
                        <i class="ti-calendar"></i>
                        <span class="ml-4">@lang('Nouvelle réservation')</span>
                    </a>
                </div>
                @if(Auth::user()->role == 'admin')
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <a href="{{ route('mandat.parametres') }}" class="btn btn-warning btn-addon">
                            <i class="ti-settings"></i>
                            <span class="ml-2">Paramètres mandats</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <a href="{{ route('mandat.statistiques') }}" class="btn btn-danger btn-addon">
                            <i class="ti-bar-chart"></i>
                            <span class="ml-2">Statistiques</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <a href="{{ route('mandat.import') }}" class="btn btn-primary btn-addon">
                            <i class="ti-import"></i>
                            <span class="ml-2">Importer des mandats</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <a href="{{ route('reservation.externe') }}" target="_blank" class="btn ">
                            <i class="ti-import"></i>
                            <span class="ml-2 mt-5">Réservations externes</span>
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
                                    <div class="col-md-10 ">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Nom de la réservation') <span class="text-danger">*</span></label>
                                            <input class="form-control form-white" type="text" id="nom_reservation" name="nom_reservation" required>
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->role == 'admin')
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Suivi par') <span class="text-danger">*</span></label>
                                            <select class="selectpicker form-control form-white" id="mandataire_id" name="mandataire_id" data-live-search="true" data-style="btn-warning btn-rounded" required>
                                                <option value="">@lang('Sélectionner')</option>
                                                @foreach($mandataires as $mandataire)
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
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="control-label">@lang('Nom de la réservation') <span class="text-danger">*</span></label>
                                <input class="form-control form-white" type="text" id="edit_nom_reservation" name="nom_reservation" required>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'admin')
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="control-label">@lang('Suivi par') <span class="text-danger">*</span></label>
                                <select class="form-control form-white" id="edit_mandataire_id" name="mandataire_id" data-style="btn-warning btn-rounded" required>
                                    <option value="">@lang('Sélectionner')</option>
                                    @foreach($mandataires as $mandataire)
                                        <option value="{{$mandataire->id}}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
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
           test = $('#edit_mandataire_id option[value="'+suivi+'"]').prop("selected",true);
           console.log(test);
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

{{-- GESTION DU DATATABLE --}}
<script type="text/javascript">
$('body').addClass("sidebar-hide");

document.addEventListener('DOMContentLoaded', function() {
    // Fonction de filtrage
    function filterTable() {
        var searchText = $('#searchInput').val().toLowerCase();
        // var suiviFilter = $('#filterSuivi').val().toLowerCase();
        // var typeFilter = $('#filterType').val().toLowerCase();

        $('.custom-table tbody tr').each(function() {
            var row = $(this);
            
            // Récupérer le contenu des colonnes
            var numero = row.find('td:eq(0)').text().toLowerCase();
            var type = row.find('td:eq(1)').text().toLowerCase();
            var dates = row.find('td:eq(2)').text().toLowerCase();
            var mandant = row.find('td:eq(3)').text().toLowerCase();
            var bien = row.find('td:eq(4)').text().toLowerCase();
            var observation = row.find('td:eq(5)').text().toLowerCase();
            var suivi = @if(Auth::user()->role == 'admin') row.find('td:eq(6)').text().toLowerCase() @else '' @endif;

            // Appliquer les filtres
            var matchSearch = 
                numero.includes(searchText) ||
                type.includes(searchText) ||
                dates.includes(searchText) ||
                mandant.includes(searchText) ||
                bien.includes(searchText) ||
                observation.includes(searchText) ||
                suivi.includes(searchText);

            // var matchSuivi = suiviFilter === '' || suivi.includes(suiviFilter);
            // var matchType = typeFilter === '' || type.includes(typeFilter);

            // Afficher/masquer la ligne
            // row.toggle(matchSearch && matchSuivi && matchType);
            row.toggle(matchSearch );
        });

        // Mettre à jour le compteur
        updateCounter();
    }

    function updateCounter() {
        var total = $('.custom-table tbody tr').length;
        var visible = $('.custom-table tbody tr:visible').length;
        $('.result-count').text(visible + ' sur ' + total + ' mandats');
    }

    // Événements de filtrage
    $('#searchInput').on('input', function() {
        filterTable();
    });

    $('#filterSuivi, #filterType').on('change', function() {
        filterTable();
    });


    // Initialisation
    updateCounter();

    // Tri des colonnes
    let currentSort = { column: '', direction: 'asc' };

    $('.sortable').click(function() {
        const column = $(this).data('column');
        const index = $(this).index();
        
        // Inverser la direction si même colonne
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'asc';
        }

        // Mise à jour visuelle
        $('.sortable').removeClass('sorting-active sorting-asc');
        $(this).addClass('sorting-active');
        if (currentSort.direction === 'desc') {
            $(this).addClass('sorting-asc');
        }

        // Tri des lignes
        const rows = $('.custom-table tbody tr').get();
        rows.sort(function(a, b) {
            let A = $(a).children('td').eq(index).text().trim();
            let B = $(b).children('td').eq(index).text().trim();

            // Conversion pour les nombres (comme les numéros de mandat)
            if (column === 'numero') {
                A = parseInt(A) || 0;
                B = parseInt(B) || 0;
            }

            if (A < B) return currentSort.direction === 'asc' ? -1 : 1;
            if (A > B) return currentSort.direction === 'asc' ? 1 : -1;
            return 0;
        });

        // Réinsertion des lignes triées
        $.each(rows, function(index, row) {
            $('.custom-table tbody').append(row);
        });
    });

});
</script>

@endsection

<style>
.btn-addon {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    margin: 10px 5px;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-addon i {
    margin-right: 8px;
    font-size: 16px;
}

.btn-addon:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Ajustements spécifiques pour chaque type de bouton */
.btn-success.btn-addon {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.btn-info.btn-addon {
    background-color: #36b9cc;
    border-color: #36b9cc;
}

.btn-warning.btn-addon {
    background-color: #f6c23e;
    border-color: #f6c23e;
    color: #fff;
}

/* Hover states */
.btn-success.btn-addon:hover {
    background-color: #169b6b;
    border-color: #169b6b;
}

.btn-info.btn-addon:hover {
    background-color: #2a94a5;
    border-color: #2a94a5;
}

.btn-warning.btn-addon:hover {
    background-color: #dda20a;
    border-color: #dda20a;
    color: #fff;
}
</style>

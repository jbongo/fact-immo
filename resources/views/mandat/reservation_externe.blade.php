<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réservation de mandat</title>
    <!-- CSS from header -->
    <link href="{{ asset('css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .reservation-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .reservation-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .reservation-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-block {
            margin-top: 15px;
            width: 100%;
        }
        #new-reservation-form {
            margin-top: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
        }
        .reservation-item .btn {
            margin-top: 10px;
        }
        .swal-content {
            margin-top: 20px;
        }
        .swal-content .form-group {
            margin-bottom: 15px;
        }
        .swal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .swal-content .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        #modification-message {
            margin-top: -15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <a href="/" class="btn btn-primary home-button">
        <i class="ti-home"></i> Retour à l'accueil
    </a>

    <div class="reservation-container">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Réservation de mandat</h3>
            </div>
            <div class="card-body">
                <!-- Étape 1: Saisie du code client -->
                <div id="step1" style="width: 500px; margin: 0 auto; margin-top: 30px;">
                    <div class="form-group">
                        <label>Code client</label>
                        <input type="text" class="form-control" id="code_client" required>
                    </div>
                    <button class="btn btn-primary btn-block" onclick="checkCode()">Vérifier</button>
                </div>

                <!-- Étape 2: Liste des réservations ou nouvelle réservation -->
                <div id="step2" style="display: none;">
                    <div class="col-md-12">
                        <div id="reservations-list"></div>
                    </div>
                    <div class="col-sm-8">
                        <div id="new-reservation-form">
                        <h4 class="mb-4">Créer une nouvelle réservation</h4>
                            <div class="form-group">
                                <label>Nom de la réservation</label>
                                <input type="text" class="form-control" name="nom_reservation" id="nom_reservation" required>
                            </div>
                            <button class="btn btn-success btn-block" onclick="createReservation()">
                                Créer la réservation
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Message de succès -->
                <div id="success-message" style="display: none;" class="alert alert-success text-center">
                    <h4 class="alert-heading mb-3"></h4>
                    <p class="mb-2"></p>
                    <hr>
                    <p class="mb-0">Vous pouvez maintenant vous connecter à la plateforme pour compléter votre mandat.</p>
                </div>

                <!-- Ajouter un div pour le message de modification -->
                <div id="modification-message" style="display: none;" class="alert alert-success text-center mb-4"></div>
            </div>
        </div>
    </div>

    <!-- Ajouter le modal après la div reservation-container -->
    <div class="modal fade" id="modalModification" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la réservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formModification">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nom de la réservation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nouveau_nom" id="nouveau_nom" required>
                            <input type="hidden" id="reservation_id">
                            <input type="hidden" id="reservation_numero">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts from footer -->
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/sweetalert2.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function checkCode() {
            let code = $('#code_client').val();
            if (!code) {
                swal({
                    title: "Erreur",
                    text: "Veuillez saisir un code client",
                    icon: "error"
                });
                return;
            }

            $.ajax({
                url: '{{ route("check.code") }}',
                method: 'POST',
                data: { code_client: code },
                success: function(response) {
                    $('#step1').hide();
                    $('#step2').show();
                    
                    if(response.reservations.length > 0) {
                        let html = '<h4 class="mb-4">Réservations existantes</h4>';
                        let rowCount = 0;
                        response.reservations.forEach(function(reservation, index) {
                            if (index % 6 === 0) {
                                if (rowCount > 0) {
                                    html += '</div>';
                                }
                                html += '<div class="row">';
                                rowCount++;
                            }
                            html += `
                                <div class="col-md-4 reservation-item">
                                    <h5>Réservation #${reservation.numero}</h5>
                                    <p class="mb-3">${reservation.nom_reservation}</p>
                                    <button class="btn btn-info" onclick="recupererReservation(${reservation.id}, '${reservation.numero}', '${reservation.nom_reservation}')">
                                        <i class="ti-pencil"></i> Récupérer cette réservation
                                    </button>
                                </div>
                            `;
                        });
                        if (rowCount > 0) {
                            html += '</div>';
                        }

                        $('#reservations-list').html(html);
                    }
                },
                error: function(xhr) {
                    swal({
                        title: "Erreur",
                        text: xhr.responseJSON?.message+", veuillez réessayer" || "Code client invalide, veuillez réessayer",
                        icon: "error"
                    })
                    .then(function() {
                        window.location.reload();
                    });
                }
            });
        }

        function recupererReservation(id, numero, nom) {
            // Remplir le formulaire
            $('#nouveau_nom').val(nom);
            $('#reservation_id').val(id);
            $('#reservation_numero').val(numero);
            
            // Afficher le modal
            $('#modalModification').modal('show');
        }

        // Gérer la soumission du formulaire
        $('#formModification').on('submit', function(e) {
            e.preventDefault();
            
            let id = $('#reservation_id').val();
            let numero = $('#reservation_numero').val();
            let nouveauNom = $('#nouveau_nom').val();

            if (!nouveauNom) {
                swal({
                    title: "Erreur",
                    text: "Le nom ne peut pas être vide",
                    icon: "error"
                });
                return;
            }

            $.ajax({
                url: '/mandats/update-reservation-externe/' + id,
                method: 'POST',
                data: {
                    nom_reservation: nouveauNom
                },
                success: function(response) {
                    // Fermer le modal
                    $('#modalModification').modal('hide');

                    // Afficher le message de succès
                    $('#modification-message')
                        .html(`La réservation #${numero} a été modifiée avec le nouveau nom : <strong>${nouveauNom}</strong>`)
                        .show();

                    // Mettre à jour l'affichage de la réservation dans le bloc
                    $(`.reservation-item:has(button[onclick*="recupererReservation(${id}"])`)
                        .find('p')
                        .text(nouveauNom);

                    // Mettre à jour l'attribut onclick du bouton
                    $(`.reservation-item button[onclick*="recupererReservation(${id}"]`)
                        .attr('onclick', `recupererReservation(${id}, '${numero}', '${nouveauNom}')`);

                    // Faire défiler jusqu'au message
                    $('#modification-message')[0].scrollIntoView({ behavior: 'smooth' });
                },
                error: function(xhr) {
                    swal({
                        title: "Erreur",
                        text: xhr.responseJSON?.message+", veuillez réessayer" || "Une erreur est survenue, veuillez réessayer",
                        icon: "error"
                    })
                    .then(function() {
                        window.location.reload();
                    });
                }
            });
        });

        function createReservation() {
            let nom = $('#nom_reservation').val();
            if (!nom) {
                swal({
                    title: "Erreur",
                    text: "Veuillez saisir un nom pour la réservation",
                    icon: "error"
                });
                return;
            }

            $.ajax({
                url: '{{ route("reserver.externe") }}',
                method: 'POST',
                data: {
                    code_client: $('#code_client').val(),
                    nom_reservation: nom
                },
                success: function(response) {
                    $('#step2').hide();
                    $('#success-message')
                        .find('.alert-heading').text('Réservation créée avec succès !').end()
                        .find('p:first').html(`Numéro de mandat: <strong>${response.numero_mandat}</strong>`).end()
                        .show();
                },
                error: function(xhr) {
                    swal({
                        title: "Erreur",
                        text: xhr.responseJSON?.message || "Une erreur est survenue, veuillez réessayer",
                        icon: "error"
                    })
                    .then(function() {
                        window.location.reload();
                    });
                }
            });
        }
    </script>
</body>
</html> 
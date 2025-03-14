@extends('layouts.app')
@section('content')
@section('page_title')
    <a href="{{ route('mandat.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Paramètres des mandats
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="ti-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un mandataire...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tableParametres" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mandataire</th>
                                <th>Quota mandats non retournés</th>
                                <th>Mandats non retournés</th>
                                <th>Quota réservations</th>
                                <th>Réservations en cours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            @php
                                $mandataire = \App\User::find($user->user_id);
                                $nbMandatsNonRetournes = \App\Mandat::nonRetournesParUser($user->user_id)->count();
                                if($mandataire){
                                    $nbReservations = $mandataire->nombreReservations();
                                }else{
                                    $nbReservations = 0;
                                }
                            @endphp
                            <tr>
                                <td>{{ $user->nom }} {{ $user->prenom }}</td>
                                <td>{{ $user->quota_mandats_non_retournes }}</td>
                                <td class="text-center text-danger">{{ $nbMandatsNonRetournes }}</td>
                                <td>{{ $user->quota_reservation_en_cours }}</td>
                                <td class="text-center text-danger">{{ $nbReservations }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="editParametres({{ $user->id }}, '{{ $user->nom }}', '{{ $user->prenom }}', {{ $user->quota_mandats_non_retournes }}, {{ $user->quota_reservation_en_cours }})">
                                        <i class="ti-pencil"></i> Modifier
                                    </button>
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

<!-- Modal de modification -->
<div class="modal fade" id="modalParametres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier les paramètres</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formParametres">
                <div class="modal-body">
                    <h6 id="userName" class="mb-4"></h6>
                    <div class="form-group">
                        <label>Quota mandats non retournés <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quota_mandats_non_retournes" id="quota_mandats_non_retournes" required min="0">
                    </div>
                    <div class="form-group">
                        <label>Quota réservations en cours <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quota_reservation_en_cours" id="quota_reservation_en_cours" required min="0">
                    </div>
                    <input type="hidden" id="user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js-content')
<script>
function editParametres(id, nom, prenom, quotaMandats, quotaReservations) {
    $('#user_id').val(id);
    $('#userName').text(nom + ' ' + prenom);
    $('#quota_mandats_non_retournes').val(quotaMandats);
    $('#quota_reservation_en_cours').val(quotaReservations);
    $('#modalParametres').modal('show');
}

$('#formParametres').on('submit', function(e) {
    e.preventDefault();
    
    let userId = $('#user_id').val();
    
    $.ajax({
        url: '/mandats/update-parametres/' + userId,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            quota_mandats_non_retournes: $('#quota_mandats_non_retournes').val(),
            quota_reservation_en_cours: $('#quota_reservation_en_cours').val()
        },
        success: function(response) {
            $('#modalParametres').modal('hide');
            swal({
                title: "Succès !",
                text: response.message,
                icon: "success",
            }).then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            swal({
                title: "Erreur",
                text: xhr.responseJSON?.message || "Une erreur est survenue",
                icon: "error"
            });
        }
    });
});

$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableParametres tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endsection 
@extends('layouts.app')
@section('content')
@section ('page_title')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{route('mandat.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
                <i class="ti-angle-double-left"></i>@lang('Retour')
            </a>
        </div>
        <div class="btn-group">
            <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}" class="btn btn-info btn-flat btn-addon">
                <i class="ti-pencil"></i> Modifier
            </a>
            @if($mandat->statut == 'mandat')
                @if($mandat->est_cloture)
                    <button class="btn btn-success btn-flat btn-addon btn-restaurer">
                        <i class="ti-back-right"></i> Restaurer
                    </button>
                @else
                    <button class="btn btn-danger btn-flat btn-addon btn-cloturer">
                        <i class="ti-close"></i> Clôturer
                    </button>
                @endif
            @endif
            
        </div>
    </div>
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- En-tête avec les informations principales -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h3 >
                           <span class="text-primary">Mandat N° {{ $mandat->numero }}</span> 
                            <span class="badge badge-{{ $mandat->statut == 'mandat' ? 'success' : 'warning' }}">
                                {{ ucfirst($mandat->statut) }}
                            </span>
                            @if($mandat->est_cloture)
                                <span class="badge badge-danger">Clôturé</span> @if($mandat->date_cloture)<span class="text-danger" style="font-size: 13px;">le {{ $mandat->date_cloture->format('d/m/Y') }}</span>@endif <span style="font-size: 13px;"> Motif: {{ $mandat->motif_cloture }}</span>
                            @endif
                        </h3>
                        <p class="text-muted " style="font-size: 18px; margin-bottom: 35px;">
                            <strong>Type:</strong> {{ ucfirst($mandat->type) }} | 
                            <strong>Nature:</strong> {{ str_replace('_', ' ', ucfirst($mandat->nature)) }}
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <p class="mb-1">
                            <i class="ti-calendar"></i> 
                            Du {{ $mandat->date_debut ? $mandat->date_debut->format('d/m/Y') : '-' }}
                            au {{ $mandat->date_fin ? $mandat->date_fin->format('d/m/Y') : '-' }}
                        </p>
                    </div>
                </div>

                <!-- Contenu principal en 3 colonnes -->
                <div class="row">

                    <!-- Détails du Mandat -->
                    <div class="col-lg-4">
                        <div class="info-box">
                            <div class="info-box-header bg-primary">
                                <h4><i class="ti-info-alt"></i> Détails du mandat</h4>
                            </div>
                            <div class="info-box-content">
                                <div class="info-item">
                                    <i class="ti-reload"></i>
                                    <strong>Tacite reconduction:</strong><br>
                                    {{ $mandat->duree_tacite_reconduction ? $mandat->duree_tacite_reconduction.' mois' : 'Non' }}
                                </div>
                                <div class="info-item">
                                    <i class="ti-lock"></i>
                                    <strong>Durée irrévocabilité:</strong><br>
                                    {{ $mandat->duree_irrevocabilite ? $mandat->duree_irrevocabilite.' mois' : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations du Mandant -->
                    <div class="col-lg-4">
                        <div class="info-box">
                            <div class="info-box-header bg-danger">
                                <h4><i class="ti-user"></i> Mandant</h4>
                            </div>
                            <div class="info-box-content">
                                @if($mandat->contact)
                                    @switch($mandat->contact->type_contact)
                                        @case('personne_physique')
                                            <div class="info-item">
                                                <i class="ti-id-badge"></i>
                                                {{ $mandat->contact->civilite }} {{ $mandat->contact->nom }} {{ $mandat->contact->prenom }}
                                            </div>
                                            @break
                                        @case('couple')
                                            <div class="info-item">
                                                <i class="ti-user"></i> Partenaire 1:
                                                {{ $mandat->contact->civilite_p1 }} {{ $mandat->contact->nom_p1 }} {{ $mandat->contact->prenom_p1 }}
                                            </div>
                                            <div class="info-item">
                                                <i class="ti-user"></i> Partenaire 2:
                                                {{ $mandat->contact->civilite_p2 }} {{ $mandat->contact->nom_p2 }} {{ $mandat->contact->prenom_p2 }}
                                            </div>
                                            @break
                                        @case('entreprise')
                                            <div class="info-item">
                                                <i class="ti-briefcase"></i>
                                                {{ $mandat->contact->type_entreprise }} {{ $mandat->contact->raison_sociale }}
                                            </div>
                                            @break
                                        @case('indivision')
                                            <div class="info-item">
                                                <i class="ti-layers"></i>
                                                Indivision {{ $mandat->contact->nom_indivision }}
                                            </div>
                                            @break
                                    @endswitch
                                    <div class="info-item">
                                        <i class="ti-location-pin"></i>
                                        {{ $mandat->contact->adresse }}<br>
                                        {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="ti-alert"></i> Aucun contact associé
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informations du Bien -->
                    <div class="col-lg-4">
                        <div class="info-box">
                            <div class="info-box-header bg-success">
                                <h4><i class="ti-home"></i> Bien immobilier</h4>
                            </div>
                            <div class="info-box-content">
                                @if($mandat->bien)
                                    <div class="info-item">
                                        <i class="ti-tag"></i>
                                        <strong>Type:</strong> {{ ucfirst($mandat->bien->type_bien) }}
                                    </div>
                                    <div class="info-item">
                                        <i class="ti-location-pin"></i>
                                        {{ $mandat->bien->adresse }}<br>
                                        {{ $mandat->bien->code_postal }} {{ $mandat->bien->ville }}
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="ti-alert"></i> Aucun bien associé
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-box {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.info-box:hover {
    transform: translateY(-5px);
}

.info-box-header {
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
    color: white;
}

.info-box-header h4 {
    margin: 0;
    font-size: 18px;
}

.info-box-content {
    padding: 20px;
}

.info-item {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item i {
    margin-right: 10px;
    color: #666;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    margin-left: 10px;
}

.modal-dialog {
    max-width: 400px;
}
</style>

<!-- Ajouter ce modal à la fin du fichier, avant les scripts -->
<div class="modal fade" id="modalCloture" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clôturer le mandat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCloture" action="{{ route('mandat.cloturer', Crypt::encrypt($mandat->id)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Raison de la clôture <span class="text-danger">*</span></label>
                        <select class="form-control" name="raison_cloture" id="raison_cloture" required>
                            <option value="">Sélectionner une raison</option>
                            <option value="Vente réalisée">Vente réalisée</option>
                            <option value="Résiliation">Résiliation</option>
                            <option value="Sans suite">Sans suite</option>
                            <option value="Fin de mandat">Fin de mandat</option>
                            <option value="autre">Autre raison</option>
                        </select>
                    </div>
                    <div class="form-group" id="autre_raison_div" style="display: none;">
                        <label>Précisez la raison <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="autre_raison" id="autre_raison" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Clôturer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajouter le modal de confirmation de restauration -->
<div class="modal fade" id="modalRestaurer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Restaurer le mandat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRestaurer" action="{{ route('mandat.restaurer', Crypt::encrypt($mandat->id)) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir restaurer ce mandat ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Restaurer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js-content')
<script>
$(document).ready(function() {
    // Gestion du clic sur le bouton clôturer
    $('.btn-cloturer').click(function() {
        $('#modalCloture').modal('show');
    });

    // Afficher/masquer le champ autre raison
    $('#raison_cloture').change(function() {
        if($(this).val() === 'autre') {
            $('#autre_raison_div').show();
            $('#autre_raison').prop('required', true);
        } else {
            $('#autre_raison_div').hide();
            $('#autre_raison').prop('required', false);
        }
    });

    // Soumission du formulaire de clôture
    $('#formCloture').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    swal({
                        title: "Succès",
                        text: "Le mandat a été clôturé avec succès",
                        icon: "success",
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr);
                
                swal({
                    title: "Erreur",
                    text: "Une erreur est survenue lors de la clôture du mandat",
                    icon: "error",
                });
            }
        });

       
    });

     // Gestion du clic sur le bouton restaurer
     $('.btn-restaurer').click(function() {
            $('#modalRestaurer').modal('show');
        });

        // Soumission du formulaire de restauration
        $('#formRestaurer').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        swal({
                            title: "Succès",
                            text: "Le mandat a été restauré avec succès",
                            icon: "success",
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur est survenue lors de la restauration du mandat",
                        icon: "error",
                    });
                }
            });
        });
});
</script>
@endsection

@endsection
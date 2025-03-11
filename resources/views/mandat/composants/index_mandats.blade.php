<div class="row" style="margin-top: 30px;">
    <form action="{{ route('mandat.index') }}" method="GET">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="ti-search"></i></span>
                            <input type="text" id="searchInput2" name="search" class="form-control" 
                                placeholder="Rechercher..." value="{{ request()->search }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select id="filterSuivi" name="suivi" class="form-control">
                            <option value="">Tous les mandataires</option>
                            @foreach($mandataires as $mandataire)
                                <option value="{{ $mandataire->nom }} {{ $mandataire->prenom }}"
                                    {{ request()->suivi == $mandataire->nom.' '.$mandataire->prenom ? 'selected' : '' }}>
                                    {{ $mandataire->nom }} {{ $mandataire->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select id="filterType" name="type" class="form-control">
                            <option value="">Tous les types de mandat</option>
                            <option value="réservation" {{ request()->type == 'réservation' ? 'selected' : '' }}>Réservation</option>
                            <option value="mandat" {{ request()->type == 'mandat' ? 'selected' : '' }}>Mandat</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-check form-check-inline col-md-4">
                    <input class="form-check-input" type="checkbox" id="filterCloture" name="cloture"
                        {{ request()->cloture ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterCloture">Clôturés</label>
                </div>
                <div class="form-check form-check-inline col-md-4">
                    <input class="form-check-input" type="checkbox" id="filterNonRetourne" name="non_retourne"
                        {{ request()->non_retourne ? 'checked' : '' }}>
                    <label class="form-check-label" for="filterNonRetourne">Non retournés</label>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary">
                <i class="ti-search"></i> Rechercher
            </button>
            @if(request()->hasAny(['search', 'suivi', 'type', 'cloture', 'non_retourne']))
                <a href="{{ route('mandat.index') }}" class="btn btn-light ml-2">
                    <i class="ti-reload"></i> Réinitialiser
                </a>
            @endif
        </div>
    </form>
</div>
<div class="card-body">
    <div class="panel panel-info m-t-15" id="cont">
        <div class="panel-body">
            <!-- Filtres -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="ti-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compteur de résultats -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="result-count text-muted"></div>
            </div>

            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th class="text-center sortable" data-column="numero">@lang('Mandat') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable" data-column="type">@lang('Type') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable" data-column="date">@lang('Date du mandat') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable" data-column="mandant">@lang('Mandant(s)') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable" data-column="bien">@lang('Bien') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable ">@lang('État') <i class="ti-exchange-vertical"></i></th>
                            <th class="sortable" data-column="observations">@lang('Observations') <i class="ti-exchange-vertical"></i></th>
                            @if(Auth::user()->role == 'admin')
                                <th class="sortable" data-column="suivi">@lang('Suivi par') <i class="ti-exchange-vertical"></i></th>
                            @endif
                            <th class="text-center">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mandats as $mandat)
                            <tr class="align-middle" style="background-color: {{ $mandat->statut == 'réservation'  ? '#F3F3F3' : 'white' }}">
                                <td>
                                    <span class="badge badge-danger border-orange-600">{{ $mandat->numero }}</span>
                                </td>
                                <td>
                                    @if(!$mandat->type)
                                        <span class="color-primary"><strong>{{ $mandat->statut }}</strong></span>
                                    @else
                                        <span class="color-success"><strong>{{ $mandat->type }}</strong></span>
                                    @endif
                                </td>
                                <td style="color: #32ade1;">
                                    {{ $mandat->date_debut ? $mandat->date_debut->format('d/m/Y') : '' }} -
                                    {{ $mandat->date_fin ? $mandat->date_fin->format('d/m/Y') : '' }}
                                </td>
                                <td>
                                    @if($mandat->contact)
                                        @if($mandat->contact->type_contact == 'personne_physique')
                                            {{ $mandat->contact->civilite }} {{ $mandat->contact->nom }} {{ $mandat->contact->prenom }}<br>
                                            {{ $mandat->contact->adresse }} {{ $mandat->contact->code_postal }} {{ $mandat->contact->ville }}
                                        @endif
                                        {{-- Ajouter les autres cas si nécessaire --}}
                                    @else
                                        {{ $mandat->nom_reservation }}
                                    @endif
                                </td>
                                <td style="color: #e05555;">
                                    @if($mandat->bien)
                                        {{ $mandat->bien->type_bien }}<br>
                                        {{ $mandat->bien->adresse }}<br>
                                        {{ $mandat->bien->code_postal }} {{ $mandat->bien->ville }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($mandat->est_cloture)
                                        <span class="badge badge-default">Clôturé</span><br>
                                    @endif
                                    @if($mandat->statut == "mandat" && !$mandat->est_retourne)                                     
                                        <span class="badge badge-danger">Non retourné</span>
                                    @endif
                                </td>
                                <td>{{ $mandat->observation }}</td>
                                    @if(Auth::user()->role == 'admin')
                                        <td>
                                            @if($mandat->suiviPar)
                                                <a href="{{ route('switch_user', Crypt::encrypt($mandat->suivi_par_id)) }}" 
                                                data-toggle="tooltip" style="font-size: 12px"
                                                title="Se connecter en tant que {{ $mandat->suiviPar->nom }}">
                                                    {{ $mandat->suiviPar->nom }} {{ $mandat->suiviPar->prenom }}
                                                    <i class="material-icons color-success">person_pin</i>
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                <td>
                                    @if($mandat->statut != "réservation")
                                        <a href="{{ route('mandat.show', Crypt::encrypt($mandat->id)) }}" 
                                           data-toggle="tooltip" 
                                           title="Détails">
                                            <i class="large material-icons color-info">visibility</i>
                                        </a>
                                    @endif
                                    
                                    @if($mandat->statut == "réservation")
                                        <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}" 
                                           class="btn btn-dark" 
                                           title="Compléter">
                                            Compléter
                                        </a>
                                        <a href="#" 
                                            class="btn-edit-reservation" 
                                            data-id="{{ $mandat->id }}"
                                            data-nom="{{ $mandat->nom_reservation }}"
                                            data-suivi="{{ $mandat->suivi_par_id }}"
                                            title="Modifier la réservation">
                                            <i class="large material-icons color-warning">edit</i>
                                        </a>
                                    @else
                                        <a href="{{ route('mandat.edit', Crypt::encrypt($mandat->id)) }}" 
                                           data-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="large material-icons color-warning">edit</i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $mandats->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Style général du tableau */
.custom-table {
    width: 100%;
    background: #fff;
    border-radius: 8px;
    border-collapse: separate;
    border-spacing: 0;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    margin: 20px 0;
}

/* En-tête du tableau */
.custom-table thead tr {
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.custom-table th {
    font-weight: 600;
    padding: 15px 20px;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #495057;
    border-bottom: 2px solid #e9ecef;
}

/* Corps du tableau */
.custom-table td {
    padding: 15px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
    color: #495057;
    font-size: 13px;
}

/* Effet hover sur les lignes */
.custom-table tbody tr {
    transition: all 0.2s ease;
}

.custom-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* Style des badges */
.badge {
    padding: 8px 12px;
    font-weight: 500;
    font-size: 0.85rem;
    border-radius: 6px;
    letter-spacing: 0.3px;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

/* Style des boutons d'action */
.btn {
    
    /* padding: 8px 16px 8px 40px; */
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Style des icônes */
.material-icons {
    font-size: 20px;
    vertical-align: middle;
    transition: all 0.2s ease;
}

.material-icons:hover {
    transform: scale(1.1);
}

/* Style des liens */
a {
    text-decoration: none;
    color: #4e73df;
    transition: all 0.2s ease;
}

a:hover {
    color: #2e59d9;
}

/* Style de la pagination */
.pagination {
    margin-top: 30px;
    gap: 5px;
}

.page-link {
    border-radius: 6px;
    padding: 8px 16px;
    color: #4e73df;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.page-link:hover {
    background-color: #4e73df;
    color: white;
    border-color: #4e73df;
}

.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
    box-shadow: 0 2px 5px rgba(78, 115, 223, 0.2);
}

/* Style des colonnes spécifiques */
.color-primary {
    color: #4e73df;
}

.color-success {
    color: #1cc88a;
}

/* Responsive design */
@media (max-width: 768px) {
    .custom-table {
        font-size: 0.9rem;
    }
    
    .custom-table td, .custom-table th {
        padding: 10px 15px;
    }
}

/* Style des filtres */
.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group-addon {
    position: absolute;
    left: 10px;
    z-index: 10;
    color: #6c757d;
}

#searchInput {
    padding-left: 35px;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

#searchInput2 {
    padding-left: 35px;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}
#searchInput:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

select.form-control {
    border-radius: 6px;
    border: 1px solid #e9ecef;
    height: 38px;
    padding: 0 12px;
    color: #495057;
    transition: all 0.2s ease;
}

select.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

/* Style du bouton réinitialiser */
.clear-filter {
    padding: 8px 15px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    color: #666;
    transition: all 0.2s ease;
}

.clear-filter:hover {
    background-color: #e9ecef;
    color: #333;
}

.clear-filter i {
    font-size: 14px;
}

/* Style du compteur */
.result-count {
    font-size: 0.9rem;
    color: #6c757d;
    padding: 5px 0;
}

.sortable {
    cursor: pointer;
    position: relative;
}

.sortable i {
    font-size: 12px;
    margin-left: 5px;
    opacity: 0.5;
}

.sortable:hover i {
    opacity: 1;
}

.sorting-asc i {
    transform: rotate(180deg);
}

.sorting-active {
    color: #4e73df;
}

.sorting-active i {
    opacity: 1;
}
</style>
@extends('layouts.appv2')
@section('content')
@section ('page_title')
    @if($mandat->statut == 'mandat')
        Modifier le mandat {{ $mandat->numero }}
    @else
        Compléter la reservation {{ $mandat->numero }}
    @endif
@endsection

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
         <div class="col-lg-12">          
            <a href="{{route('mandat.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
               <i class="ti-angle-double-left"></i>@lang('Retour')
            </a>
         </div>
         <div class="card-body">
            <!-- MultiStep Form -->
            <div class="container-fluid" id="grad1">
                <div class="row justify-content-center mt-0">
                    <div class="col-11 col-sm-12 col-md-10 col-lg-8 text-center p-0 mt-3 mb-2">
                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                            @if($mandat->statut == 'mandat')
                                <h2><strong> Modifier le mandat {{ $mandat->numero }} </strong></h2>
                            @else
                                <h2><strong> Compléter la réservation {{ $mandat->numero }} </strong></h2>
                            @endif
                     
                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    <form id="msform" action="{{ route('mandat.update', $mandat->id) }}" method="POST">
                                        @csrf
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="infos_mandat"><strong>Infos Mandat</strong></li>
                                            <li id="mandants"><strong>Mandants</strong></li>
                                            <li id="bien"><strong>Bien</strong></li>
                                        </ul>
                                        
                                        <!-- Étape 1: Infos Mandat -->
                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Informations du Mandat</h2>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Type de Mandat <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="type_mandat" required>
                                                            <option value="vente" {{ $mandat->type == 'vente' ? 'selected' : '' }}>Mandat de Vente</option>
                                                            <option value="achat" {{ $mandat->type == 'achat' ? 'selected' : '' }}>Mandat d'Achat</option>
                                                            <option value="location" {{ $mandat->type == 'location' ? 'selected' : '' }}>Mandat de Location</option>
                                                            <option value="recherche" {{ $mandat->type == 'recherche' ? 'selected' : '' }}>Mandat de Recherche</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Nature du Mandat <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="nature_mandat" required>
                                                            <option value="simple" {{ $mandat->nature == 'simple' ? 'selected' : '' }}>Simple</option>
                                                            <option value="exclusif" {{ $mandat->nature == 'exclusif' ? 'selected' : '' }}>Exclusif</option>
                                                            <option value="semi_exclusif" {{ $mandat->nature == 'semi_exclusif' ? 'selected' : '' }}>Semi-Exclusif</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @if(Auth::user()->role == 'admin')
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Suivi par <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="suivi_par_id" required>
                                                            <option value="">Sélectionner</option>
                                                            @foreach($mandataires as $mandataire)
                                                                <option value="{{ $mandataire->id }}" {{ $mandat->suivi_par_id == $mandataire->id ? 'selected' : '' }}>
                                                                    {{ $mandataire->nom }} {{ $mandataire->prenom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date début mandat <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-white" name="date_debut" value="@if($mandat->date_debut != null){{$mandat->date_debut->format('Y-m-d')}}@endif" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date fin mandat <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-white" name="date_fin" value="@if($mandat->date_fin != null){{$mandat->date_fin->format('Y-m-d')}}@endif" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Tacite reconduction</label>
                                                        <select class="form-control form-white" name="tacite_reconduction">
                                                            <option value="0" {{ $mandat->duree_tacite_reconduction == 0 ? 'selected' : '' }}>Sans tacite reconduction</option>
                                                            @foreach([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,36,48,120,360,1188] as $mois)
                                                                <option value="{{ $mois }}" {{ $mandat->duree_tacite_reconduction == $mois ? 'selected' : '' }}>{{ $mois }} mois</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Durée irrévocabilité (en mois)</label>
                                                        <input type="number" class="form-control form-white" name="duree_irrevocabilite" min="0" value="{{ $mandat->duree_irrevocabilite }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="next" class="next action-button" value="Etape suivante"/>
                                        </fieldset>

                                        <!-- Étape 2: Mandants -->
                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Informations des Mandants</h2>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Type de Contact <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="type_contact" id="type_contact" required>
                                                            <option value="">Sélectionner</option>
                                                            <option value="contact_existant">Contact Existant</option>
                                                            <option value="personne_physique" {{ $mandat->contact && $mandat->contact->type_contact == 'personne_physique' ? 'selected' : '' }}>Personne Physique</option>
                                                            <option value="couple" {{ $mandat->contact && $mandat->contact->type_contact == 'couple' ? 'selected' : '' }}>Couple</option>
                                                            <option value="indivision" {{ $mandat->contact && $mandat->contact->type_contact == 'indivision' ? 'selected' : '' }}>Indivision</option>
                                                            <option value="entreprise" {{ $mandat->contact && $mandat->contact->type_contact == 'entreprise' ? 'selected' : '' }}>Entreprise</option>
                                                            <option value="tiers" {{ $mandat->contact && $mandat->contact->type_contact == 'tiers' ? 'selected' : '' }}>Tiers (Saisie libre)</option>
                                                        </select>
                                                    </div>
                                                    @if($mandat->statut == "mandat")
                                                    <div class="col-md-6">
                                                        <label class="control-label">Créer un nouveau contact ? </label>
                                                        <select class="form-control form-white" name="nouveau_contact" id="type_contact" required>
                                                            <option value="Non">Non</option>
                                                            <option value="Oui">Oui</option>                                                           
                                                        </select>                                                       
                                                       
                                                    </div>
                                                    
                                                        
                                                    @endif
                                                </div>
                                                <hr>
                                                <div id="contact_forms">
                                                    <!-- Le contenu sera chargé dynamiquement avec les données existantes -->
                                                </div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                                            <input type="button" name="next" class="next action-button" value="Etape suivante"/>
                                        </fieldset>

                                        <!-- Étape 3: Bien -->
                                        <fieldset>
                                            <div class="form-card">
                                                <h2 class="fs-title">Information du Bien</h2>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Type de Bien <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="type_bien" required>
                                                            <option value="">Sélectionner</option>
                                                            <option value="maison" {{ $mandat->bien && $mandat->bien->type_bien == 'maison' ? 'selected' : '' }}>Maison</option>
                                                            <option value="appartement" {{ $mandat->bien && $mandat->bien->type_bien == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Adresse <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="adresse_bien" value="{{ $mandat->bien ? $mandat->bien->adresse : '' }}" required/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="code_postal_bien" value="{{ $mandat->bien ? $mandat->bien->code_postal : '' }}" required/>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="control-label">Ville <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="ville_bien" value="{{ $mandat->bien ? $mandat->bien->ville : '' }}" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                                            <input type="submit" class="next action-button" value="Valider"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>



<style>

* {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}

#grad1 {
    background-color: : #fafafa;
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E
}

#msform input, #msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus, #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 150px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

#msform .action-button-previous {
    width: 150px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey
}

#progressbar .active {
    color: #000000
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 33%;
    float: left;
    position: relative
}

#progressbar #infos_mandat:before {
    font-family: FontAwesome;
    content: "\f023"
}

#progressbar #mandants:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #bien:before {
    font-family: FontAwesome;
    content: "\f015"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before, #progressbar li.active:after {
    background: skyblue
}

.radio-group {
    position: relative;
    margin-bottom: 25px
}

.radio {
    display: inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor: pointer;
    margin: 8px 2px
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
}

.fit-image {
    width: 100%;
    object-fit: cover
}
</style>


@endsection

@section('js-content')
@include('mandat.partials.form_scripts')

<script>
$(document).ready(function() {
    // Navigation entre les étapes
    var current_fs, next_fs, previous_fs;
    var opacity;

    $(".next").click(function(){
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        // Vérifier si tous les champs requis sont remplis
        var isValid = true;
        current_fs.find('input[required], select[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">Ce champ est obligatoire</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });

        if (!isValid) {
            return false;
        }

        // Activer l'étape suivante dans la barre de progression
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        next_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    $(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        previous_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    // Gestion du changement de type de contact
    $('#type_contact').on('change', function() {
        let type = $(this).val();
        if(type === 'contact_existant') {
            loadExistingContacts();
        } else {
            loadContactForm(type);
        }
    });

    // Validation des dates
    $('input[name="date_fin"], input[name="date_debut"]').on('change', function() {
        let dateDebut = new Date($('input[name="date_debut"]').val());
        let dateFin = new Date($('input[name="date_fin"]').val());
        
        if(dateDebut && dateFin && dateDebut > dateFin) {
            swal({
                title: "Erreur",
                text: "La date de début ne peut pas être supérieure à la date de fin",
                icon: "error",
            });
            $(this).val('');
            return false;
        }
    });

    // Charger et pré-remplir le formulaire de contact
    function loadContactFormWithData() {
        let contact = @json($mandat->contact);
        if(!contact) return;
        
        $('#type_contact').val(contact.type_contact);
        loadContactForm(contact.type_contact);
        
        setTimeout(() => {
            switch(contact.type_contact) {
                case 'personne_physique':
                    $('[name="civilite"]').val(contact.civilite);
                    $('[name="nom"]').val(contact.nom);
                    $('[name="prenom"]').val(contact.prenom);
                    $('[name="email"]').val(contact.email);
                    $('[name="telephone"]').val(contact.telephone);
                    $('[name="adresse"]').val(contact.adresse);
                    $('[name="code_postal"]').val(contact.code_postal);
                    $('[name="ville"]').val(contact.ville);
                    break;
                    
                case 'couple':
                    $('[name="civilite_p1"]').val(contact.civilite_p1);
                    $('[name="nom_p1"]').val(contact.nom_p1);
                    $('[name="prenom_p1"]').val(contact.prenom_p1);
                    $('[name="email_p1"]').val(contact.email_p1);
                    $('[name="telephone_p1"]').val(contact.telephone_p1);
                    $('[name="adresse_p1"]').val(contact.adresse_p1);
                    $('[name="code_postal_p1"]').val(contact.code_postal_p1);
                    $('[name="ville_p1"]').val(contact.ville_p1);
                    
                    $('[name="civilite_p2"]').val(contact.civilite_p2);
                    $('[name="nom_p2"]').val(contact.nom_p2);
                    $('[name="prenom_p2"]').val(contact.prenom_p2);
                    $('[name="email_p2"]').val(contact.email_p2);
                    $('[name="telephone_p2"]').val(contact.telephone_p2);
                    $('[name="adresse_p2"]').val(contact.adresse_p2);
                    $('[name="code_postal_p2"]').val(contact.code_postal_p2);
                    $('[name="ville_p2"]').val(contact.ville_p2);
                    break;
                    
                case 'entreprise':
                    $('[name="type_entreprise"]').val(contact.type_entreprise);
                    $('[name="raison_sociale"]').val(contact.raison_sociale);
                    $('[name="telephone_entreprise"]').val(contact.telephone);
                    $('[name="email_entreprise"]').val(contact.email);
                    $('[name="adresse_entreprise"]').val(contact.adresse);
                    $('[name="code_postal_entreprise"]').val(contact.code_postal);  
                    $('[name="ville_entreprise"]').val(contact.ville);
                    
                    break;

                case 'indivision':
                    $('[name="nom_indivision"]').val(contact.nom_indivision);
                    $('[name="nom"]').val(contact.nom);
                    $('[name="adresse_indivision"]').val(contact.adresse);
                    $('[name="code_postal_indivision"]').val(contact.code_postal);
                    $('[name="ville_indivision"]').val(contact.ville);
                    break;

                case 'tiers':
                    $('[name="nom_tiers"]').val(contact.nom);
                    $('[name="adresse_tiers"]').val(contact.adresse);
                    $('[name="code_postal_tiers"]').val(contact.code_postal);
                    $('[name="ville_tiers"]').val(contact.ville);
                    break;
                case 'contact_existant':
                    html = getContactExistantForm();
                    // Charger les contacts
                    $.get("{{ route('contacts.list') }}", function(data) {
                        let select = $('#contact_existant');
                        select.empty();
                        select.append('<option value="">Sélectionner un contact</option>');
                        
                        data.forEach(function(contact) {
                        switch(contact.type_contact) {
                            case 'entreprise':
                                nomComplet = contact.type_entreprise + ' ' + contact.raison_sociale;
                                break;
                            case 'indivision':
                                nomComplet = "Indivision "+ contact.nom_indivision ;
                                break;
                            case 'couple':
                                nomComplet = "Couple " + contact.nom_p1 + ' ' + contact.prenom_p1 + ' & ' + contact.nom_p2 + ' ' + contact.prenom_p2;
                                break;
                            case 'personne_physique':
                                nomComplet = contact.civilite + ' ' + contact.nom + ' ' + contact.prenom;
                                break;
                    
                            default:
                                nomComplet = contact.nom + ' ' ;
                                break;
                        }

                            
                            select.append(`<option value="${contact.id}">${nomComplet}</option>`);
                        });
                    });
                    break;
                    }
                    
        }, 100);
    }

    // Charger initialement le formulaire de contact
    if($('#type_contact').val()) {
        loadContactForm($('#type_contact').val());
        loadContactFormWithData();
    }

    // Charger les contacts existants
    function loadExistingContacts() {
        $.ajax({
            url: "{{ route('contacts.list') }}",
            method: 'GET',
            success: function(contacts) {
                let html = `
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Sélectionner un contact <span class="text-danger">*</span></label>
                            <select class="form-control form-white" name="contact_id" id="contact_existant" required>
                                <option value="">Sélectionner un contact</option>
                                ${contacts.map(contact => {
                                    let selected = ({{ $mandat->contact_id ?? 'null' }} == contact.id) ? 'selected' : '';
                                    let displayName = '';
                                    if(contact.type_contact === 'personne_physique') {
                                        displayName = `${contact.civilite} ${contact.nom} ${contact.prenom}`;
                                    } else if(contact.type_contact === 'entreprise') {
                                        displayName = contact.raison_sociale;
                                    } else if(contact.type_contact === 'couple') {
                                        displayName = `${contact.nom_p1} ${contact.prenom_p1} et ${contact.nom_p2} ${contact.prenom_p2}`;
                                    }else if(contact.type_contact === 'indivision') {
                                        displayName = "Indivision "+ contact.nom_indivision ;
                                    }
                                    return `<option value="${contact.id}" ${selected}>${displayName}</option>`;
                                }).join('')}
                            </select>
                        </div>
                    </div>
                `;
                $('#contact_forms').html(html);
            }
        });
    }

    // Si le contact est un contact existant, sélectionner l'option appropriée
    if({{ $mandat->contact_id ?? 'null' }} !== null) {
        if($('#type_contact').val() === '') {
            $('#type_contact').val('contact_existant');
            loadExistingContacts();
        }
    }

    // Gestion de la soumission du formulaire
    $('#msform').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                let errorMessage = '';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = '<div style="text-align: left;">';
                    Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                        errorMessage += `<p style="margin: 0;"><strong>${key}:</strong> ${xhr.responseJSON.errors[key][0]}</p>`;
                    });
                    errorMessage += '</div>';
                }
                swal({
                    title: "Erreur",
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML: errorMessage
                        }
                    },
                    icon: "error",
                });
            }
        });
    });
});
</script>
@endsection
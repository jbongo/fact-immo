@extends('layouts.appv2')
@section('content')
@section ('page_title')
    Ajouter un mandat
@endsection
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      @if (session('ok'))
      <div class="alert alert-success alert-dismissible fade in">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong> {{ session('ok') }}</strong>
      </div>
      @endif      
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
                            <h2><strong>Ajoutez votre mandat</strong></h2>
                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    <form id="msform" action="{{route('mandat.store')}}" method="post" >
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
                                                            <option value="">Sélectionner</option>
                                                            <option value="vente">Mandat de Vente</option>
                                                            <option value="achat">Mandat d'Achat</option>
                                                            <option value="location">Mandat de Location</option>
                                                            <option value="recherche">Mandat de Recherche</option>


                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Nature du Mandat <span class="text-danger">*</span></label>
                                                        <select class="form-control form-white" name="nature_mandat" required>
                                                            <option value="">Sélectionner</option>
                                                            <option value="simple">Simple</option>
                                                            <option value="exclusif">Exclusif</option>
                                                            <option value="semi_exclusif">Semi-Exclusif</option>
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
                                                                <option value="{{ $mandataire->id }}">{{ $mandataire->nom }} {{ $mandataire->prenom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date début mandat <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-white" name="date_debut" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Date fin mandat <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-white" name="date_fin" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Tacite reconduction</label>
                                                        <select class="form-control form-white" name="tacite_reconduction">
                                                            <option value="0">Sans tacite reconduction</option>
                                                            @foreach([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,36,48,120,360,1188] as $mois)
                                                                <option value="{{ $mois }}">{{ $mois }} mois</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Durée irrévocabilité (en mois)</label>
                                                        <input type="number" class="form-control form-white" name="duree_irrevocabilite" min="0">
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
                                                            <option value="personne_physique">Personne Physique</option>
                                                            <option value="couple">Couple</option>
                                                            <option value="indivision">Indivision</option>
                                                            <option value="entreprise">Entreprise</option>
                                                            <option value="tiers">Tiers (Saisie libre)</option>
                                                            <option value="contact_existant">Contact Existant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- Les différents formulaires seront affichés ici selon le type sélectionné -->
                                                <div id="contact_forms">
                                                    <!-- Le contenu sera chargé dynamiquement -->
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
                                                            <option value="maison">Maison</option>
                                                            <option value="appartement">Appartement</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Adresse <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="adresse_bien" required/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="code_postal_bien" required/>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="control-label">Ville <span class="text-danger">*</span></label>
                                                        <input class="form-control form-white" type="text" name="ville_bien" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                                            {{-- <input type="submit" class="action-button" value="Valider"/> --}}
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

@stop
@section('js-content')
<script>
$(document).ready(function(){
    
    var current_fs, next_fs, previous_fs;
    var opacity;
    
    $(".next").click(function(){
        current_fs = $(this).parent();
        
        // Si on est sur la première étape, vérifier les dates
        if(current_fs.find('input[name="date_debut"]').length) {
            let dateDebut = new Date($('input[name="date_debut"]').val());
            let dateFin = new Date($('input[name="date_fin"]').val());
            
            if(dateDebut > dateFin) {
                swal({
                    title: "Erreur",
                    text: "La date de début ne peut pas être supérieure à la date de fin",
                    icon: "error",
                });
                return false;
            }
        }

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

        // Si tout est valide, on passe à l'étape suivante
        next_fs = $(this).parent().next();
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
    
    // Supprimer les messages d'erreur quand l'utilisateur commence à saisir
    $(document).on('input', 'input[required], select[required]', function() {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });

    // Ajouter du style pour les champs invalides
    $('<style>')
        .text(`
            .is-invalid {
                border-color: #dc3545 !important;
                border-width: 2px !important;
            }
            .invalid-feedback {
                color: #dc3545;
                font-size: 80%;
                margin-top: -20px;
                margin-bottom: 20px;
            }
        `)
        .appendTo('head');

    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    
    $(".submit").click(function(){
        return false;
    });

    // Gestion du changement de type de contact
    $('#type_contact').change(function() {
        loadContactForm($(this).val());
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
            $(this).val(''); // Réinitialise le champ
            return false;
        }
    });

    // Gestion de la soumission du formulaire
    $('#msform').on('submit', function(e) {
        e.preventDefault();
        
        let dateDebut = new Date($('input[name="date_debut"]').val());
        let dateFin = new Date($('input[name="date_fin"]').val());
        
        if(dateDebut > dateFin) {
            swal({
                title: "Erreur",
                text: "La date de début ne peut pas être supérieure à la date de fin",
                icon: "error",
            });
            return false;
        }

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
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else {
                    errorMessage = "Une erreur est survenue lors de la création du mandat";
                }
                console.log(errorMessage);
                console.log(xhr.responseJSON);
                
                
                swal({
                    title: "Erreur",
                    text: errorMessage,
                    icon: "error",
                    html: true,
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML: errorMessage
                        }
                    }
                });
            }
        });
    });
});

// Fonction pour charger le formulaire approprié
function loadContactForm(type) {
    let html = '';
    switch(type) {
        case 'personne_physique':
            html = getPersonnePhysiqueForm();
            break;
        case 'couple':
            html = getCoupleForm();
            break;
        case 'indivision':
            html = getIndivisionForm();
            break;
        case 'entreprise':
            html = getEntrepriseForm();
            break;
        case 'tiers':
            html = getTiersForm();
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
                        nomComplet = "Indivision "+ contact.nom_indivision;
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
    $('#contact_forms').html(html);
}

// Fonctions pour générer les différents formulaires
function getPersonnePhysiqueForm() {
    return `
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Civilité <span class="text-danger">*</span></label>
                <select class="form-control form-white" name="civilite" required>
                    <option value="M">Monsieur</option>
                    <option value="Mme">Madame</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Nom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="nom" required/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Prénom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="prenom" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Adresse <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="adresse" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="code_postal" required/>
            </div>
            <div class="col-md-8">
                <label class="control-label">Ville <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="ville" required/>
            </div>
        </div>
    `;
}

function getCoupleForm() {
    return `
        <h4>Partenaire 1</h4>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Civilité <span class="text-danger">*</span></label>
                <select class="form-control form-white" name="civilite_p1" required>
                    <option value="M">Monsieur</option>
                    <option value="Mme">Madame</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Nom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="nom_p1" required/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Prénom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="prenom_p1" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Téléphone</label>
                <input class="form-control form-white" type="tel" name="telephone_p1"/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Email</label>
                <input class="form-control form-white" type="email" name="email_p1"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Adresse <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="adresse_p1" required/>
            </div>
            <div class="col-md-4">
                <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="code_postal_p1" required/>
            </div>
            <div class="col-md-8">
                <label class="control-label">Ville <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="ville_p1" required/>
            </div>
        </div>

        <hr>
        <h4>Partenaire 2</h4>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Civilité <span class="text-danger">*</span></label>
                <select class="form-control form-white" name="civilite_p2" required>
                    <option value="M">Monsieur</option>
                    <option value="Mme">Madame</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Nom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="nom_p2" required/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Prénom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="prenom_p2" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Téléphone</label>
                <input class="form-control form-white" type="tel" name="telephone_p2"/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Email</label>
                <input class="form-control form-white" type="email" name="email_p2"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Adresse</label>
                <input class="form-control form-white" type="text" name="adresse_p2"/>
            </div>
            <div class="col-md-4">
                <label class="control-label">Code Postal</label>
                <input class="form-control form-white" type="text" name="code_postal_p2"/>
            </div>
            <div class="col-md-8">
                <label class="control-label">Ville</label>
                <input class="form-control form-white" type="text" name="ville_p2"/>
            </div>
        </div>
    `;
}

function getIndivisionForm() {
    return `
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Nom de l'indivision <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="nom_indivision" required/>
            </div>
        </div>
        <hr>
        <h4>Contact Principal</h4>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Nom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="nom_contact" required/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Prénom <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="prenom_contact" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Téléphone </label>
                <input class="form-control form-white" type="tel" name="telephone_contact" />
            </div>
            <div class="col-md-6">
                <label class="control-label">Email </label>
                <input class="form-control form-white" type="email" name="email_contact" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Adresse <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="adresse_contact" required/>
            </div>
            <div class="col-md-4">
                <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="code_postal_contact" required/>
            </div>
            <div class="col-md-8">
                <label class="control-label">Ville <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="ville_contact" required/>
            </div>
        </div>
    `;
}

function getEntrepriseForm() {
    return `
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Type d'entreprise <span class="text-danger">*</span></label>
                <select class="form-control form-white" name="type_entreprise" required>
                    <option value="">Sélectionner</option>
                    <option value="SA">SA</option>
                    <option value="SARL">SARL</option>
                    <option value="SAS">SAS</option>
                    <option value="EURL">EURL</option>
                    <option value="SCI">SCI</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="control-label">Raison sociale <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="raison_sociale" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Téléphone</label>
                <input class="form-control form-white" type="tel" name="telephone_entreprise"/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Email</label>
                <input class="form-control form-white" type="email" name="email_entreprise"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Adresse <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="adresse_entreprise" required/>
            </div>
            <div class="col-md-4">
                <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="code_postal_entreprise" required/>
            </div>
            <div class="col-md-8">
                <label class="control-label">Ville <span class="text-danger">*</span></label>
                <input class="form-control form-white" type="text" name="ville_entreprise" required/>
            </div>
        </div>
        <hr>
        <h4>Représentant</h4>
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Nom</label>
                <input class="form-control form-white" type="text" name="nom_representant"/>
            </div>
            <div class="col-md-6">
                <label class="control-label">Prénom</label>
                <input class="form-control form-white" type="text" name="prenom_representant"/>
            </div>
        </div>
    `;
}

function getTiersForm() {
    return `
        <div id="tiers-container">
            <div class="tiers-item">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Nom <span class="text-danger">*</span></label>
                        <input class="form-control form-white" type="text" name="nom_tiers" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Adresse <span class="text-danger">*</span></label>
                        <input class="form-control form-white" type="text" name="adresse_tiers" required/>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                        <input class="form-control form-white" type="text" name="code_postal_tiers" required/>
                    </div>
                    <div class="col-md-8">
                        <label class="control-label">Ville <span class="text-danger">*</span></label>
                        <input class="form-control form-white" type="text" name="ville_tiers" required/>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-info" id="add-tiers">Ajouter un tiers</button>
            </div>
        </div>
        -->
    `;
}

function getContactExistantForm() {
    return `
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Sélectionner un contact <span class="text-danger">*</span></label>
                <select class="form-control form-white" name="contact_id" id="contact_existant" required>
                    <option value="">Sélectionner un contact</option>
                </select>
            </div>
        </div>
    `;
}

// Ajout de l'événement pour ajouter un nouveau tiers
$(document).on('click', '#add-tiers', function() {
    const newTiers = `
        <div class="tiers-item mt-3">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">Nom <span class="text-danger">*</span></label>
                    <input class="form-control form-white" type="text" name="nom_tiers[]" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">Adresse <span class="text-danger">*</span></label>
                    <input class="form-control form-white" type="text" name="adresse_tiers[]" required/>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Code Postal <span class="text-danger">*</span></label>
                    <input class="form-control form-white" type="text" name="code_postal_tiers[]" required/>
                </div>
                <div class="col-md-8">
                    <label class="control-label">Ville <span class="text-danger">*</span></label>
                    <input class="form-control form-white" type="text" name="ville_tiers[]" required/>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger remove-tiers">Supprimer ce tiers</button>
                </div>
            </div>
        </div>
    `;
    $('#tiers-container').append(newTiers);
});

// Suppression d'un tiers
$(document).on('click', '.remove-tiers', function() {
    $(this).closest('.tiers-item').remove();
});
</script>
@endsection
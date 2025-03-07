<script>

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

function loadContactForm(type) {
    let html = '';
    switch(type) {
        case 'personne_physique':
            html = getPersonnePhysiqueForm();
            break;
        case 'couple':
            html = getCoupleForm();
            break;
        case 'entreprise':
            html = getEntrepriseForm();
            break;
        case 'indivision':
            html = getIndivisionForm();
            break;
        case 'tiers':
            html = getTiersForm();
            break;
    }
    $('#contact_forms').html(html);
}



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


});


</script> 
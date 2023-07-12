@extends('layouts.app')
@section('content')
@section('page_title')
    Ajout de Biens
@endsection
<link href="{{ asset('assets/css/multi-step.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/multi-step-style.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.7.3/themes/base/jquery-ui.css"> --}}




<style>
    #progressbar li {
        list-style-type: none;
        color: rgb(0, 0, 0);
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bolder;
        width: 14.28%;
        float: left;
        position: relative;
    }
</style>
@if (session('ok'))
    <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide2 form-horizontal" id="msform" action="{{ route('bien.store') }}"
                        enctype="multipart/form-data" method="post">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">@lang('Annonce')</li>
                            {{-- <li>@lang('Photos')</li> --}}
                            <li>@lang('Secteurs')</li>
                            <li>@lang('Composition')</li>
                            <li>@lang('Détails')</li>
                            <li>@lang('Prix / Mandat')</li>
                            <li>@lang('Photos/Diffusion')</li>
                        </ul>
                        <!-- fieldsets -->
                        @csrf

                        <fieldset>
                            <div class="row">
                                <div class="col-lg-12">

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" id="onglet_vente"
                                                href="#home">@lang('Bien à la vente')</a></li>
                                        <li><a data-toggle="tab" id="onglet_location"
                                                href="#menu1">@lang('Bien à la location')</a></li>


                                    </ul>

                                    <div class="tab-content">
                                        <div id="home" class="tab-pane fade in active">
                                            <ul class="nav nav-pills">
                                                <li class="active"><a data-toggle="pill" id="maison_vente"
                                                        href="#hom">@lang('Les maisons')</a></li>
                                                <li><a data-toggle="pill" id="appartement_vente"
                                                        href="#men1">@lang('Les appartements')</a></li>
                                                <li><a data-toggle="pill" id="terrain_vente"
                                                        href="#men2">@lang('Les terrains')</a></li>
                                                <li><a data-toggle="pill" id="autreType_vente"
                                                        href="#men3">@lang('Les autres types')</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="hom" class="tab-pane fade in active">
                                                    @include('components.biens.offre.vente.addMaison')
                                                </div>
                                                <div id="men1" class="tab-pane fade">
                                                    @include('components.biens.offre.vente.addAppartement')
                                                </div>
                                                <div id="men2" class="tab-pane fade">
                                                    @include('components.biens.offre.vente.addTerrain')
                                                </div>
                                                <div id="men3" class="tab-pane fade">
                                                    @include('components.biens.offre.vente.addAutreType')
                                                </div>

                                            </div>
                                        </div>

                                        <div id="menu1" class="tab-pane fade">
                                            <ul class="nav nav-pills">
                                                <li class="active"><a data-toggle="pill" id="maison_location"
                                                        href="#hom2">@lang('Les maisons')</a></li>
                                                <li><a data-toggle="pill" id="appartement_location"
                                                        href="#men12">@lang('Les appartements')</a></li>
                                                <li><a data-toggle="pill" id="terrain_location"
                                                        href="#men22">@lang('Les terrains')</a></li>
                                                <li><a data-toggle="pill" id="autreType_location"
                                                        href="#men32">@lang('Les autres types')</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="hom2" class="tab-pane fade in active">
                                                    @include('components.biens.offre.location.addMaison')
                                                </div>
                                                <div id="men12" class="tab-pane fade">
                                                    @include('components.biens.offre.location.addAppartement')
                                                </div>
                                                <div id="men22" class="tab-pane fade">
                                                    @include('components.biens.offre.location.addTerrain')
                                                </div>
                                                <div id="men32" class="tab-pane fade">
                                                    @include('components.biens.offre.location.addAutreType')
                                                </div>

                                            </div>


                                        </div>

                                    </div>


                                </div>
                                <!-- /# column -->


                            </div>
                            <input type="button" name="next" class="next action-button" value="Suivant" />
                        </fieldset>

                        {{-- SECTEUR --}}
                        <fieldset>
                            <div class="row">

                                <!-- /# column -->

                                @include('components.biens.secteur.add')

                                <!-- /# column -->
                            </div>
                            <input type="button" name="previous" class="previous action-button" value="Précedent" />
                            <input type="button" name="next" class="next action-button" value="Suivant" />
                        </fieldset>
                        {{-- composition --}}
                        <fieldset>
                            <div class="row">

                                <!-- /# column -->
                                <div class="col-lg-12 col-md-12">

                                    @include('components.biens.composition.add')
                                </div>
                                <!-- /# column -->
                            </div>
                            <input type="button" name="previous" class="previous action-button"
                                value="Précedent" />
                            <input type="button" name="next" class="next action-button" value="Suivant" />
                        </fieldset>

                        {{-- DETAILS --}}
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-12">

                                    @include('components.biens.details.add')
                                </div>

                            </div>
                            <input type="button" name="previous" class="previous action-button"
                                value="Précedent" />
                            <input type="button" name="next" class="next action-button" value="Suivant" />
                        </fieldset>

                        {{-- PRIX --}}
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-12">

                                    @include('components.biens.prix.add')
                                </div>

                            </div>
                            <input type="button" name="previous" class="previous action-button"
                                value="Précedent" />
                            <input type="button" name="next" class="next action-button" value="Suivant" />
                        </fieldset>

                        {{-- PHOTOS --}}
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-6">



                                </div>
                                <!-- /# column -->
                            </div>
                            <input type="button" name="previous" class="previous action-button"
                                value="Précedent" />
                            <input type="submit" name="next" id="submit" class="next action-button"
                                value="Ajouter Photos">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-content')
<script src="{{ asset('js/autocomplete_cp_ville.js') }}"></script>
<script src={{ 'https://code.jquery.com/ui/1.13.2/jquery-ui.js' }}></script>
<script>
    function viderFormulaire(id) {
        $(id).click(function() {
            $('#msform')[0].reset();

            // onglet location ou vente
            if (id == "#onglet_vente") {
                $(':input[name="type_offre"]').attr('value', 'vente');
            } else if (id == "#onglet_location") {
                $(':input[name="type_offre"]').attr('value', 'location');
            }
            // fin  

            // choix du type de bien  en fonction de l'onglet où clique l'utilisateur
            if (id == "#maison_vente") {
                $(':input[name="type_bien"]').attr('value', 'maison');
            } else if (id == "#appartement_vente") {
                $(':input[name="type_bien"]').attr('value', 'appartement');
            } else if (id == "#terrain_vente") {
                $(':input[name="type_bien"]').attr('value', 'terrain');
            } else if (id == "#autreType_vente") {
                $(':input[name="type_bien"]').attr('value', 'autreType');
            } else if (id == "#maison_location") {
                $(':input[name="type_bien"]').attr('value', 'maison');
            } else if (id == "#appartement_location") {
                $(':input[name="type_bien"]').attr('value', 'appartement');
            } else if (id == "#terrain_location") {
                $(':input[name="type_bien"]').attr('value', 'terrain');
            } else if (id == "#autreType_location") {
                $(':input[name="type_bien"]').attr('value', 'autreType');
            }

        });
    }

    viderFormulaire("#onglet_vente");
    viderFormulaire("#onglet_location");

    // pour l'onglet vente
    viderFormulaire("#appartement_vente");
    viderFormulaire("#maison_vente");
    viderFormulaire("#terrain_vente");
    viderFormulaire("#autreType_vente");
    // pour l'onglet location
    viderFormulaire("#appartement_location");
    viderFormulaire("#maison_location");
    viderFormulaire("#terrain_location");
    viderFormulaire("#autreType_location");
</script>



<script>
    function modifierFichier(btn_mod, div_mod, input_name) {
        $(btn_mod).click(function() {
            $(btn_mod).fadeOut(300);
            $(div_mod).append('<input class="form-control" id="' + btn_mod + '" type="file" name="' +
                input_name + '">');
        });
    }

    modifierFichier("#mod_carte_pro", "#mod_carte_pro_content", "carte_pro");
    modifierFichier("#mod_attestation_assu", "#mod_attestation_assu_content", "attestation_assurance");
    modifierFichier("#mod_registre_commerce", "#mod_registre_commerce_content", "registre_commerce");
    modifierFichier("#rib_banque", "#rib_banque_content", "rib_banque");
    modifierFichier("#livret_famille", "#livret_famille_content", "livret_famille");
    modifierFichier("#piece_identite", "#piece_identite_content", "piece_identite");
</script>



<script>
    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;

    $(".next").click(function() {

        //validation
        var form = $(".form-valide2");
        form.validate({
            errorClass: "invalid-feedback animated fadeInDown",
            errorElement: "div",
            errorPlacement: function(e, a) {
                jQuery(a).parents(".form-group > div").append(e)
            },
            highlight: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            },
            success: function(e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            },
            rules: {
                "choice-marital": {
                    required: !0
                },
                "corps-doc": {
                    required: !0,
                    extension: "pdf|jpeg|docx|doc|png",
                    filesize: 5097152
                }
            },
            messages: {
                "birth-country": "Le pays de naissance doit etre saisi !",
                "corps-doc": "Veillez choisir un fichier valide pour l'attestation d'immatriculation !"
            }
        });


        if (form.valid() == true) {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    scale = 1 - (1 - now) * 0.2;
                    left = (now * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 0,
                complete: function() {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        }

        // numero de dossier
        var numero_dossier = "";
        var date_creation_dossier = "";

        if ($(':input[name="type_offre"]').val() == "vente") {
            if ($(':input[name="type_bien"]').val() == "maison") {
                numero_dossier = $('#numero_dossier_vente_maison').val();
                date_creation_dossier = $('#date_creation_dossier_vente_maison').val();
            } else if ($(':input[name="type_bien"]').val() == "appartement") {
                numero_dossier = $('#numero_dossier_vente_appart').val();
                date_creation_dossier = $('#date_creation_dossier_vente_appart').val();
            }
            if ($(':input[name="type_bien"]').val() == "terrain") {
                numero_dossier = $('#numero_dossier_vente_terrain').val();
                date_creation_dossier = $('#date_creation_dossier_vente_terrain').val();
            }
            if ($(':input[name="type_bien"]').val() == "autreType") {
                numero_dossier = $('#numero_dossier_vente_autreType').val();
                date_creation_dossier = $('#date_creation_dossier_vente_autreType').val();
            }
        } else if ($(':input[name="type_offre"]').val() == "location") {
            if ($(':input[name="type_bien"]').val() == "maison") {
                numero_dossier = $('#numero_dossier_location_maison').val();
                date_creation_dossier = $('#date_creation_dossier_location_maison').val();
            } else if ($(':input[name="type_bien"]').val() == "appartement") {
                numero_dossier = $('#numero_dossier_location_appart').val();
                date_creation_dossier = $('#date_creation_dossier_location_appart').val();
            }
            if ($(':input[name="type_bien"]').val() == "terrain") {
                numero_dossier = $('#numero_dossier_location_terrain').val();
                date_creation_dossier = $('#date_creation_dossier_location_terrain').val();
            }
            if ($(':input[name="type_bien"]').val() == "autreType") {
                numero_dossier = $('#numero_dossier_location_autreType').val();
                date_creation_dossier = $('#date_creation_dossier_location_autreType').val();
            }
        }

        $('#numero_dossier_dispo').val(numero_dossier);
        $('#dossier_cree_le_dossier_dispo').val(date_creation_dossier);





    });

    $(".previous").click(function() {
        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        previous_fs.show();
        current_fs.hide();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                scale = 0.8 + (1 - now) * 0.2;
                left = ((1 - now) * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 0,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            seasing: 'easeInOutBack'
        });
    });
</script>

{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR LES VENTES -----------------------@@@@@@@@@@@@@@@ --}}

{{-- ################### Script pour formulaire Vente -> Maison #################### --}}

<script>
    $('#jardin_oui_vente_maison').hide();
    $('#piscine_oui_vente_maison').hide();

    $('input[type=radio][name=piscine_vente_maison]').change(function() {
        (this.value == 'Oui') ? $('#piscine_oui_vente_maison').slideDown(): $('#piscine_oui_vente_maison')
            .slideUp();
    });

    $('input[type=radio][name=jardin_vente_maison]').change(function() {
        (this.value == 'Oui') ? $('#jardin_oui_vente_maison').slideDown(): $('#jardin_oui_vente_maison')
            .slideUp();
    });
</script>

{{-- ################### FIN  Vente -> Maison #################### --}}



{{-- ################### Script pour formulaire Vente -> Appartement #################### --}}

<script>
    function selectImmeuble() {

        $('#div_nb_piece_vente_appart').hide();
        $('#div_nb_chambres_vente_appart').hide();
        $('#div_nombre_niveau_vente_appart').hide();
        $('#div_surface_habitable_vente_appart').hide();
        $('#div_nb_garage_vente_appart').hide();
        $('#div_exposition_situation_vente_appart').hide();
        $('#div_date_creation_dossier_vente_appart').hide();




    }

    function selectAppDupRez() {
        $('#div_nb_piece_vente_appart').show();
        $('#div_nb_chambres_vente_appart').show();
        $('#div_nombre_niveau_vente_appart').show();
        $('#div_surface_habitable_vente_appart').show();
        $('#div_nb_garage_vente_appart').show();
        $('#div_exposition_situation_vente_appart').show();
        $('#div_date_creation_dossier_vente_appart').show();
    }

    function selectLoft() {
        $('#div_nb_piece_vente_appart').show();
        $('#div_nb_chambres_vente_appart').show();
        $('#div_nombre_niveau_vente_appart').hide();
        $('#div_surface_habitable_vente_appart').show();
        $('#div_nb_garage_vente_appart').show();
        $('#div_exposition_situation_vente_appart').show();
        $('#div_date_creation_dossier_vente_appart').show();
    }

    function selectStudio() {
        $('#div_nb_piece_vente_appart').hide();
        $('#div_nb_chambres_vente_appart').hide();
        $('#div_nombre_niveau_vente_appart').hide();
        $('#div_surface_habitable_vente_appart').show();
        $('#div_nb_garage_vente_appart').show();
        $('#div_exposition_situation_vente_appart').show();
        $('#div_date_creation_dossier_vente_appart').show();
    }

    // on affiche ou masque des champs en fonction du type choisi
    $('select[name=type_appartement_vente_appart]').change(function() {
        (this.value == 'Immeuble') ? selectImmeuble(): "";
        (this.value == 'Appartement' || this.value == 'Duplex' || this.value == 'Rez de jardin') ?
        selectAppDupRez(): "";
        (this.value == 'Loft' || this.value == 'Triplex') ? selectLoft(): "";
        (this.value == 'Studio') ? selectStudio(): "";
    });
</script>

{{-- ##//////////////// FIN  Vente -> Appartement ///////////////////## --}}



{{-- ################### Script pour formulaire Vente -> Autre type #################### --}}

<script>
    $('#jardin_oui_vente_autreType').hide();
    $('#piscine_oui_vente_autreType').hide();

    $('input[type=radio][name=piscine_vente_autreType]').change(function() {
        (this.value == 'Oui') ? $('#piscine_oui_vente_autreType').slideDown(): $('#piscine_oui_vente_autreType')
            .slideUp();
    });

    $('input[type=radio][name=jardin_vente_autreType]').change(function() {
        (this.value == 'Oui') ? $('#jardin_oui_vente_autreType').slideDown(): $('#jardin_oui_vente_autreType')
            .slideUp();
    });

    $('#div_surface_vente_autreType').hide();

    function autreCabanon() {

        $('#div_surface_habitable_vente_autreType').show();
        $('#div_surface_vente_autreType').hide();
        $('#div_nb_piece_vente_autreType').show();
        $('#div_nb_chambres_vente_autreType').show();
        $('#div_nombre_niveau_vente_autreType').show();
        $('#div_jardin_vente_autreType').show();
        $('#div_surface_terrain_vente_autreType').show();
        $('#div_piscine_vente_autreType').show();
        $('#div_nb_garage_vente_autreType').show();
        $('#div_exposition_situation_vente_autreType').show();
        $('#div_date_creation_dossier_vente_autreType').show();
    }

    function caveGarage() {
        $('#div_surface_habitable_vente_autreType').hide();
        $('#div_surface_vente_autreType').show();
        $('#div_nb_piece_vente_autreType').hide();
        $('#div_nb_chambres_vente_autreType').hide();
        $('#div_nombre_niveau_vente_autreType').hide();
        $('#div_jardin_vente_autreType').hide();
        $('#div_surface_terrain_vente_autreType').hide();
        $('#div_piscine_vente_autreType').hide();
        $('#div_nb_garage_vente_autreType').hide();
        $('#div_exposition_situation_vente_autreType').hide();
        $('#div_date_creation_dossier_vente_autreType').show();
    }

    function chalet() {
        $('#div_surface_habitable_vente_autreType').show();
        $('#div_surface_vente_autreType').hide();
        $('#div_nb_piece_vente_autreType').show();
        $('#div_nb_chambres_vente_autreType').show();
        $('#div_nombre_niveau_vente_autreType').show();
        $('#div_jardin_vente_autreType').show();
        $('#div_surface_terrain_vente_autreType').show();
        $('#div_piscine_vente_autreType').hide();
        $('#div_nb_garage_vente_autreType').show();
        $('#div_exposition_situation_vente_autreType').show();
        $('#div_date_creation_dossier_vente_autreType').show();
    }

    function parking() {
        $('#div_surface_habitable_vente_autreType').show();
        $('#div_surface_vente_autreType').hide();
        $('#div_nb_piece_vente_autreType').hide();
        $('#div_nb_chambres_vente_autreType').hide();
        $('#div_nombre_niveau_vente_autreType').hide();
        $('#div_jardin_vente_autreType').hide();
        $('#div_surface_terrain_vente_autreType').hide();
        $('#div_piscine_vente_autreType').hide();
        $('#div_nb_garage_vente_autreType').hide();
        $('#div_exposition_situation_vente_autreType').hide();
        $('#div_date_creation_dossier_vente_autreType').show();
    }

    function viager() {
        $('#div_surface_habitable_vente_autreType').hide();
        $('#div_surface_vente_autreType').hide();
        $('#div_nb_piece_vente_autreType').hide();
        $('#div_nb_chambres_vente_autreType').hide();
        $('#div_nombre_niveau_vente_autreType').hide();
        $('#div_jardin_vente_autreType').hide();
        $('#div_surface_terrain_vente_autreType').hide();
        $('#div_piscine_vente_autreType').hide();
        $('#div_nb_garage_vente_autreType').hide();
        $('#div_exposition_situation_vente_autreType').hide();
        // $('#div_date_creation_dossier_vente_autreType').hide();
    }

    // on affiche ou masque des champs en fonction du type choisi
    $('select[name=type_appartement_vente_autreType]').change(function() {
        (this.value == 'Autre' || this.value == 'Cabanon') ? autreCabanon(): "";
        (this.value == 'Cave' || this.value == 'Garage') ? caveGarage(): "";
        (this.value == 'Chalet') ? chalet(): "";
        (this.value == 'Parking') ? parking(): "";
        (this.value == 'Viager') ? viager(): "";
    });
</script>

{{-- ##////////////// FIN Script pour formulaire Vente -> Autre type///////////////////## --}}




{{-- @@@@@@@@@@@@@@@--------------------- FIN SCRIPT POUR LES VENTES -----------------------@@@@@@@@@@@@@@@ --}}




{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR LES LOCATIONS -----------------------@@@@@@@@@@@@@@@ --}}

{{-- ################### Script pour formulaire Location -> Maison #################### --}}

<script>
    $('#jardin_oui_location_maison').hide();
    $('#piscine_oui_location_maison').hide();

    $('input[type=radio][name=piscine_location_maison]').change(function() {
        (this.value == 'Oui') ? $('#piscine_oui_location_maison').slideDown(): $('#piscine_oui_location_maison')
            .slideUp();
    });

    $('input[type=radio][name=jardin_location_maison]').change(function() {
        (this.value == 'Oui') ? $('#jardin_oui_location_maison').slideDown(): $('#jardin_oui_location_maison')
            .slideUp();
    });

    if ($('select[name=type_maison_location_maison]').val() == "Bastide") {
        $('#div_meuble_location_maison').hide();
    }


    $('select[name=type_maison_location_maison]').change(function() {
        (this.value == 'Bastide') ? $('#div_meuble_location_maison').hide(): $('#div_meuble_location_maison')
            .show();

    });
</script>

{{-- ################### FIN  Location -> Maison #################### --}}



{{-- ################### Script pour formulaire Location -> Appartement #################### --}}

<script>
    // if($('select[name=type_maison_location_maison]').val() == "Bastide"){
    //     $('#div_meuble_location_appart').hide();
    // }

    function selectImmeuble1() {

        $('#div_nb_piece_location_appart').hide();
        $('#div_nb_chambres_location_appart').hide();
        $('#div_nombre_niveau_location_appart').hide();
        $('#div_nb_garage_location_appart').hide();
        $('#div_exposition_situation_location_appart').hide();
        $('#div_date_creation_dossier_location_appart').hide();
        $('#div_surface_habitable_location_appart').hide();
        $('#div_meuble_location_appart').hide();


    }

    function selectAppDupRez1() {
        $('#div_nb_piece_location_appart').show();
        $('#div_nb_chambres_location_appart').show();
        $('#div_nombre_niveau_location_appart').show();
        $('#div_nb_garage_location_appart').show();
        $('#div_exposition_situation_location_appart').show();
        $('#div_date_creation_dossier_location_appart').show();
        $('#div_meuble_location_appart').show();
    }

    function selectLoft1() {
        $('#div_nb_piece_location_appart').show();
        $('#div_nb_chambres_location_appart').show();
        $('#div_nombre_niveau_location_appart').hide();
        $('#div_nb_garage_location_appart').show();
        $('#div_exposition_situation_location_appart').show();
        $('#div_date_creation_dossier_location_appart').show();
        $('#div_meuble_location_appart').show();
    }

    function selectStudio1() {
        $('#div_nb_piece_location_appart').hide();
        $('#div_nb_chambres_location_appart').hide();
        $('#div_nombre_niveau_location_appart').hide();
        $('#div_nb_garage_location_appart').show();
        $('#div_exposition_situation_location_appart').show();
        $('#div_date_creation_dossier_location_appart').show();
        $('#div_surface_habitable_location_appart').show();
        $('#div_meuble_location_appart').show();
    }

    // on affiche ou masque des champs en fonction du type choisi
    $('select[name=type_appartement_location_appart]').change(function() {
        (this.value == 'Immeuble') ? selectImmeuble1(): "";
        (this.value == 'Appartement' || this.value == 'Duplex' || this.value == 'Rez de jardin') ?
        selectAppDupRez1(): "";
        (this.value == 'Loft' || this.value == 'Triplex') ? selectLoft1(): "";
        (this.value == 'Studio') ? selectStudio1(): "";
    });
</script>

{{-- ##//////////////// FIN  Location -> Appartement ///////////////////## --}}



{{-- ################### Script pour formulaire Location -> Autre type #################### --}}

<script>
    $('#jardin_oui_location_autreType').hide();
    $('#piscine_oui_location_autreType').hide();

    $('input[type=radio][name=piscine_location_autreType]').change(function() {
        (this.value == 'Oui') ? $('#piscine_oui_location_autreType').slideDown(): $(
            '#piscine_oui_location_autreType').slideUp();
    });

    $('input[type=radio][name=jardin_location_autreType]').change(function() {
        (this.value == 'Oui') ? $('#jardin_oui_location_autreType').slideDown(): $(
            '#jardin_oui_location_autreType').slideUp();
    });

    $('#div_surface_location_autreType').hide();

    function autreCabanon1() {

        $('#div_surface_habitable_location_autreType').show();
        $('#div_duree_bail_location_autreType').show();
        $('#div_dossier_location_autreType').show();
        $('#div_surface_location_autreType').hide();
        $('#div_nb_piece_location_autreType').show();
        $('#div_nb_chambres_location_autreType').show();
        $('#div_nombre_niveau_location_autreType').show();
        $('#div_jardin_location_autreType').show();
        $('#div_surface_terrain_location_autreType').show();
        $('#div_piscine_location_autreType').show();
        $('#div_nb_garage_location_autreType').show();
        $('#div_exposition_situation_location_autreType').show();
        $('#div_date_creation_dossier_location_autreType').show();
        $('#div_meuble_location_autreType').show();

    }

    function caveGarage1() {
        $('#div_surface_habitable_location_autreType').hide();
        $('#div_duree_bail_location_autreType').show();
        $('#div_dossier_location_autreType').show();
        $('#div_surface_location_autreType').show();
        $('#div_nb_piece_location_autreType').hide();
        $('#div_nb_chambres_location_autreType').hide();
        $('#div_nombre_niveau_location_autreType').hide();
        $('#div_jardin_location_autreType').hide();
        $('#div_surface_terrain_location_autreType').hide();
        $('#div_piscine_location_autreType').hide();
        $('#div_nb_garage_location_autreType').hide();
        $('#div_exposition_situation_location_autreType').hide();
        $('#div_date_creation_dossier_location_autreType').show();
        $('#div_meuble_location_autreType').hide();

    }

    function chalet1() {
        $('#div_surface_habitable_location_autreType').show();
        $('#div_duree_bail_location_autreType').show();
        $('#div_dossier_location_autreType').show();
        $('#div_surface_location_autreType').hide();
        $('#div_nb_piece_location_autreType').show();
        $('#div_nb_chambres_location_autreType').show();
        $('#div_nombre_niveau_location_autreType').show();
        $('#div_jardin_location_autreType').show();
        $('#div_surface_terrain_location_autreType').show();
        $('#div_piscine_location_autreType').hide();
        $('#div_nb_garage_location_autreType').show();
        $('#div_exposition_situation_location_autreType').show();
        $('#div_date_creation_dossier_location_autreType').show();
        $('#div_meuble_location_autreType').show();

    }

    function parking1() {
        $('#div_surface_habitable_location_autreType').show();
        $('#div_duree_bail_location_autreType').show();
        $('#div_dossier_location_autreType').show();
        $('#div_surface_location_autreType').hide();
        $('#div_nb_piece_location_autreType').hide();
        $('#div_nb_chambres_location_autreType').hide();
        $('#div_nombre_niveau_location_autreType').hide();
        $('#div_jardin_location_autreType').hide();
        $('#div_surface_terrain_location_autreType').hide();
        $('#div_piscine_location_autreType').hide();
        $('#div_nb_garage_location_autreType').hide();
        $('#div_exposition_situation_location_autreType').hide();
        $('#div_date_creation_dossier_location_autreType').show();
        $('#div_meuble_location_autreType').hide();

    }

    function viager1() {
        $('#div_surface_habitable_location_autreType').hide();
        $('#div_duree_bail_location_autreType').hide();
        $('#div_surface_location_autreType').hide();
        $('#div_nb_piece_location_autreType').hide();
        $('#div_nb_chambres_location_autreType').hide();
        $('#div_nombre_niveau_location_autreType').hide();
        $('#div_jardin_location_autreType').hide();
        $('#div_surface_terrain_location_autreType').hide();
        $('#div_piscine_location_autreType').hide();
        $('#div_nb_garage_location_autreType').hide();
        $('#div_exposition_situation_location_autreType').hide();
        $('#div_date_creation_dossier_location_autreType').hide();
        $('#div_meuble_location_autreType').hide();
        $('#div_dossier_location_autreType').hide();


    }

    // on affiche ou masque des champs en fonction du type choisi
    $('select[name=type_appartement_location_autreType]').change(function() {
        (this.value == 'Autre' || this.value == 'Cabanon') ? autreCabanon1(): "";
        (this.value == 'Cave' || this.value == 'Garage') ? caveGarage1(): "";
        (this.value == 'Chalet') ? chalet1(): "";
        (this.value == 'Parking') ? parking1(): "";
        (this.value == 'Viager') ? viager1(): "";
    });
</script>

{{-- ##////////////// FIN Script pour formulaire Location -> Autre type///////////////////## --}}




{{-- @@@@@@@@@@@@@@@--------------------- FIN SCRIPT POUR LES LOCATIONS -----------------------@@@@@@@@@@@@@@@ --}}




{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR L'ONGLET SECTEUR  -----------------------@@@@@@@@@@@@@@@ --}}


{{-- ##////////////// ajout de plusieurs secteurs dans la page ///////////////////## --}}
<script>
    $('#add_section').click(function() {

        value_section = $('#section_secteur').val();
        value_parcelle = $('#parcelle_secteur').val();;

        if (value_section != "" && value_parcelle != "") {

            $('#liste_section').append('<div > <input type="hidden" name="section_secteurs[]"  value="' +
                value_section + '" > <input type="hidden"  value="' + value_parcelle +
                '" name="parcelle_secteurs[]"  > </div>');
            $('tbody#section_tab').append('<tr>' +
                '<td>' + value_section + '</td>' +
                '<td>' + value_parcelle + '</td>' +
                '<tr>');

            $('#section_secteur').val("");
            $('#parcelle_secteur').val("");

            $('#section_secteur').removeAttr('required');
            $('#parcelle_secteur').removeAttr('required');
        }


    });
</script>
{{-- ##////////////// fin ajout de plusieurs secteurs dans la page ///////////////////## --}}

{{-- @@@@@@@@@@@@@@@--------------------- FIN SCRIPT POUR L'ONGLET SECTEUR  -----------------------@@@@@@@@@@@@@@@ --}}



{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR L'ONGLET COMPOSITION  -----------------------@@@@@@@@@@@@@@@ --}}


{{-- ##////////////// ajout de plusieurs pièces  ///////////////////## --}}
<script>
    $('#add_piece').click(function() {

        value_piece = $('#piece_composition').val();
        value_detail_piece = $('#detail_piece_composition').val();
        value_surface = $('#surface_composition').val();
        value_note = $('#note_composition').val();
        value_note_publique = $('#note_publique_composition').is(':checked');
        value_note_privee = $('#note_privee_composition').is(':checked');
        value_note_inter_agence = $('#note_inter_agence_composition').is(':checked');
        value_etage = $('#etage_composition').val();

        note_inter_agence_composition
        if (value_piece != "") {

            $('#liste_piece').append('<div > <input type="hidden" name="piece_compositions[]"  value="' +
                value_piece + '" >' +
                '<input type="hidden"  value="' + value_detail_piece +
                '" name="detail_piece_compositions[]"  >' +
                '<input type="hidden"  value="' + value_surface + '" name="surface_compositions[]"  >' +
                '<input type="hidden"  value="' + value_note + '" name="note_compositions[]"  >' +
                '<input type="hidden"  value="' + value_note_publique +
                '" name="note_publique_compositions[]"  >' +
                '<input type="hidden"  value="' + value_note_privee +
                '" name="note_privee_compositions[]"  >' +
                '<input type="hidden"  value="' + value_note_inter_agence +
                '" name="note_inter_agence_compositions[]"  >' +
                '<input type="hidden"  value="' + value_etage + '" name="etage_compositions[]"  >' +

                '</div>');

            $('tbody#composition_tab').append('<tr>' +
                '<td>' + value_piece + '</td>' +
                '<td>' + value_detail_piece + '</td>' +
                '<td>' + value_surface + '</td>' +
                '<td>' + value_note + '</td>' +
                '<td>' + value_etage + '</td>' +
                '<tr>');
            // '<td>'+value_note_publique+'</td>'+
            // '<td>'+value_note_privee+'</td>'+
            // '<td>'+value_note_inter_agence+'</td>'+

            $('#detail_piece_composition').val("");
            $('#surface_composition').val("");
            $('#note_composition').val("");
            $('#note_publique_composition').attr("checked", false);
            $('#note_privee_composition').attr("checked", false);
            $('#note_inter_agence_composition').attr("checked", false);
            $('#etage_composition').val("");


        }


    });
</script>
{{-- ##////////////// fin ajout de plusieurs pièces///////////////////## --}}

{{-- @@@@@@@@@@@@@@@--------------------- FIN SCRIPT POUR L'ONGLET SECTEUR  -----------------------@@@@@@@@@@@@@@@ --}}


{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR L'ONGLET DETAILS  -----------------------@@@@@@@@@@@@@@@ --}}


{{-- ##////////////// Afficher et masquer des zones du formulaire au clic  ///////////////////## --}}
<script>
    function afficherPlus(id_zone_masque, id_bouton_clic) {
        $(id_bouton_clic).click(function() {
            $(id_zone_masque).slideDown();
            $(id_bouton_clic).hide();
        });
    }

    function masquerDiv(id_zone_masque, id_bouton_clic) {

        $(id_bouton_clic).click(function() {
            $(id_zone_masque).slideToggle();
            $(this, '.ti-plus').toggleClass("ti-minus");
        });
    }

    function masquerRadio(champ_radio, div_radio) {

        $('input[type=radio][name=' + champ_radio + ']').change(function() {
            (this.value == 'Oui') ? $(div_radio).slideDown(): $(div_radio).slideUp();
        });
    }



    // Agencement intérieur
    $("#div_agencement_interieur").hide();
    $("#agencement_interieur_plus").hide();

    $("#terrasse_oui_agencement_exterieur").hide();
    $("#type_cave_oui_agencement_exterieur").hide();
    $("#balcon_oui_agencement_exterieur").hide();
    $("#loggia_oui_agencement_exterieur").hide();
    $("#veranda_oui_agencement_exterieur").hide();

    afficherPlus("#agencement_interieur_plus", "#agencement_interieur_btn_plus");
    masquerDiv("#div_agencement_interieur", "#btn_clic_masquer_agi");

    masquerRadio("terrasse_agencement_exterieur", "#terrasse_oui_agencement_exterieur");
    masquerRadio("type_cave_agencement_exterieur", "#type_cave_oui_agencement_exterieur");
    masquerRadio("balcon_agencement_exterieur", "#balcon_oui_agencement_exterieur");
    masquerRadio("loggia_agencement_exterieur", "#loggia_oui_agencement_exterieur");
    masquerRadio("veranda_agencement_exterieur", "#veranda_oui_agencement_exterieur");

    // Fin 

    // Agencement extérieur
    $("#div_agencement_exterieur").hide();
    $("#agencement_exterieur_plus").hide();

    afficherPlus("#agencement_exterieur_plus", "#agencement_exterieur_btn_plus");
    masquerDiv("#div_agencement_exterieur", "#btn_clic_masquer_age");
    // Fin 

    // Terrain
    $("#div_terrain").hide();
    $("#terrain_div1_plus").hide();
    $("#terrain_div2_plus").hide();

    $("#constructible_oui_terrain").hide();

    afficherPlus("#terrain_div1_plus", "#terrain_btn_plus");
    afficherPlus("#terrain_div2_plus", "#terrain_btn_plus");
    masquerDiv("#div_terrain", "#btn_clic_masquer_terr");

    masquerRadio("constructible_terrain", "#constructible_oui_terrain");

    // Fin 

    // Equipement
    $("#div_equipement").hide();
    $("#equipement_div1_plus").hide();
    $("#equipement_div2_plus").hide();

    $("#climatisation_oui_equipement").hide();

    afficherPlus("#equipement_div1_plus", "#equipement_btn_plus");
    afficherPlus("#equipement_div2_plus", "#equipement_btn_plus");
    masquerDiv("#div_equipement", "#btn_clic_masquer_equip");

    masquerRadio("climatisation_equipement", "#climatisation_oui_equipement");

    // Fin 

    // Diagnostics & compléments
    $("#div_diagnostic").hide();
    $("#diagnostic_plus").hide();

    $("#etat_parasitaire_oui_diagnostic").hide();
    $("#amiante_oui_diagnostic").hide();
    $("#electrique_oui_diagnostic").hide();
    $("#loi_carrez_oui_diagnostic").hide();
    $("#risque_nat_oui_diagnostic").hide();
    $("#plomb_oui_diagnostic").hide();
    $("#gaz_oui_diagnostic").hide();
    $("#assainissement_oui_diagnostic").hide();


    afficherPlus("#diagnostic_plus", "#diagnostic_btn_plus");
    masquerDiv("#div_diagnostic", "#btn_clic_masquer_diag");

    masquerRadio("etat_parasitaire_diagnostic", "#etat_parasitaire_oui_diagnostic");
    masquerRadio("amiante_diagnostic", "#amiante_oui_diagnostic");
    masquerRadio("electrique_diagnostic", "#electrique_oui_diagnostic");
    masquerRadio("loi_carrez_diagnostic", "#loi_carrez_oui_diagnostic");
    masquerRadio("risque_nat_diagnostic", "#risque_nat_oui_diagnostic");
    masquerRadio("plomb_diagnostic", "#plomb_oui_diagnostic");
    masquerRadio("gaz_diagnostic", "#gaz_oui_diagnostic");
    masquerRadio("assainissement_diagnostic", "#assainissement_oui_diagnostic");

    // Fin 

    // Informations Coproprété
    $("#div_information").hide();

    masquerDiv("#div_information", "#btn_clic_masquer_info");
    // Fin 

    // Dossier & Disponibilité
    $("#div_dossier").hide();

    masquerDiv("#div_dossier", "#btn_clic_masquer_dossier");
    // Fin 
</script>
{{-- ##////////////// fin Afficher et masquer des zones du formulaire au clic///////////////////## --}}

{{-- @@@@@@@@@@@@@@@--------------------- FIN SCRIPT POUR L'ONGLET DETAILS  -----------------------@@@@@@@@@@@@@@@ --}}


{{-- @@@@@@@@@@@@@@@--------------------- SCRIPT POUR L'ONGLET PRIX  -----------------------@@@@@@@@@@@@@@@ --}}
<script>
    // Afficher ou masquer des champs de l'onglet prix selon vente ou location
    $('.div_prix_location').hide();
    $('#onglet_vente').click(function() {
        $('.div_prix_vente').show();
        $('.div_prix_location').hide();

    });
    $('#onglet_location').click(function() {
        $('.div_prix_vente').hide();
        $('.div_prix_location').show();
    });


    // ********* Partie honnaires pour la vente    


    var tau_prix_pub = 0;
    var var_acq = 0;
    var tau_net = 0;
    var par_vend = 0;

    $('.honoraire_vendeur_info_fin').change(function() {

        if ($('#honoraire_vendeur_info_fin_oui').is(':checked')) {

            $('#honoraire_acquereur_info_fin_non').prop('checked', true);

            tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
            console.log(tau_frais);
            $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));

        } else {

            $('#honoraire_acquereur_info_fin_oui').prop('checked', true);


            tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
            $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
        }


    })

    $('.honoraire_acquereur_info_fin').change(function() {

        if ($('#honoraire_acquereur_info_fin_oui').is(':checked')) {

            $('#honoraire_vendeur_info_fin_non').prop('checked', true);
            tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
            $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));


        } else {

            $('#honoraire_vendeur_info_fin_oui').prop('checked', true);

            tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
            $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
        }


    })



    $('#frais_agence_info_fin').on("change keypress keydown keyup mouseover click ", function() {
        if ($('#prix_net_info_fin').val() > 0 && $('#prix_public_info_fin').val() > 0) {

            if ($('#honoraire_acquereur_info_fin_oui').is(':checked')) {

                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            } else {
                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            }

        }

    });





    $('#taux_frais_info_fin').on("change keypress keydown keyup mouseover click ", function() {
        if ($('#prix_net_info_fin').val() > 0 && $('#prix_public_info_fin').val() > 0) {

            if ($('#honoraire_acquereur_info_fin_oui').is(':checked')) {

                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            } else {
                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            }


        }

    });



    $('#prix_net_info_fin').on("change keypress keydown keyup mouseover click ", function() {
        if ($('#prix_net_info_fin').val() > 0 && $('#prix_public_info_fin').val() > 0) {

            if ($('#honoraire_acquereur_info_fin_oui').is(':checked')) {

                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            } else {
                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            }


        }

    });

    $('#prix_public_info_fin').on("change keypress keydown keyup mouseover click ", function() {
        if ($('#prix_net_info_fin').val() > 0 && $('#prix_public_info_fin').val() > 0) {

            if ($('#honoraire_acquereur_info_fin_oui').is(':checked')) {

                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_public_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            } else {
                tau_frais = ($('#frais_agence_info_fin').val() * 100) / $('#prix_net_info_fin').val();
                $('#taux_frais_info_fin').val(Number(tau_frais).toFixed(2));
            }

        }

    });


    // ********* FIN 

    // ********* Partie Part pour la location    

    $('#div_part_locataire').hide();
    $('#div_part_proprietaire').hide();

    // ********* FIN 
</script>



<script>
    autocomplete_cp_ville("#code_postal_proprietaire", "code_postal_proprietaire", "#ville_proprietaire",
        "ville_proprietaire", "#adresse_proprietaire", "adresse_proprietaire");

    autocomplete_cp_ville("#code_postal_vente_maison", "code_postal_vente_maison", "#ville_vente_maison",
        "ville_vente_maison", null, null);
    autocomplete_cp_ville("#code_postal_vente_appart", "code_postal_vente_appart", "#ville_vente_appart",
        "ville_vente_appart", null, null);
    autocomplete_cp_ville("#code_postal_vente_terrain", "code_postal_vente_terrain", "#ville_vente_terrain",
        "ville_vente_terrain", null, null);
    autocomplete_cp_ville("#code_postal_vente_autreType", "code_postal_vente_autreType", "#ville_vente_autreType",
        "ville_vente_autreType", null, null);

    autocomplete_cp_ville("#code_postal_location_maison", "code_postal_location_maison", "#ville_location_maison",
        "ville_location_maison", null, null);
    autocomplete_cp_ville("#code_postal_location_appart", "code_postal_location_appart", "#ville_location_appart",
        "ville_location_appart", null, null);
    autocomplete_cp_ville("#code_postal_location_terrain", "code_postal_location_terrain", "#ville_location_terrain",
        "ville_location_terrain", null, null);
    autocomplete_cp_ville("#code_postal_location_autreType", "code_postal_location_autreType",
        "#ville_location_autreType", "ville_location_autreType", null, null);
</script>

{{-- @@@@@@@@@@@@@@@ --------------------- FIN SCRIPT POUR L'ONGLET PRIX  ----------------------- @@@@@@@@@@@@@@@ --}}




{{-- AJOUT DU PROPRIETAIRE --}}

<script>
    $(document).ready(function() {
        $(".div_proprietaire").show();

        $(".div_personne_seule").show();
        $(".div_personne_morale").hide();
        $(".div_personne_couple").hide();
        $(".div_personne_groupe").hide();




        $("input[type='radio']").click(function(e) {

            let type_contact = e.currentTarget.value;


            if (type_contact == "Personne morale") {

                $("input[type='text']").removeAttr("required");
                $("select").removeAttr("required");
                $("#type").val("entité");

                $(".div_personne_seule").hide();
                $(".div_personne_morale").show();
                $(".div_personne_couple").hide();
                $(".div_personne_groupe").hide();
                $(".div_personne_tout").show();

                $("#forme_juridique").attr("required", "required");
                $("#raison_sociale").attr("required", "required");
                $("#email").attr("required", "required");

            } else if (type_contact == "Personne seule") {
                $("input[type='text']").removeAttr("required");
                $("select").removeAttr("required");

                $(".div_personne_seule").show();
                $(".div_personne_morale").hide();
                $(".div_personne_couple").hide();
                $(".div_personne_groupe").hide();
                $(".div_personne_tout").show();

                $("#civilite").attr("required", "required");
                $("#nom").attr("required", "required");
                $("#prenom").attr("required", "required");
                $("#email").attr("required", "required");

                $("#type").val("individu");


            } else if (type_contact == "Couple") {
                $("input[type='text']").removeAttr("required");
                $("select").removeAttr("required");

                $(".div_personne_seule").hide();
                $(".div_personne_morale").hide();
                $(".div_personne_couple").show();
                $(".div_personne_groupe").hide();
                $(".div_personne_tout").hide();

                $("#civilite1").attr("required", "required");
                $("#nom1").attr("required", "required");
                $("#prenom1").attr("required", "required");
                $("#email1").attr("required", "required");

                $("#civilite2").attr("required", "required");
                $("#nom2").attr("required", "required");
                $("#prenom2").attr("required", "required");
                $("#email2").attr("required", "required");

                $("#type").val("individu");

            } else if (type_contact == "Groupe") {
                $("input[type='text']").removeAttr("required");
                $("select").removeAttr("required");

                $(".div_personne_seule").hide();
                $(".div_personne_morale").hide();
                $(".div_personne_couple").hide();
                $(".div_personne_tout").show();
                $(".div_personne_groupe").show();


                $("#nom_groupe").attr("required", "required");
                $("#email").attr("required", "required");

                $("#type").val("entité");

            }

        });


    });
</script>


{{-- Ajout de propriétaire --}}

<script>
    $('#nouveau_proprietaire').hide();


    $('#ajouter_proprietaire').change(function(e) {

        if ($('#ajouter_proprietaire').is(':checked')) {
            $('#nouveau_proprietaire').show();
            $('#ancien_proprietaire').hide()
        } else {
            $('#nouveau_proprietaire').hide();
            $('#ancien_proprietaire').show()
        }

    });
</script>
@endsection

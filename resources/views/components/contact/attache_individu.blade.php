<div class="modal fade" id="entite_attache_individu" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="top: 40%; transform: translateY(-35%)!important; width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Associer un contact</strong></h5>
            </div>
            <div class="modal-body">
                <div style="text-align: center; margin:10px">
                    <input type="checkbox" unchecked data-toggle="toggle" id="individu_tps" name="individu_tps"
                        data-off="Non" data-on="Oui" data-onstyle="success btn-rounded btn-sm"
                        data-offstyle="danger btn-rounded btn-sm">
                </div>
                <!--form ajax individus-->
                <div id="ajax_individus">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-validation">
                                <form class="form-valide form-horizontal"
                                    action="{{ route('contact.attach', Crypt::encrypt($contact->entite->id)) }}"
                                    method="post">
                                    {{ csrf_field() }}

                                    <div class="col-md-12 col-lg-12 col-sm-12 "
                                        style="background:#175081; color:white!important; padding:10px ">
                                        <strong>Informations principales
                                    </div>
                                    <br>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-md-2 col-sm-4 control-label"
                                                    for="statut">@lang('Statut du contact') <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <select class="js-select2 form-control" id="statut"
                                                        name="statut" style="width: 100%;" required>

                                                        @foreach ($typeContacts as $typeContact)
                                                            <option value="{{ $typeContact->id }}">
                                                                {{ $typeContact->type }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @if ($errors->has('statut'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('statut') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3  ">
                                            <div class="form-group ">
                                                <label class="col-lg-8  col-md-8  col-sm-48 control-label"
                                                    style="padding-top: 5px;" for="nature1">Personne seule <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <input type="radio" style="height: 22px;" class="form-control"
                                                        id="nature1" name="nature" value="Personne seule" required>
                                                    @if ($errors->has('nature'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nature') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-3 col-md-3 col-sm-3  ">

                                            <div class="form-group ">
                                                <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                                    style="padding-top: 5px;" for="nature2">Personne morale <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <input type="radio" style="height: 22px;" class="form-control"
                                                        id="nature2" name="nature" value="Personne morale" required>
                                                    @if ($errors->has('nature'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nature') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-3 col-md-3 col-sm-3 div_proprietaire ">

                                            <div class="form-group ">
                                                <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                                    style="padding-top: 5px;" for="nature3">Couple <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <input type="radio" style="height: 22px;" class="form-control"
                                                        id="nature3" name="nature" value="Couple" required>
                                                    @if ($errors->has('nature'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nature') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-3 col-md-3 col-sm-3  ">

                                            <div class="form-group ">
                                                <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                                    style="padding-top: 5px;" for="nature4">Groupe <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                    <input type="radio" style="height: 22px;" class="form-control"
                                                        id="nature4" name="nature" value="Groupe" required>
                                                    @if ($errors->has('nature'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nature') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div> --}}


                                    </div>
                                    <input type="hidden" id="type" name="type" value="individu">

                                    <div class="row">
                                        <hr>

                                        <div class="col-lg-6 col-md-6 col-sm-6">


                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="civilite1">@lang('Civilité') <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <select class="js-select2 form-control " id="civilite1"
                                                        name="civilite1" style="width: 100%;">
                                                        <option value="{{ old('civilite1') }}">{{ old('civilite1') }}
                                                        </option>
                                                        <option value="M.">M.</option>>
                                                        <option value="Mme">Mme</option>
                                                    </select>
                                                    @if ($errors->has('civilite1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('civilite1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="nom1">Nom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('nom1') }}" id="nom1" name="nom1">
                                                    @if ($errors->has('nom1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nom1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="prenom1">Prénom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('prenom1') }}" id="prenom1" name="prenom1">
                                                    @if ($errors->has('prenom1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('prenom1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="email1">Email <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="email" class="form-control" id="email1"
                                                        value="{{ old('email1') }}" name="email1">
                                                    @if ($errors->has('email1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('email1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_portable1">Téléphone portable </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_portable1') }}"
                                                        id="telephone_portable1" name="telephone_portable1">
                                                    @if ($errors->has('telephone_portable1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_portable1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_fixe1">Téléphone fixe </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_fixe1') }}" id="telephone_fixe1"
                                                        name="telephone_fixe1">
                                                    @if ($errors->has('telephone_fixe1'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_fixe1') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>


                                            <div class="form-group div_personne_seule">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="civilite">@lang('Civilité') <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <select class="js-select2 form-control " id="civilite"
                                                        name="civilite" style="width: 100%;">
                                                        <option value="{{ old('civilite') }}">{{ old('civilite') }}
                                                        </option>
                                                        <option value="M.">M.</option>>
                                                        <option value="Mme">Mme</option>
                                                    </select>
                                                    @if ($errors->has('civilite'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('civilite') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_seule">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="nom">Nom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('nom') }}" id="nom" name="nom">
                                                    @if ($errors->has('nom'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nom') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_seule">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="prenom">Prénom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('prenom') }}" id="prenom" name="prenom"
                                                        required>
                                                    @if ($errors->has('prenom'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('prenom') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- <div class="form-group div_personne_morale">
                                                <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                                    for="forme_juridique">Forme juridique<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <select class="js-select2 form-control" id="forme_juridique"
                                                        name="forme_juridique" style="width: 100%;" >
                                                        <option value="{{ old('forme_juridique') }}">
                                                            {{ old('forme_juridique') }}</option>

                                                        <option value="">Non défini</option>
                                                        <option value="EURL">EURL - Entreprise unipersonnelle à
                                                            responsabilité limitée</option>
                                                        <option value="EI">EI - Entreprise individuelle</option>
                                                        <option value="SARL">SARL - Société à responsabilité limitée
                                                        </option>
                                                        <option value="SA">SA - Société anonyme</option>
                                                        <option value="SAS">SAS - Société par actions simplifiée
                                                        </option>
                                                        <option value="SCI">SCI - Société civile immobilière
                                                        </option>
                                                        <option value="SNC">SNC - Société en nom collectif</option>
                                                        <option value="EARL">EARL - Entreprise agricole à
                                                            responsabilité limitée</option>
                                                        <option value="EIRL">EIRL - Entreprise individuelle à
                                                            responsabilité limitée (01.01.2010)</option>
                                                        <option value="GAEC">GAEC - Groupement agricole
                                                            d'exploitation en commun</option>
                                                        <option value="GEIE">GEIE - Groupement européen d'intérêt
                                                            économique</option>
                                                        <option value="GIE">GIE - Groupement d'intérêt économique
                                                        </option>
                                                        <option value="SASU">SASU - Société par actions simplifiée
                                                            unipersonnelle</option>
                                                        <option value="SC">SC - Société civile</option>
                                                        <option value="SCA">SCA - Société en commandite par actions
                                                        </option>
                                                        <option value="SCIC">SCIC - Société coopérative d'intérêt
                                                            collectif</option>
                                                        <option value="SCM">SCM - Société civile de moyens</option>
                                                        <option value="SCOP">SCOP - Société coopérative ouvrière de
                                                            production</option>
                                                        <option value="SCP">SCP - Société civile professionnelle
                                                        </option>
                                                        <option value="SCS">SCS - Société en commandite simple
                                                        </option>
                                                        <option value="SEL">SEL - Société d'exercice libéral
                                                        </option>
                                                        <option value="SELAFA">SELAFA - Société d'exercice libéral à
                                                            forme anonyme</option>
                                                        <option value="SELARL">SELARL - Société d'exercice libéral à
                                                            responsabilité limitée</option>
                                                        <option value="SELAS">SELAS - Société d'exercice libéral par
                                                            actions simplifiée</option>
                                                        <option value="SELCA">SELCA - Société d'exercice libéral en
                                                            commandite par actions</option>
                                                        <option value="SEM">SEM - Société d'économie mixte</option>
                                                        <option value="SEML">SEML - Société d'économie mixte locale
                                                        </option>
                                                        <option value="SEP">SEP - Société en participation</option>
                                                        <option value="SICA">SICA - Société d'intérêt collectif
                                                            agricole</option>

                                                    </select>
                                                    @if ($errors->has('forme_juridique'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('forme_juridique') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div> --}}

                                            {{-- <div class="form-group div_personne_morale">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="raison_sociale">Raison sociale <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('raison_sociale') }}" id="raison_sociale"
                                                        name="raison_sociale" required>
                                                    @if ($errors->has('raison_sociale'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('raison_sociale') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div> --}}

                                            {{-- <div class="form-group div_personne_groupe">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="nom_groupe">Nom du groupe <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('nom_groupe') }}" id="nom_groupe"
                                                        name="nom_groupe" required>
                                                    @if ($errors->has('nom_groupe'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nom_groupe') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div> --}}

                                            {{-- <div id="source_div">
                                                <div class="form-group div_personne_groupe">
                                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                        for="type_groupe">Type de groupe</label>
                                                    <div class="col-lg-8">
                                                        <select class="selectpicker col-lg-6" id="type_groupe"
                                                            name="type_groupe" data-live-search="true"
                                                            data-style="btn-ligth btn-rounded">
                                                            <option value=""> </option>
                                                            <option value="Succession">Succession </option>
                                                            <option value="Association">Association </option>
                                                            <option value="Indivision">Indivision </option>
                                                            <option value="Autre">Autre</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div id="source_div">
                                                <div class="form-group div_partenaire">
                                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                        for="metier">Métier</label>
                                                    <div class="col-lg-8">
                                                        <select class="selectpicker col-lg-6" id="metier"
                                                            name="metier" data-live-search="true"
                                                            data-style="btn-warning btn-rounded">

                                                            <option value=""> </option>
                                                            <option value="Notaire">Notaire </option>
                                                            <option value="Collaborateur">Collaborateur </option>
                                                            <option value="Fournisseur">Fournisseur </option>
                                                            <option value="Diagnostiqueur">Diagnostiqueur </option>
                                                            <option value="Promoteur">Promoteur </option>

                                                            <option value="Autre">Autre</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                            <div id="source_div">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                        for="source_id">Source du contact</label>
                                                    <div class="col-lg-8">
                                                        <select class="selectpicker col-lg-6" id="source_id"
                                                            name="source_id" data-live-search="true"
                                                            data-style="btn-warning btn-rounded">

                                                            <option value=""> </option>
                                                            <option value="Réseaux sociaux">Réseaux sociaux</option>
                                                            <option value="Bouche à oreille">Bouche à oreille</option>
                                                            <option value="Internet">Internet</option>
                                                            <option value="Autre">Autre</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="civilite2">@lang('Civilité') <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <select class="js-select2 form-control " id="civilite2"
                                                        name="civilite2" style="width: 100%;">
                                                        <option value="{{ old('civilite2') }}">{{ old('civilite2') }}
                                                        </option>
                                                        <option value="M.">M.</option>>
                                                        <option value="Mme">Mme</option>
                                                    </select>
                                                    @if ($errors->has('civilite2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('civilite2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="nom2">Nom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('nom2') }}" id="nom2" name="nom2">
                                                    @if ($errors->has('nom2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('nom2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="prenom2">Prénom <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('prenom2') }}" id="prenom2" name="prenom2">
                                                    @if ($errors->has('prenom2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('prenom2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="email2">Email <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="email" class="form-control" id="email2"
                                                        value="{{ old('email2') }}" name="email2">
                                                    @if ($errors->has('email2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('email2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_portable2">Téléphone portable </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_portable2') }}"
                                                        id="telephone_portable2" name="telephone_portable2">
                                                    @if ($errors->has('telephone_portable2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_portable2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_couple">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_fixe2">Téléphone fixe </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_fixe2') }}" id="telephone_fixe2"
                                                        name="telephone_fixe2">
                                                    @if ($errors->has('telephone_fixe2'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_fixe2') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>



                                            <div class="form-group div_personne_tout">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="email">Email <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ old('email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_tout">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_portable">Téléphone portable </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_portable') }}"
                                                        id="telephone_portable" name="telephone_portable">
                                                    @if ($errors->has('telephone_portable'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_portable') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group div_personne_tout">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="telephone_fixe">Téléphone fixe </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('telephone_fixe') }}" id="telephone_fixe"
                                                        name="telephone_fixe">
                                                    @if ($errors->has('telephone_fixe'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('telephone_fixe') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>


                                            {{-- <div class="form-group div_personne_morale ">
                                                <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                                    for="numero_siret">Numéro siret</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" id="numero_siret" class="form-control "
                                                        value="{{ old('numero_siret') }}" name="numero_siret">
                                                    @if ($errors->has('telephone'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <a href="#" class="close" data-dismiss="alert"
                                                                aria-label="close">&times;</a>
                                                            <strong>{{ $errors->first('telephone') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group div_personne_morale ">
                                                <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                                    for="numero_tva">Numéro TVA</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" id="numero_tva" class="form-control "
                                                        value="{{ old('numero_tva') }}" name="numero_tva">
                                                    @if ($errors->has('numero_tva'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <a href="#" class="close" data-dismiss="alert"
                                                                aria-label="close">&times;</a>
                                                            <strong>{{ $errors->first('numero_tva') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div> --}}



                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-sm-12 "
                                        style="background:#175081; color:white!important; padding:10px ">
                                        <strong>Informations complémentaires (utiles pour générer des documents et des
                                            statistiques) </strong>
                                    </div>

                                    <br>
                                    <br>
                                    <br>

                                    <div class="row">


                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="adresse">Adresse </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control "
                                                        value="{{ old('adresse') }}" id="adresse" name="adresse">
                                                    @if ($errors->has('adresse'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('adresse') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="code_postal">Code postal </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('code_postal') }}" id="code_postal"
                                                        name="code_postal">
                                                    @if ($errors->has('code_postal'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('code_postal') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="ville">Ville </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('ville') }}" id="ville" name="ville">
                                                    @if ($errors->has('ville'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('ville') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="pays">Pays </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text"
                                                        class="form-control {{ $errors->has('pays') ? ' is-invalid' : '' }}"
                                                        value="{{ old('pays') ? old('pays') : 'France' }}"
                                                        id="pays" name="pays"
                                                        placeholder="Entez une lettre et choisissez..">
                                                    @if ($errors->has('pays'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('pays') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">





                                            <div class="form-group row">
                                                <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                    for="note">Note</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <textarea name="note" id="note" class="form-control" cols="30" rows="5"> {{ old('note') }}</textarea>
                                                    @if ($errors->has('note'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{ $errors->first('note') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="form-group row" style="text-align: center; margin-top: 50px;">
                                        <div class="col-lg-8 ml-auto">
                                            <button
                                                class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"
                                                id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!--!!!!!!!!!!-->
                </div>
                <!--fin form ajax-->
                <!--multiselect individus-->
                <div class="form-validation" id="mvc55">
                    <form class="form-appel form-horizontal"
                        action="{{ route('contact.attach', Crypt::encrypt($contact->entite->id)) }}" method="post">
                        @csrf
                        <div class="form-group row" id="op1">
                            <label class="col-sm-4 control-label" for="individus">Selectionner les individus<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <select class="selectpicker col-lg-8" id="individus" name="individus[]"
                                    data-live-search="true" data-style="btn-pink btn-rounded" multiple required>
                                    @foreach ($contacts as $contact)
                                        @if ($contact->type == 'individu')
                                            @if ($contact->nature == 'Couple')
                                                <option value="{{ $contact->individu->id }}"
                                                    data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->individu->civilite }}</span> {{ $contact->individu->nom }} {{ $contact->individu->prenom }}"
                                                    data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }} ">
                                                </option>
                                            @else
                                                <option value="{{ $contact->individu->id }}"
                                                    data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->individu->civilite }}</span> {{ $contact->individu->nom }} {{ $contact->individu->prenom }}"
                                                    data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }} ">
                                                </option>
                                            @endif
                                            {{-- @else
                                            <option value="{{ $contact->id }}"
                                                data-content="<span class='user-avatar'></span><span class='badge badge-pink'>{{ $contact->entite->forme_juridique }}</span> {{ $contact->entite->raison_sociale }} "
                                                data-tokens="{{ $contact->entite->forme_juridique }} {{ $contact->entite->raison_sociale }} ">
                                            </option> --}}
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="text-align: center;">
                            <button type="submit" class="btn btn-primary"><strong>Valider</strong></button>
                        </div>
                    </form>
                </div>
                <!--fin multiselect individus-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>

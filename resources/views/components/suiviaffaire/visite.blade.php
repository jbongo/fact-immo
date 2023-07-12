<a href="#" data-toggle="modal" data-target="#visite_add"
    class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>

<div class="table-responsive" style="overflow-x: inherit !important;">
    <table id="visite_list" class="table table-hover table-striped student-data-table  m-t-20 ">
        <thead>
            <tr>
                <th>@lang('Date de visite')</th>
                <th>@lang('Heure de visite')</th>
                {{-- <th>@lang('Etat')</th> --}}
                <th>@lang('Visiteur')</th>
                <th>@lang('Compte rendu')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bien->visites as $visite)
                <tr>

                    <td>
                        {{ date('d/m/Y', strtotime($visite->date)) }}
                    </td>
                    <td>
                        {{ date('H:i', strtotime($visite->heure)) }}
                    </td>




                    <td>
                        @php
                            $contact = $visite->contact;
                        @endphp
                        @if ($contact->nature == 'Personne morale')
                            <p>
                                <span style="  font-weigth:bold;">
                                    {{ $contact->entite->forme_juridique }} </span>
                                <span style="  font-weigth:bold; color:#8031db">
                                    {{ $contact->entite->raison_sociale }}</span>
                            </p>
                        @elseif($contact->nature == 'Personne seule')
                            <p>
                                <span style="font-weigth:bold;">
                                    {{ $contact->individu->civilite }} </span>
                                <span style="  font-weigth:bold; color:#8031db">{{ $contact->individu->prenom }}
                                    {{ $contact->individu->nom }}</span>
                            </p>
                        @elseif($contact->nature == 'Groupe')
                            <p>
                                <span style="  font-weigth:bold;">
                                    {{ $contact->entite->type }} </span>

                                <span style="  font-weigth:bold; color:#8031db">
                                    {{ $contact->entite->nom }} </span>
                            </p>
                        @elseif($contact->nature == 'Couple')
                            <p>
                                <span style="  font-weigth:bold;">
                                    {{ $contact->individu->civilite1 }} /
                                    {{ $contact->individu->civilite2 }} </span> <br>
                                <span style="  font-weigth:bold; color:#8031db">
                                    {{ $contact->individu->nom1 }} / {{ $contact->individu->nom2 }}
                                </span>
                            </p>
                        @else
                        @endif
                    </td>
                    <td>
                        <span>{{ $visite->compte_rendu }}</span>
                    </td>


                    <td>

                        <span>
                            <a class="modifier_visite" style="cursor: pointer;"
                                data-href="{{ route('visite.update', Crypt::encrypt($visite->id)) }}"
                                data-visiteur_id="{{ $visite->contact_id }}"
                                data-date_visite="{{ date('Y-m-d', strtotime($visite->date)) }}"
                                data-heure_visite="{{ date('H:i', strtotime($visite->heure)) }}"
                                data-notes="{{ $visite->compte_rendu }}" title="@lang('modifier')" data-toggle="modal"
                                data-target="#visite_edit">
                                <i class="large material-icons color-success">edit</i>
                            </a>
                        </span>
                        <span>
                            <a data-href="{{ route('visite.delete', Crypt::encrypt($visite->id)) }}"
                                style="cursor: pointer;" class="delete_visite" data-toggle="tooltip"
                                title="@lang('Supprimer')">
                                <i class="large material-icons color-danger">delete</i>
                            </a>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>






{{-- Ajouter ue visite --}}


<div class="modal fade" id="visite_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Planifier une visite</strong></h5>
            </div>
            <div class="modal-body">
                <div class="form-validation">
                    <form class="form-appel form-horizontal form-visit" action="{{ route('visite.store') }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="bien_id" value={{ $bien->id }}>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group " id="ancien_visiteur">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="visiteur_id">
                                        Sélectionnez le visiteur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <select class="selectpicker col-lg-8" id="visiteur_id" name="visiteur_id"
                                            data-live-search="true" data-style="btn-pink btn-rounded" required>
                                            @foreach ($contacts as $contact)
                                                @if ($contact->nature == 'Personne morale')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/entreprise.png') }}' alt=''/>
                                                                <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->entite->forme_juridique }}</span> {{ $contact->entite->raison_sociale }} "
                                                        data-tokens="{{ $contact->entite->forme_juridique }} {{ $contact->entite->raison_sociale }}">
                                                    </option>
                                                @elseif($contact->nature == 'Personne seule')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/user2.png') }}'alt=''/>
                                                    <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->individu->civilite }}</span> {{ $contact->nom }} {{ $contact->individu->prenom }}"
                                                        data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }}  ">
                                                    </option>
                                                @elseif($contact->nature == 'Couple')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/couple.png') }}'alt=''/>
                                                <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }}</span> {{ $contact->nom1 }} / {{ $contact->individu->nom2 }}"
                                                        data-tokens="{{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }} {{ $contact->individu->nom1 }} / {{ $contact->individu->nom2 }} ">
                                                    </option>
                                                @elseif($contact->nature == 'Groupe')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/groupe.svg') }}' alt=''/>
                                                            <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->entite->type }}</span> {{ $contact->entite->nom }} "
                                                        data-tokens="{{ $contact->entite->type }} {{ $contact->entite->nom }}">
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('ajouter_visiteur'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('ajouter_visiteur') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ajouter_visiteur">
                                        Créer un nouveau visiteur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="checkbox" unchecked data-toggle="toggle" id="ajouter_visiteur"
                                            name="ajouter_visiteur" data-off="Non" data-on="Oui"
                                            data-onstyle="success  btn-sm" data-offstyle="danger btn-sm">
                                        @if ($errors->has('ajouter_visiteur'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('ajouter_visiteur') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>





                            </div>

                        </div>






                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_visite">
                                        Date de la visite
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <input type="date" id="date_visite"
                                            class="form-control {{ $errors->has('date_visite') ? 'is-invalid' : '' }}"
                                            value="{{ old('date_visite') }}" name="date_visite" required>
                                        @if ($errors->has('date_visite'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('date_visite') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="notes">
                                        Compte rendu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <textarea name="notes" class="form-control" id="notes" cols="30" rows="10"></textarea>
                                        @if ($errors->has('notes'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">


                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="heure_visite">
                                        Heure de la visite
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <input type="time" id="heure_visite"
                                            class="form-control {{ $errors->has('heure_visite') ? 'is-invalid' : '' }}"
                                            value="{{ old('heure_visite') }}" name="heure_visite" required>
                                        @if ($errors->has('heure_visite'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('heure_visite') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>





                        <div id="nouveau_visiteur" style="margin-top: 30px">



                            <div class="col-md-12 col-lg-12 col-sm-12 "
                                style="background:#175081; color:white!important; padding:10px ">
                                <strong>Nouveau visiteur </strong>
                            </div>



                            <div class="row">

                                <input type="hidden" name="nature">

                                <div class="col-lg-3 col-md-3 col-sm-3  ">
                                    <div class="form-group ">
                                        <label class="col-lg-8  col-md-8  col-sm-48 control-label"
                                            style="padding-top: 5px;" for="type_contact1">Personne seule <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control"
                                                id="type_contact1" name="nature_visiteur" value="Personne seule">
                                            @if ($errors->has('nature_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact2">Personne morale <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control"
                                                id="type_contact2" name="nature_visiteur" value="Personne morale">
                                            @if ($errors->has('nature_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 div_visiteur ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact3">Couple <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control"
                                                id="type_contact3" name="nature_visiteur" value="Couple">
                                            @if ($errors->has('nature_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact4">Groupe <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;" class="form-control"
                                                id="type_contact4" name="nature_visiteur" value="Groupe">
                                            @if ($errors->has('nature_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" id="type" name="type_visiteur">

                            <div class="row">
                                <hr>

                                <div class="col-lg-6 col-md-6 col-sm-6">


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite1">@lang('Civilité') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite1"
                                                name="civilite1_visiteur" style="width: 100%;">
                                                <option value="{{ old('civilite1') }}">
                                                    {{ old('civilite1_visiteur') }}</option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite1_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom1">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom1_visiteur') }}" id="nom1"
                                                name="nom1_visiteur">
                                            @if ($errors->has('nom1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom1_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom1">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('prenom1_visiteur') }}" id="prenom1"
                                                name="prenom1_visiteur">
                                            @if ($errors->has('prenom1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom1_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email1">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email1"
                                                value="{{ old('email1_visiteur') }}" name="email1_visiteur">
                                            @if ($errors->has('email1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email1_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_mobile1">Téléphone mobile
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_mobile1_visiteur') }}"
                                                id="telephone_mobile1" name="telephone_mobile1_visiteur">
                                            @if ($errors->has('telephone_mobile1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile1_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe1">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe1_visiteur') }}" id="telephone_fixe1"
                                                name="telephone_fixe1_visiteur">
                                            @if ($errors->has('telephone_fixe1_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe1_visiteur') }}</strong>
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
                                                name="civilite_visiteur" style="width: 100%;">
                                                <option value="{{ old('civilite_visiteur') }}">
                                                    {{ old('civilite_visiteur') }}
                                                </option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom_visiteur') }}" id="nom"
                                                name="nom_visiteur">
                                            @if ($errors->has('nom_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('prenom') }}"
                                                id="prenom" name="prenom_visiteur">
                                            @if ($errors->has('prenom_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                            for="forme_juridique">Forme
                                            juridique<span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control" id="forme_juridique"
                                                name="forme_juridique_visiteur" style="width: 100%;">
                                                <option value="{{ old('forme_juridique_visiteur') }}">
                                                    {{ old('forme_juridique_visiteur') }}</option>

                                                <option value="">Non défini</option>
                                                <option value="EURL">EURL - Entreprise unipersonnelle à
                                                    responsabilité limitée</option>
                                                <option value="EI">EI - Entreprise individuelle</option>
                                                <option value="SARL">SARL - Société à responsabilité limitée</option>
                                                <option value="SA">SA - Société anonyme</option>
                                                <option value="SAS">SAS - Société par actions simplifiée</option>
                                                <option value="SCI">SCI - Société civile immobilière</option>
                                                <option value="SNC">SNC - Société en nom collectif</option>
                                                <option value="EARL">EARL - Entreprise agricole à responsabilité
                                                    limitée</option>
                                                <option value="EIRL">EIRL - Entreprise individuelle à responsabilité
                                                    limitée (01.01.2010)
                                                </option>
                                                <option value="GAEC">GAEC - Groupement agricole d'exploitation en
                                                    commun</option>
                                                <option value="GEIE">GEIE - Groupement européen d'intérêt économique
                                                </option>
                                                <option value="GIE">GIE - Groupement d'intérêt économique</option>
                                                <option value="SASU">SASU - Société par actions simplifiée
                                                    unipersonnelle</option>
                                                <option value="SC">SC - Société civile</option>
                                                <option value="SCA">SCA - Société en commandite par actions</option>
                                                <option value="SCIC">SCIC - Société coopérative d'intérêt collectif
                                                </option>
                                                <option value="SCM">SCM - Société civile de moyens</option>
                                                <option value="SCOP">SCOP - Société coopérative ouvrière de
                                                    production</option>
                                                <option value="SCP">SCP - Société civile professionnelle</option>
                                                <option value="SCS">SCS - Société en commandite simple</option>
                                                <option value="SEL">SEL - Société d'exercice libéral</option>
                                                <option value="SELAFA">SELAFA - Société d'exercice libéral à forme
                                                    anonyme</option>
                                                <option value="SELARL">SELARL - Société d'exercice libéral à
                                                    responsabilité limitée</option>
                                                <option value="SELAS">SELAS - Société d'exercice libéral par actions
                                                    simplifiée</option>
                                                <option value="SELCA">SELCA - Société d'exercice libéral en commandite
                                                    par actions</option>
                                                <option value="SEM">SEM - Société d'économie mixte</option>
                                                <option value="SEML">SEML - Société d'économie mixte locale</option>
                                                <option value="SEP">SEP - Société en participation</option>
                                                <option value="SICA">SICA - Société d'intérêt collectif agricole
                                                </option>

                                            </select>
                                            @if ($errors->has('forme_juridique_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('forme_juridique_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="raison_sociale">Raison
                                            sociale <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('raison_sociale_visiteur') }}" id="raison_sociale"
                                                name="raison_sociale_visiteur">
                                            @if ($errors->has('raison_sociale_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('raison_sociale_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_groupe">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_groupe">Nom
                                            du groupe <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('nom_groupe_visiteur') }}" id="nom_groupe"
                                                name="nom_groupe_visiteur">
                                            @if ($errors->has('nom_groupe_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom_groupe_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="source_div">
                                        <div class="form-group div_personne_groupe">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                for="type_groupe">Type de
                                                groupe</label>
                                            <div class="col-lg-8">
                                                <select class="selectpicker col-lg-6" id="type_groupe"
                                                    name="type_groupe_visiteur" data-live-search="true"
                                                    data-style="btn-ligth btn-rounded">
                                                    <option value=""> </option>
                                                    <option value="Succession">Succession </option>
                                                    <option value="Association">Association </option>
                                                    <option value="Indivision">Indivision </option>
                                                    <option value="Autre">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="source_div">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                                for="source_id">Source du
                                                contact</label>
                                            <div class="col-lg-8">
                                                <select class="selectpicker col-lg-6" id="source_id"
                                                    name="source_id_visiteur" data-live-search="true"
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
                                                name="civilite2_visiteur" style="width: 100%;">
                                                <option value="{{ old('civilite2_visiteur') }}">
                                                    {{ old('civilite2_visiteur') }}
                                                </option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom2">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom2_visiteur') }}" id="nom2"
                                                name="nom2_visiteur">
                                            @if ($errors->has('nom2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom2">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('prenom2_visiteur') }}" id="prenom2"
                                                name="prenom2_visiteur">
                                            @if ($errors->has('prenom2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email2">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email2"
                                                value="{{ old('email2_visiteur') }}" name="email2_visiteur">
                                            @if ($errors->has('email2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_mobile2">Téléphone mobile
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_mobile2_visiteur') }}"
                                                id="telephone_mobile2" name="telephone_mobile2_visiteur">
                                            @if ($errors->has('telephone_mobile2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe2">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe2_visiteur') }}" id="telephone_fixe2"
                                                name="telephone_fixe2_visiteur">
                                            @if ($errors->has('telephone_fixe2_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe2_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>



                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email"
                                                value="{{ old('email_visiteur') }}" name="email_visiteur">
                                            @if ($errors->has('email_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_mobile">Téléphone mobile
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_mobile_visiteur') }}" id="telephone_mobile"
                                                name="telephone_mobile_visiteur">
                                            @if ($errors->has('telephone_mobile_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe">Téléphone
                                            fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe_visiteur') }}" id="telephone_fixe"
                                                name="telephone_fixe_visiteur">
                                            @if ($errors->has('telephone_fixe_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>


                                    <div class="form-group div_personne_morale ">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                            for="numero_siret">Numéro
                                            siret</label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" id="numero_siret" class="form-control "
                                                value="{{ old('numero_siret_visiteur') }}"
                                                name="numero_siret_visiteur">
                                            @if ($errors->has('telephone_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('telephone_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_morale ">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                            for="numero_tva">Numéro
                                            TVA</label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" id="numero_tva" class="form-control "
                                                value="{{ old('numero_tva_visiteur') }}" name="numero_tva_visiteur">
                                            @if ($errors->has('numero_tva_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('numero_tva_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                </div>
                            </div>

                            {{-- <div class="col-md-12 col-lg-12 col-sm-12 "
                                style="background:#175081; color:white!important; padding:10px ">
                                <strong>Informations complémentaires </strong>
                            </div> --}}

                            <hr>
                            <br>
                            <br>

                            <div class="row">


                                <div class="col-lg-6 col-md-6 col-sm-6">

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="adresse_visiteur">Adresse
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('adresse_visiteur') }}" id="adresse_visiteur"
                                                name="adresse_visiteur">
                                            @if ($errors->has('adresse_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('adresse_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="code_postal_visiteur">Code postal
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('code_postal_visiteur') }}" id="code_postal_visiteur"
                                                name="code_postal_visiteur">
                                            @if ($errors->has('code_postal_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('code_postal_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="ville_visiteur">Ville
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('ville_visiteur') }}" id="ville_visiteur"
                                                name="ville_visiteur">
                                            @if ($errors->has('ville_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('ville_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="pays_visiteur">Pays
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('pays_visiteur') ? old('pays_visiteur') : 'France' }}"
                                                id="pays_visiteur" value="France" name="pays_visiteur"
                                                placeholder="Entez une lettre et choisissez..">
                                            @if ($errors->has('pays_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('pays_visiteur') }}</strong>
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
                                            <textarea name="note_visiteur" id="note" class="form-control" cols="30" rows="5"> {{ old('note_visiteur') }}</textarea>
                                            @if ($errors->has('note_visiteur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('note_visiteur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>





                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="vst_check"
                                class="btn btn-primary submitappel">valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




{{-- Modifier ue visite --}}

<div class="modal fade" id="visite_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Modifier une visite</strong></h5>
            </div>
            <div class="modal-body">
                <div class="form-validation">
                    <form class="form-horizontal form-edit-visite" action="" method="post">
                        @csrf
                        <input type="hidden" name="bien_id" value={{ $bien->id }}>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group " id="ancien_visiteur">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="edit_visiteur_id">
                                        Changer le visiteur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <select class="selectpicker  selectpicker2 col-lg-8" id="edit_visiteur_id"
                                            name="visiteur_id" data-live-search="true"
                                            data-style="btn-pink btn-rounded" required>
                                            @foreach ($contacts as $contact)
                                                @if ($contact->nature == 'Personne morale')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/entreprise.png') }}' alt=''/>
                                                                <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->entite->forme_juridique }}</span> {{ $contact->entite->raison_sociale }} "
                                                        data-tokens="{{ $contact->entite->forme_juridique }} {{ $contact->entite->raison_sociale }}">
                                                    </option>
                                                @elseif($contact->nature == 'Personne seule')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/user2.png') }}'alt=''/>
                                                    <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->individu->civilite }}</span> {{ $contact->nom }} {{ $contact->individu->prenom }}"
                                                        data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }}  ">
                                                    </option>
                                                @elseif($contact->nature == 'Couple')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/couple.png') }}'alt=''/>
                                                <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }}</span> {{ $contact->nom1 }} / {{ $contact->individu->nom2 }}"
                                                        data-tokens="{{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }} {{ $contact->individu->nom1 }} / {{ $contact->individu->nom2 }} ">
                                                    </option>
                                                @elseif($contact->nature == 'Groupe')
                                                    <option value="{{ $contact->id }}"
                                                        data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/groupe.svg') }}' alt=''/>
                                                            <span class='user-avatar'></span><span class='badge badge-pink'>  {{ $contact->entite->type }}</span> {{ $contact->entite->nom }} "
                                                        data-tokens="{{ $contact->entite->type }} {{ $contact->entite->nom }}">
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('ajouter_visiteur'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('ajouter_visiteur') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                            </div>

                        </div>






                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="edit_date_visite">
                                        Date de la visite
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <input type="date" id="edit_date_visite"
                                            class="form-control {{ $errors->has('date_visite') ? 'is-invalid' : '' }}"
                                            value="{{ old('date_visite') }}" name="date_visite" required>
                                        @if ($errors->has('date_visite'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('date_visite') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="edit_notes">
                                        Compte rendu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <textarea name="notes" class="form-control" id="edit_notes" cols="30" rows="10"></textarea>
                                        @if ($errors->has('notes'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">


                                <div class="form-group " id="">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="edit_heure_visite">
                                        Heure de la visite
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">

                                        <input type="time" id="edit_heure_visite" class="form-control"
                                            value="{{ old('heure_visite') }}" name="heure_visite" required>
                                        @if ($errors->has('heure_visite'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('heure_visite') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="vst_check"
                                class="btn btn-primary submitappel">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@section('js_visites')
@endsection

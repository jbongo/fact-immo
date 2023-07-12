<a href="#" data-toggle="modal" data-target="#offre_add"
    class="btn btn-info btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
<div class="table-responsive" style="overflow-x: inherit !important;">
    <table id="offre_list" class="table table-hover table-striped student-data-table  m-t-20 ">
        <thead>
            <tr>
                <th>@lang('Statut')</th>
                <th>@lang('Montant')</th>
                <th>@lang('Frais d\'agence')</th>
                <th>@lang('Acquéreur')</th>
                <th>@lang('Date offre')</th>
                <th>@lang('Date d\'expiration')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bien->offreachats as $offre)
                <tr>
                    <td>
                        @if ($offre->statut == 0)
                            <span class="badge badge-warning">En attente </span>
                        @elseif($offre->statut == 1)
                            <span class="badge badge-success">Acceptée</span>
                        @else
                            <span class="badge badge-danger">Réfusée</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $offre->montant }} €</strong>
                    </td>
                    <td>
                        <strong>{{ $offre->frais_agence }} €</strong>
                    </td>
                    <td>
                        @php
                            $contact = $offre->contact;
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
                        {{ $offre->date_debut != null ? $offre->date_debut->format('d/m/Y') : '' }}
                    </td>
                    <td>
                        {{ $offre->date_expiration != null ? $offre->date_expiration->format('d/m/Y') : '' }}
                    </td>
                    <td>
                        <span><a href="{{ route('offreachat.download', Crypt::encrypt($offre->id)) }}"
                                data-toggle="tooltip" title="Télécharger le fichier pdf"><i
                                    class="large material-icons color-pink">cloud_download</i></a> </span>
                        @if ($bien->statut === 'actif')
                            @if ($offre->statut == 0)
                                <span><a class="accepter_offre"
                                        data-href="{{ route('offreachat.accepter', [Crypt::encrypt($offre->id), 1]) }}"
                                        style="cursor: pointer;" data-toggle="tooltip" title="Accepter l'offre"><i
                                            class="large material-icons color-success">check</i></a> </span>
                                <span><a class="refuser_offre"
                                        data-href="{{ route('offreachat.accepter', [Crypt::encrypt($offre->id), 2]) }}"
                                        style="cursor: pointer;" data-toggle="tooltip" title="Rejeter l'offre"><i
                                            class="large material-icons color-warning">close</i></a> </span>
                            @elseif($offre->statut == 2)
                                <span><a class="counter_offre" href="#"
                                        route="{{ route('suiviaffaire.offre.contreoffre.add', Crypt::encrypt($offre->id)) }}"
                                        data-toggle="tooltip" title="Ajouter une contre offre"><i
                                            class="large material-icons color-warning">restore</i></a> </span>
                            @endif
                        @endif
                        <span>
                            <a class="modifier_offreachat" style="cursor: pointer;"
                                data-href="{{ route('offreachat.update', Crypt::encrypt($offre->id)) }}"
                                data-visiteur_id="{{ $offre->contact_id }}"
                                data-date_visite="{{ date('Y-m-d', strtotime($offre->date)) }}"
                                data-heure_visite="{{ date('H:i', strtotime($offre->heure)) }}"
                                data-notes="{{ $offre->compte_rendu }}" title="@lang('modifier')" data-toggle="modal"
                                data-target="#visite_edit">
                                <i class="large material-icons color-success">edit</i>
                            </a>
                        </span>
                        <span>
                            <a data-href="{{ route('offreachat.delete', Crypt::encrypt($offre->id)) }}"
                                style="cursor: pointer;" class="delete_offreachat" data-toggle="tooltip"
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


<div class="modal fade" id="offre_add" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter une offre</strong></h5>
            </div>
            <div class="modal-body">

                <div class="form-validation">
                    <form class="form-appel form-horizontal form-offre"
                        action="{{ route('offreachat.store', Crypt::encrypt($bien->id)) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="bien_id" value={{ $bien->id }}>


                        <div class="row">
                            <div class="col-md-6 col-lg-6">

                                <div class="form-group " id="ancien_offreur">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="contact_id">
                                        Sélectionnez l'acquéreur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <select class="selectpicker col-lg-8" id="contact_id" name="contact_id"
                                            data-live-search="true" data-style="btn-danger btn-rounded" required>
                                            <option></option>
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
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ajouter_offreur">
                                        Créer
                                        un nouvel acquéreur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="checkbox" unchecked data-toggle="toggle" id="ajouter_offreur"
                                            name="ajouter_offreur" data-off="Non" data-on="Oui"
                                            data-onstyle="success  btn-sm" data-offstyle="danger btn-sm">
                                        @if ($errors->has('ajouter_offreur'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('ajouter_offreur') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="montant"> Montant de
                                        l'offre TTC (€)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="number" min="1" step="1" id="montant"
                                            class="form-control {{ $errors->has('montant') ? 'is-invalid' : '' }}"
                                            value="{{ old('montant') }}" name="montant" required>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="frais_agence"> Frais
                                        d'agence TTC (€)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="number" min="1" step="1" id="frais_agence"
                                            class="form-control {{ $errors->has('frais_agence') ? 'is-invalid' : '' }}"
                                            value="{{ old('frais_agence') }}" name="frais_agence" required>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-6 col-lg-6">

                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_debut"> Date
                                        effective de l'offre
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="date" id="date_debut"
                                            class="form-control {{ $errors->has('date_debut') ? 'is-invalid' : '' }}"
                                            value="{{ old('date_debut') }}" name="date_debut" required>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_expiration">
                                        Date de fin de l'offre

                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="date" id="date_expiration" class="form-control"
                                            value="{{ old('date_expiration') }}" name="date_expiration">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite2">
                                        Offre d'achat signée (Document)

                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="file" id="fichier_pdf" class="form-control"
                                            value="{{ old('fichier_pdf') }}" accept=".pdf" name="fichier_pdf">
                                    </div>
                                </div>








                            </div>
                        </div>



                        <div id="nouveau_offreur" style="margin-top: 30px">



                            <div class="col-md-12 col-lg-12 col-sm-12 "
                                style="background:#175081; color:white!important; padding:10px ">
                                <strong>Nouvel acquereur </strong>
                            </div>



                            <div class="row">

                                <input type="hidden" name="nature">

                                <div class="col-lg-3 col-md-3 col-sm-3  ">
                                    <div class="form-group ">
                                        <label class="col-lg-8  col-md-8  col-sm-48 control-label"
                                            style="padding-top: 5px;" for="type_contact_offreur1">Personne seule <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;"
                                                class="form-control nature_offreur" id="type_contact_offreur1"
                                                name="nature_offreur" value="Personne seule">
                                            @if ($errors->has('nature_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact_offreur2">Personne morale
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;"
                                                class="form-control nature_offreur" id="type_contact_offreur2"
                                                name="nature_offreur" value="Personne morale">
                                            @if ($errors->has('nature_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 div_offreur ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact_offreur3">Couple <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;"
                                                class="form-control nature_offreur" id="type_contact_offreur3"
                                                name="nature_offreur" value="Couple">
                                            @if ($errors->has('nature_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3  ">

                                    <div class="form-group ">
                                        <label class="col-lg-8 col-md-8 col-sm-8 control-label"
                                            style="padding-top: 5px;" for="type_contact_offreur4">Groupe <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <input type="radio" style="height: 22px;"
                                                class="form-control nature_offreur" id="type_contact_offreur4"
                                                name="nature_offreur" value="Groupe">
                                            @if ($errors->has('nature_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nature_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" id="type" name="type_offreur">

                            <div class="row">
                                <hr>

                                <div class="col-lg-6 col-md-6 col-sm-6">


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite1_offreur">@lang('Civilité') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite1_offreur"
                                                name="civilite1_offreur" style="width: 100%;">
                                                <option value="{{ old('civilite1') }}">
                                                    {{ old('civilite1_offreur') }}</option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom1_offreur">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom1_offreur') }}" id="nom1_offreur"
                                                name="nom1_offreur">
                                            @if ($errors->has('nom1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="prenom1_offreur">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('prenom1_offreur') }}" id="prenom1_offreur"
                                                name="prenom1_offreur">
                                            @if ($errors->has('prenom1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="email1_offreur">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email1_offreur"
                                                value="{{ old('email1_offreur') }}" name="email1_offreur">
                                            @if ($errors->has('email1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_mobile1_offreur">Téléphone mobile
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_mobile1_offreur') }}"
                                                id="telephone_mobile1_offreur" name="telephone_mobile1_offreur">
                                            @if ($errors->has('telephone_mobile1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe1_offreur">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe1_offreur') }}"
                                                id="telephone_fixe1_offreur" name="telephone_fixe1_offreur">
                                            @if ($errors->has('telephone_fixe1_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe1_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>


                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="civilite_offreur">@lang('Civilité') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control " id="civilite_offreur"
                                                name="civilite_offreur" style="width: 100%;">
                                                <option value="{{ old('civilite_offreur') }}">
                                                    {{ old('civilite_offreur') }}
                                                </option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_offreur">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom_offreur') }}" id="nom_offreur"
                                                name="nom_offreur">
                                            @if ($errors->has('nom_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_seule">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="prenom_offreur">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control" value="{{ old('prenom') }}"
                                                id="prenom_offreur" name="prenom_offreur">
                                            @if ($errors->has('prenom_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4  control-label"
                                            for="forme_juridique_offreur">Forme
                                            juridique<span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <select class="js-select2 form-control" id="forme_juridique_offreur"
                                                name="forme_juridique_offreur" style="width: 100%;">
                                                <option value="{{ old('forme_juridique_offreur') }}">
                                                    {{ old('forme_juridique_offreur') }}</option>

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
                                            @if ($errors->has('forme_juridique_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('forme_juridique_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_morale">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="raison_sociale_offreur">Raison
                                            sociale <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('raison_sociale_offreur') }}"
                                                id="raison_sociale_offreur" name="raison_sociale_offreur">
                                            @if ($errors->has('raison_sociale_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('raison_sociale_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_groupe">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="nom_groupe_offreur">Nom
                                            du groupe <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('nom_groupe_offreur') }}" id="nom_groupe_offreur"
                                                name="nom_groupe_offreur">
                                            @if ($errors->has('nom_groupe_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom_groupe_offreur') }}</strong>
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
                                                    name="type_groupe_offreur" data-live-search="true"
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
                                                    name="source_id_offreur" data-live-search="true"
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
                                                name="civilite2_offreur" style="width: 100%;">
                                                <option value="{{ old('civilite2_offreur') }}">
                                                    {{ old('civilite2_offreur') }}
                                                </option>
                                                <option value="M.">M.</option>>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            @if ($errors->has('civilite2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('civilite2_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom2">Nom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('nom2_offreur') }}" id="nom2"
                                                name="nom2_offreur">
                                            @if ($errors->has('nom2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('nom2_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom2">Prénom
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('prenom2_offreur') }}" id="prenom2"
                                                name="prenom2_offreur">
                                            @if ($errors->has('prenom2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('prenom2_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email2">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email2"
                                                value="{{ old('email2_offreur') }}" name="email2_offreur">
                                            @if ($errors->has('email2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email2_offreur') }}</strong>
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
                                                value="{{ old('telephone_mobile2_offreur') }}"
                                                id="telephone_mobile2" name="telephone_mobile2_offreur">
                                            @if ($errors->has('telephone_mobile2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile2_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group div_personne_couple">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="telephone_fixe2">Téléphone fixe </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('telephone_fixe2_offreur') }}" id="telephone_fixe2"
                                                name="telephone_fixe2_offreur">
                                            @if ($errors->has('telephone_fixe2_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe2_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                    </div>



                                    <div class="form-group div_personne_tout">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="email" class="form-control" id="email"
                                                value="{{ old('email_offreur') }}" name="email_offreur">
                                            @if ($errors->has('email_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('email_offreur') }}</strong>
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
                                                value="{{ old('telephone_mobile_offreur') }}" id="telephone_mobile"
                                                name="telephone_mobile_offreur">
                                            @if ($errors->has('telephone_mobile_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_mobile_offreur') }}</strong>
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
                                                value="{{ old('telephone_fixe_offreur') }}" id="telephone_fixe"
                                                name="telephone_fixe_offreur">
                                            @if ($errors->has('telephone_fixe_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('telephone_fixe_offreur') }}</strong>
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
                                                value="{{ old('numero_siret_offreur') }}"
                                                name="numero_siret_offreur">
                                            @if ($errors->has('telephone_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('telephone_offreur') }}</strong>
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
                                                value="{{ old('numero_tva_offreur') }}" name="numero_tva_offreur">
                                            @if ($errors->has('numero_tva_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a>
                                                    <strong>{{ $errors->first('numero_tva_offreur') }}</strong>
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
                                            for="adresse_offreur">Adresse
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control "
                                                value="{{ old('adresse_offreur') }}" id="adresse_offreur"
                                                name="adresse_offreur">
                                            @if ($errors->has('adresse_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('adresse_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="code_postal_offreur">Code postal
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('code_postal_offreur') }}" id="code_postal_offreur"
                                                name="code_postal_offreur">
                                            @if ($errors->has('code_postal_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('code_postal_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="ville_offreur">Ville
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('ville_offreur') }}" id="ville_offreur"
                                                name="ville_offreur">
                                            @if ($errors->has('ville_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('ville_offreur') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label"
                                            for="pays_offreur">Pays
                                        </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ old('pays_offreur') ? old('pays_offreur') : 'France' }}"
                                                id="pays_offreur" value="France" name="pays_offreur"
                                                placeholder="Entez une lettre et choisissez..">
                                            @if ($errors->has('pays_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('pays_offreur') }}</strong>
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
                                            <textarea name="note_offreur" id="note" class="form-control" cols="30" rows="5"> {{ old('note_offreur') }}</textarea>
                                            @if ($errors->has('note_offreur'))
                                                <br>
                                                <div class="alert alert-warning ">
                                                    <strong>{{ $errors->first('note_offreur') }}</strong>
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


@section('js_offres')
    <script>
        $('a.confirm_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si l\'offre est acceptée par le mandant, confirmez ?';
            processAjaxSwal(route, warning, reload);
        })
        $('a.reject_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si l\'offre est rejetée par le mandant, confirmez ?';
            processAjaxSwal(route, warning, reload);
        })
        $('a.counter_offre').click(function(b) {
            b.preventDefault();
            let that = $(this);
            var route = that.attr('route');
            $('.form_contre_offre').attr('action', route);
            $('#offre_counter').modal('show');
        })
    </script>
@endsection

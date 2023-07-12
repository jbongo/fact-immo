<div id="bloc_prix">

    <form action="{{ route('bien.update', $bien->id) }}" id="prix" method="post">
        @csrf

        <input type="text" name="type_update" hidden value="prix">
        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
                <h4> <strong>@lang('Mandat du bien')</strong> </h4>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1">
                <a class="btn btn-dark" id="btn_update_infos_mandat"
                    style="height: 39px;margin-left:-10px;margin-bottom:10px;">
                    <i class="material-icons">mode_edit</i>
                </a>
            </div>
        </div>
        <br>
        <br>
        <div class="row" id="div_dossier">
            <div class="col-md-12 col-lg-12">




            </div>
        </div>

        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
                <h4> <strong>@lang('Propriétaire du bien')</strong> </h4>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1">
                <a class="btn btn-dark" id="btn_update_infos_proprietaire"
                    style="height: 39px;margin-left:-10px;margin-bottom:10px;">
                    <i class="material-icons">mode_edit</i>
                </a>
            </div>
        </div>
        <br>
        <br>
        <div class="row" id="div_dossier">
            <div class="col-md-12 col-lg-12">

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label"
                        for="disponibilite_immediate_dossier_dispo">@lang('Propriétaire du bien') </label>
                    <div class="col-lg-6 col-md-6">


                        <div class="col-lg-7 col-md-7 hide_champ_infos_proprietaire">
                            <select class="selectpicker col-lg-8" id="proprietaire_id" name="proprietaire_id"
                                data-live-search="true" data-style="btn-pink btn-rounded" required>
                                @foreach ($contacts as $contact)
                                    @php $selected = $contact->id == $proprietaire->id ? "selected": "";@endphp
                                    @if ($contact->nature == 'Personne morale')
                                        <option value="{{ $contact->id }}" {{ $selected }}
                                            data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/entreprise.png') }}' alt=''/>
                                             <span class='badge badge-pink'>  {{ $contact->entite->forme_juridique }}</span> {{ $contact->entite->raison_sociale }} "
                                            data-tokens="{{ $contact->entite->forme_juridique }} {{ $contact->entite->raison_sociale }}">
                                        </option>
                                    @elseif($contact->nature == 'Personne seule')
                                        <option value="{{ $contact->id }}" {{ $selected }}
                                            data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/user2.png') }}'alt=''/>
                                 <span class='badge badge-pink'>  {{ $contact->individu->civilite }}</span> {{ $contact->nom }} {{ $contact->individu->prenom }}"
                                            data-tokens="{{ $contact->individu->civilite }} {{ $contact->individu->nom }} {{ $contact->individu->prenom }}  ">
                                        </option>
                                    @elseif($contact->nature == 'Couple')
                                        <option value="{{ $contact->id }}" {{ $selected }}
                                            data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/couple.png') }}'alt=''/>
                             <span class='badge badge-pink'>  {{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }}</span> {{ $contact->nom1 }} / {{ $contact->individu->nom2 }}"
                                            data-tokens="{{ $contact->individu->civilite1 }} / {{ $contact->individu->civilite2 }} {{ $contact->individu->nom1 }} / {{ $contact->individu->nom2 }} ">
                                        </option>
                                    @elseif($contact->nature == 'Groupe')
                                        <option value="{{ $contact->id }}" {{ $selected }}
                                            data-content="<img class='avatar-img' src='{{ asset('images/photo_profile/groupe.svg') }}' alt=''/>
                                         <span class='badge badge-pink'>  {{ $contact->entite->type }}</span> {{ $contact->entite->nom }} "
                                            data-tokens="{{ $contact->entite->type }} {{ $contact->entite->nom }}">
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_proprietaire">
                            @if ($proprietaire->nature == 'Personne morale')
                                <span>
                                    <span class='badge badge-pink'> {{ $proprietaire->entite->forme_juridique }}</span>
                                    {{ $proprietaire->entite->raison_sociale }}
                                </span>
                            @elseif($proprietaire->nature == 'Personne seule')
                                <span>
                                    <span class='badge badge-pink'>{{ $proprietaire->individu->civilite }}</span>
                                    {{ $proprietaire->individu->civilite }} {{ $proprietaire->individu->nom }}
                                    {{ $proprietaire->individu->prenom }}
                                </span>
                            @elseif($proprietaire->nature == 'Couple')
                                <span>
                                    <span class='badge badge-pink'> {{ $proprietaire->individu->civilite1 }} /
                                        {{ $proprietaire->individu->civilite2 }}</span>
                                    {{ $proprietaire->nom1 }} / {{ $proprietaire->individu->nom2 }}
                                </span>
                            @elseif($proprietaire->nature == 'Groupe')
                                <span>
                                    <span class='badge badge-pink'> {{ $proprietaire->entite->type }}</span>
                                    {{ $proprietaire->entite->nom }}
                                </span>
                            @endif


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
                <h4> <strong>@lang('Informations')</strong> @lang('complémentaires & prix')</h4>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1">
                <a class="btn btn-dark" id="btn_update_infos_prix"
                    style="height: 39px;margin-left:-10px;margin-bottom:10px;">
                    <i class="material-icons">mode_edit</i>
                </a>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6 col-lg-6 col-lg-offset-2 col-md-offset-2">
                <button id="btn_enregistrer_prix" class="btn btn-dark btn-flat btn-addon btn-lg "
                    style="position: fixed;bottom: 10px; z-index:1 ;" type="submit"><i
                        class="ti-save"></i>@lang('Enregistrer')</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11">
                <div class="form-group row">
                    <label class="col-lg-2 col-md-2 col-form-label" for="prix_net_info_fin">@lang('Prix')
                    </label>
                    <div class="col-lg-10 col-md-10">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="prix_net_info_fin">@lang('Net vendeur (€)') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->prix_prive }}" min="0"
                                        class="form-control " id="prix_net_info_fin" name="prix_prive_info_fin"
                                        placeholder="@lang('€')">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->prix_prive }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="prix_public_info_fin">@lang('Public (€)') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->prix_public }}" min="0"
                                        class="form-control " id="prix_public_info_fin" name="prix_public_info_fin"
                                        placeholder="@lang('€')">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->prix_public }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="honoraire_acquereur_info_fin">@lang('Honoraires charge Acquéreur') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    @php  $honoraire_acquer = $bien->honoraire_acquereur @endphp
                                    <label class="radio-inline"><input type="radio"
                                            class="honoraire_acquereur_info_fin"
                                            @if ($honoraire_acquer == 'Non') checked @endif value="@lang('Non')"
                                            name="honoraire_acquereur_info_fin" id="honoraire_acquereur_info_fin_non"
                                            checked>
                                        @lang('Non')
                                    </label>
                                    <label class="radio-inline"><input type="radio"
                                            class="honoraire_acquereur_info_fin"
                                            @if ($honoraire_acquer == 'Oui') checked @endif value="@lang('Oui')"
                                            name="honoraire_acquereur_info_fin" id="honoraire_acquereur_info_fin_oui">
                                        @lang('Oui')
                                    </label>
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->honoraire_acquereur }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="honoraire_vendeur_info_fin">@lang('Honoraires charge Vendeur') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    @php  $honoraire_ven = $bien->honoraire_vendeur @endphp
                                    <label class="radio-inline">
                                        <input type="radio" class="honoraire_vendeur_info_fin"
                                            @if ($honoraire_ven == 'Non') checked @endif
                                            value="@lang('Non')" id="honoraire_vendeur_info_fin_non"
                                            name="honoraire_vendeur_info_fin" checked>
                                        @lang('Non')
                                    </label>
                                    <label class="radio-inline"><input type="radio"
                                            class="honoraire_vendeur_info_fin"
                                            @if ($honoraire_ven == 'Oui') checked @endif
                                            value="@lang('Oui')" id="honoraire_vendeur_info_fin_oui"
                                            name="honoraire_vendeur_info_fin">
                                        @lang('Oui')
                                    </label>
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->honoraire_vendeur }}
                                </div>
                            </div>
                        </div>

                        <div class="row" id="">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="frais_agence_info_fin">@lang('Frais agence (TTC) €')
                                </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control " required
                                        id="frais_agence_info_fin" value="{{ $bien->frais_agence }}"
                                        name="frais_agence_info_fin" placeholder="@lang('€')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="taux_frais_info_fin">@lang('Taux frais agence %')
                                </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "
                                        id="taux_frais_info_fin" value="{{ $bien->taux_frais }}"
                                        name="taux_frais_info_fin" required placeholder="@lang('%')">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <br>
        <hr>

        <div class="row">
            <div class="col-md-6 col-lg-6">


                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label"
                        for="estimation_valeur_info_fin">@lang('Estimation')
                    </label>
                    <div class="col-lg-6 col-md-6">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="estimation_valeur_info_fin">@lang('Valeur') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->estimation_valeur }}" min="0"
                                        class="form-control " id="estimation_valeur_info_fin"
                                        name="estimation_valeur_info_fin" placeholder="@lang('€')">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->estimation_valeur }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="estimation_date_info_fin">@lang('date') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="date" value="{{ $bien->estimation_date }}" class="form-control "
                                        id="estimation_date_info_fin" name="estimation_date_info_fin" placeholder="">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->estimation_date }}
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="viager_valeur_info_fin">@lang('Viager')
                    </label>
                    <div class="col-lg-6 col-md-6">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="viager_valeur_info_fin">@lang('Prix du bouquet') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->viager_prix_bouquet }}" min="0"
                                        class="form-control " id="viager_valeur_info_fin"
                                        name="viager_valeur_info_fin">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->viager_prix_bouquet }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="viager_rente_mensuelle_info_fin">@lang('Rente Mensuelle') </label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->viager_rente_mensuelle }}" min="0"
                                        class="form-control " id="viager_rente_mensuelle_info_fin"
                                        name="viager_rente_mensuelle_info_fin">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->viager_rente_mensuelle }}
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label"
                        for="travaux_a_prevoir_info_fin">@lang('Travaux à prévoir') </label>
                    <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
                        <input type="text" value="{{ $bien->travaux_a_prevoir }}" class="form-control "
                            id="travaux_a_prevoir_info_fin" name="travaux_a_prevoir_info_fin">

                    </div>
                    <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                        {{ $bien->travaux_a_prevoir }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="depot_garanti_info_fin">@lang('Dépôt de garantie')
                    </label>
                    <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
                        <input type="number" value="{{ $bien->depot_garanti }}" min="0"
                            class="form-control " id="depot_garanti_info_fin" name="depot_garanti_info_fin"
                            placeholder="@lang('€')">

                    </div>
                    <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                        {{ $bien->depot_garanti }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="taxe_habitation_info_fin">@lang('Taxe d\'habitation')
                    </label>
                    <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
                        <input type="number" value="{{ $bien->taxe_habitation }}" min="0"
                            class="form-control " id="taxe_habitation_info_fin" name="taxe_habitation_info_fin"
                            placeholder="@lang('€')">

                    </div>
                    <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                        {{ $bien->taxe_habitation }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Taxe foncière')
                    </label>
                    <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
                        <input type="number" value="{{ $bien->taxe_fonciere }}" min="0"
                            class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin"
                            placeholder="@lang('€')">

                    </div>
                    <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                        {{ $bien->taxe_fonciere }}
                    </div>
                </div>

            </div>


            <div class="col-md-6 col-lg-6">

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Montant foncier total')
                    </label>
                    <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
                        <input type="number" value="{{ $bien->taxe_fonciere }}" min="0"
                            class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin"
                            placeholder="@lang('€')">

                    </div>
                    <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                        {{ $bien->taxe_fonciere }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label"
                        for="charge_mensuelle_total_info_fin">@lang('Charges Mensuelles') </label>
                    <div class="col-lg-6 col-md-6">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <input type="number" value="{{ $bien->charge_mensuelle_total }}" min="0"
                                        class="form-control " id="charge_mensuelle_total_info_fin"
                                        name="charge_mensuelle_total_info_fin" placeholder="@lang('€')">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->charge_mensuelle_total }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                                <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <textarea class="form-control" name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin"
                                        cols="30" rows="3">{{ $bien->charge_mensuelle_info }}</textarea>

                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                    {{ $bien->charge_mensuelle_info }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

            </div>
        </div>

        <br>
        <br>
        <hr>
        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
                <h4> <strong>@lang('Dossier')</strong> @lang('& Disponibilité')</h4>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1">
                <a class="btn btn-dark" id="btn_update_dossier_dispo"
                    style="height: 39px;margin-left:-10px;margin-bottom:10px;">
                    <i class="material-icons">mode_edit</i>
                </a>
            </div>
        </div>
        <br>
        <br>
        <div class="row" id="div_dossier">
            <div class="col-md-12 col-lg-12">

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_dispo">@lang('Dossier')
                    </label>
                    <div class="col-lg-6 col-md-6">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="numero_dossier_dispo">@lang('Numéro') </label>
                                <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                    <input type="text" value="{{ $bien->biendetail->dossier_dispo_numero }}"
                                        class="form-control " id="numero_dossier_dispo" name="numero_dossier_dispo">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{ $bien->biendetail->dossier_dispo_numero }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="dossier_cree_le_dossier_dispo">@lang('Crée le') </label>
                                <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                    <input type="date"
                                        value="{{ $bien->biendetail->dossier_dispo_dossier_cree_le }}"
                                        class="form-control " id="dossier_cree_le_dossier_dispo"
                                        name="dossier_cree_le_dossier_dispo">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{ $bien->biendetail->dossier_dispo_dossier_cree_le }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label"
                        for="disponibilite_immediate_dossier_dispo">@lang('Disponibilité') </label>
                    <div class="col-lg-6 col-md-6">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="disponibilite_immediate_dossier_dispo">@lang('Immédiate') </label>
                                <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                    @php  $disponibilite_immed = $bien->biendetail->dossier_dispo_disponibilite_immediate @endphp
                                    <label class="radio-inline"><input type="radio"
                                            @if ($disponibilite_immed == 'Non précisé') checked @endif
                                            value="@lang('Non précisé')" name="disponibilite_immediate_dossier_dispo"
                                            checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio"
                                            @if ($disponibilite_immed == 'Oui') checked @endif
                                            value="@lang('Oui')"
                                            name="disponibilite_immediate_dossier_dispo">@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio"
                                            @if ($disponibilite_immed == 'Non') checked @endif
                                            value="@lang('Non')"
                                            name="disponibilite_immediate_dossier_dispo">@lang('Non')</label>
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{ $bien->biendetail->dossier_dispo_disponibilite_immediate }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="disponible_le_dossier_dispo">@lang('Disponible le') </label>
                                <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                    <input type="date"
                                        value="{{ $bien->biendetail->dossier_dispo_disponible_le }}"
                                        class="form-control " id="disponible_le_dossier_dispo"
                                        name="disponible_le_dossier_dispo">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{ $bien->biendetail->dossier_dispo_disponible_le }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label"
                                    for="liberation_le_dossier_dispo">@lang('Libération le') </label>
                                <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                    <input type="date"
                                        value="{{ $bien->biendetail->dossier_dispo_liberation_le }}"
                                        class="form-control " id="liberation_le_dossier_dispo"
                                        name="liberation_le_dossier_dispo">
                                </div>
                                <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{ $bien->biendetail->dossier_dispo_liberation_le }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

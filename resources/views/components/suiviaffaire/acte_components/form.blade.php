<!--rdv acte-->
@php
    $struct1 = unserialize($bien->notaires)[1];
    $notaire2 = App\Models\Entite::findOrFail($struct1['notaire_id']);
@endphp
<div class="form-validation">
    <form class="form-valide2-acte form-horizontal" id="msform">
        {{ csrf_field() }}
        <!-- progressbar -->

        <ul id="progressbar">
            <li class="active" style="color:#8c8c8c; font-weight:bold;">Choix notaire</li>
            <li style="color:#8c8c8c; font-weight:bold;">Détails du rendez-vous</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>
            @if ($struct1['demande_rendez_vous'] === 0)
                <div class="panel lobipanel-basic panel-danger">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Demande de rendez-vous absente !</strong></div>
                    </div>
                    <div class="panel-body">
                        Asuurez-vous d'avoir fait la demande au préalable au notaire, un mail lui sera envoyé avec le
                        formulaire pour confirmer le rendez-vous, un accès temporaire
                        lui sera également créé afin qu'il puisse consulter les détails concernant l'affaire ainsi que
                        télécharger les documents nécessaires pour le dossier, vous
                        pouvez tout de meme créer le rendez-vous manuelement sans attendre la confirmation du notaire en
                        cliquant sur Suivant.<br><br>
                        <a type="button"
                            href="{{ route('suiviaffaire.notaire.appointement', [Crypt::encrypt($bien->id), 'acte']) }}"
                            class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i
                                class="ti-settings"></i>demande rendez-vous</a>
                    </div>
                </div>
            @endif
            @if ($struct1['demande_rendez_vous'] === 1)
                <div class="panel lobipanel-basic panel-warning">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Confirmation du notaire absente !</strong></div>
                    </div>
                    <div class="panel-body">
                        Le notaire n'a pas encore confirmé le rendz-vous et n'a pas rempli le formulaire suite à votre
                        dernière demande, si vous voulez plannifier manuelement le rendez-vous, cliquez sur Suivant.
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="form-group row" id="notaire_acte_choice">
                    <label class="col-sm-4 control-label" for="notaire_acte">Notaire acte<span
                            class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <select class="selectpicker col-lg-8" id="notaire_acte" name="notaire_acte"
                            data-live-search="false" data-style="btn-info btn-rounded" required="true" readonly>
                            <option selected value="{{ Crypt::encrypt($notaire2->id) }}"
                                data-content="<img class='avatar-img' src='{{ asset('/images/common/' . 'justice.png') }}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{ $notaire2->type }}</span> {{ $notaire2->raison_sociale }}">
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="button" name="next" class="next action-button" value="Suivant" />
        </fieldset>
        <fieldset>

            <div class="form-group row">
                <label class="col-sm-4 control-label" for="adresse_acte">Adresse du rendez-vous<span
                        class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <input type="text" id="adresse_acte" class="form-control" value="" name="adresse_acte"
                        placeholder="Ex: 25 Rue CARNOT..." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="cmpl_adresse_acte">Complément d'adresse</label>
                <div class="col-lg-4">
                    <input type="text" id="cmpl_adresse_acte" class="form-control" value=""
                        name="cmpl_adresse_acte" placeholder="Ex: 25 Rue CARNOT...">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="code_postal_acte">Code postal<span
                        class="text-danger">*</span></label>
                <div class="col-lg-2">
                    <input type="text" id="code_postal_acte" class="form-control" value=""
                        name="code_postal_acte" placeholder="Ex: 75008" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="ville_acte">Ville<span class="text-danger">*</span></label>
                <div class="col-lg-3">
                    <input type="text" id="ville_acte" class="form-control" value="" name="ville_acte"
                        placeholder="Ex: Paris..." required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="date_acte">Date du rendez vous<span
                        class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <input type="date" id="date_acte" class="form-control" value="" min=""
                        name="date_acte" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label" for="heure_acte">Heure du rendez vous<span
                        class="text-danger">*</span></label>
                <div class="col-lg-4">
                    <input type="time" id="heure_acte" class="form-control" value="" name="heure_acte"
                        required>
                </div>
            </div>
            <input type="button" name="previous" class="previous action-button btn-danger" value="Précedent" />
            <input type="submit" name="submit_acte" id="submit_acte" class="action-button" value="Valider">
        </fieldset>
    </form>
</div>
<!--fin rdv-->

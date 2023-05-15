<div class="col-lg-12">
    <div class="panel panel-info lobipanel-basic">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="card alert">
                <div class="card-body">
                    <div class="user-profile">
                        <div class="row">
                            <div class="col-lg-4">

                                <div class="user-skill">


                                    @if ($bien->statut === 'compromis')
                                        <a type="button" data-toggle="modal" data-target="#gestion_compromis"
                                            class="btn btn-info btn-rounded btn-addon btn-xs m-b-10"><i
                                                class="ti-panel"></i>Gestion compromis</a>
                                    @elseif($bien->statut === 'acte')
                                        <a type="button" data-toggle="modal" data-target="#gestion_acte"
                                            class="btn btn-pink btn-rounded btn-addon btn-xs m-b-10"><i
                                                class="ti-stamp"></i>Gestion acte</a>
                                    @endif

                                    @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
                                        @if ($compromis_actif != null)
                                            <div class="card" style="border: 5px solid #b7cae2; border-radius: 10px;">
                                                <div class="stat-widget-one">
                                                    <div class="stat-icon dib"><i
                                                            class="material-icons color-dark border-danger">loyalty</i>
                                                    </div>
                                                    <div class="stat-content dib">
                                                        <div class="stat-text"><strong
                                                                style="color:#ff712a;">Acquéreur</strong>
                                                        </div>
                                                        <div class="stat-digit">
                                                            <td><span><a target="_blanc"
                                                                        href="{{ route('contact.entite.show', Crypt::encrypt($compromis_actif->entite->id)) }}"
                                                                        data-toggle="tooltip"
                                                                        title="Voir le signatairer"><i
                                                                            class="large material-icons color-info">visibility</i></a>
                                                                </span></td>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="user-profile-name" style="color: #d68300;">Mandat N°
                                    <strong>{{ $bien->mandat->numero }}</strong>
                                </div>
                                <div class="custom-tab user-profile-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#1" aria-controls="1"
                                                role="tab" data-toggle="tab">Détails</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="1">
                                            <div class="contact-information">
                                                <div class="address-content">
                                                    <span class="contact-title"><strong>Objet:</strong></span>
                                                    <span
                                                        class="badge badge-default"><strong>{{ strtoupper($bien->type_affaire) }}</strong></span>
                                                </div>
                                                <div class="website-content">
                                                    <span class="contact-title"><strong>Statut du
                                                            mandat:</strong></span>
                                                    @if ($bien->mandat->statut === 'actif')
                                                        <span class="birth-date"><span
                                                                class="badge badge-success"><strong>{{ strtoupper($bien->mandat->statut) }}</strong></span></span>
                                                    @else
                                                        <span class="birth-date"><span
                                                                class="badge badge-danger"><strong>{{ strtoupper($bien->mandat->statut) }}</strong></span></span>
                                                    @endif
                                                </div>

                                                <div class="address-content">
                                                    <span class="contact-title"><strong>Prix de
                                                            vente:</strong></span>
                                                    <span class="badge badge-default">120000 €</span>
                                                </div>
                                                <div class="address-content">
                                                    <span class="contact-title"><strong>Honnoraires:</strong></span>
                                                    <span class="badge badge-default">6000 €</span>
                                                </div>
                                                <div class="address-content">
                                                    <span class="contact-title"><strong>Charge
                                                            Honnoraires</strong></span>
                                                    <span class="badge badge-default">Vendeur</span>
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
            <!--nav-->
            <div class="card-body">
                <ul class="nav nav-pills nav-tabs" id="zobi">
                    <li class="active">
                        <a data-toggle="pill" href="#home"><i class="ti-key"></i>
                            <strong>@lang('Visites')</strong> <span
                                class="badge badge-pink">{{ $bien->visites->count() }}</span>
                        </a>

                    </li>
                    <li>
                        <a data-toggle="pill" href="#nrv1"><i class="ti-wallet"></i>
                            <strong>@lang('Offres d\'achat')</strong> <span
                                class="badge badge-pink">{{ $bien->offreachats->count() }}</span>
                        </a>
                    </li>
                    @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
                        <li><a data-toggle="pill" href="#nrv2"><i class="ti-files"></i>
                                <strong>@lang('Documents vendeur')</strong></a></li>
                        <li><a data-toggle="pill" href="#nrv3"><i class="ti-files"></i>
                                <strong>@lang('Documents acquéreur')</strong></a></li>
                        <li><a data-toggle="pill" href="#nrv4"><i class="ti-target"></i>
                                <strong>@lang('Notaires')</strong></a></li>
                    @endif
                </ul>
                <br><br>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        @include('components.suiviaffaire.visite')
                    </div>
                    <div id="nrv1" class="tab-pane fade">
                        @include('components.suiviaffaire.offre')
                    </div>
                    @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
                        <div id="nrv2" class="tab-pane fade">
                            @include('components.suiviaffaire.doc_mandant')
                        </div>
                        <div id="nrv3" class="tab-pane fade">
                            @include('components.suiviaffaire.doc_acquereur')
                        </div>
                        <div id="nrv4" class="tab-pane fade">
                            @include('components.suiviaffaire.notaire')
                        </div>
                    @endif
                </div>
            </div>
            <!--end nav-->
        </div>
    </div>
</div>
<!---->
{{-- @include('components.suiviaffaire.state') --}}

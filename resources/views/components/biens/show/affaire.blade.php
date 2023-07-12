{{-- Informations sur le bien  && Prix public   --}}
<div class="row">


    {{-- Informations principales && Equipements du bien --}}


    <div class="col-md-7 col-lg-7 col-sm-7 ">
        <div class="row">

            <div class="col-lg-12" style="background: #5c96b3; color: white;">
                <h4> <strong>@lang('Informations')</strong> @lang('principales')</h4>
            </div>
            <div class="col-lg-12">
                <div class="panel-heading"> {{ strtoupper($bien->type_offre) }} | {{ $bien->surface_habitable }}
                    @lang('m²') {{ strtoupper($bien->type_bien) }} |
                    {{ strtoupper($bien->ville) }} ({{ $bien->code_postal }})</div>
                <div class="panel-body">
                    @if ($bien->type_bien != 'terrain')
                        {{ $bien->nombre_piece }} @lang('pièces')
                    @endif
                    {{ $bien->titre_annonce }}
                </div>
            </div>
        </div>

    </div>





    <div class="col-md-4 col-lg-4 col-sm-4 col-md-offset-1" style="background: #5c96b3; color: white;">
        <div class="row">
            <div class="col-md-6 col-lg-6">
                @if ($bien->type_offre == 'vente')
                    <h4> <strong>@lang('Prix public')</strong> </h4>
                    <h3>{{ $bien->prix_public }} @lang('€')</h3>
                @else
                    <h4> <strong>@lang('Loyer')</strong> </h4>
                    <h3>{{ $bien->loyer }} @lang('€')</h3>
                @endif
            </div>
            <div class="col-md-6 col-lg-6">
                <strong>@lang('Dossier n °') {{ $bien->numero_dossier }} </strong> <br>
                <strong>@lang('Mandat n °') {{ $bien->mandat->numero }} </strong>



            </div>
        </div>
    </div>

</div>
<hr>

{{-- Informations principales && Equipements du bien --}}
{{-- <div class="row">
    <div class="col-md-5 col-lg-5 col-sm-5 " style="background: #5c96b3; color: white;">
        <h4> <strong>@lang('Informations')</strong> @lang('principales')</h4>

    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1"
        style="background: #5c96b3; color: white;">
        <h4> <strong>@lang('Equipements')</strong> @lang('du bien')</h4>

    </div>

</div>

<div class="row">
    <div class="col-md-5 col-lg-5 col-sm-5 ">
        <div class="panel-heading"> {{ strtoupper($bien->type_offre) }} | {{ $bien->surface_habitable }}
            @lang('m²') {{ strtoupper($bien->type_bien) }} |
            {{ strtoupper($bien->ville) }} ({{ $bien->code_postal }})</div>
        <div class="panel-body">
            @if ($bien->type_bien != 'terrain')
                {{ $bien->nombre_piece }} @lang('pièces')
            @endif
            {{ $bien->titre_annonce }}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">

    </div>
</div> --}}






















{{-- <div class="col-lg-12">
    <div class="panel panel-info lobipanel-basic">
        <div class="panel-heading"></div>
        <div class="panel-body"> --}}
<div class="card alert">
    <div class="card-body">
        <div class="user-profile">
            <div class="row">
                <div class="col-lg-4">
                    <div class="user-skill">

                        @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
                            {{-- @if ($compromis_actif != null) --}}
                            <div class="card" style="border: 5px solid #b7cae2; border-radius: 10px;">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i
                                            class="material-icons color-dark border-danger">loyalty</i>
                                    </div>
                                    <div class="stat-content dib">
                                        <div class="stat-text"><strong style="color:#ff712a;">Affaire</strong></div>
                                        @if ($bien->statut === 'compromis')
                                            <a type="button"
                                                href="{{ route('compromis.create', Crypt::encrypt($bien->id)) }}"
                                                class="btn btn-info btn-rounded btn-addon btn-xs m-b-10">
                                                <i class="ti-panel"></i>Gestion compromis
                                            </a>
                                        @elseif($bien->statut === 'acte')
                                            <a type="button" data-toggle="modal" data-target="#gestion_acte"
                                                class="btn btn-pink btn-rounded btn-addon btn-xs m-b-10"><i
                                                    class="ti-stamp"></i>Gestion
                                                acte</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            {{-- @endif --}}
                        @endif
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
                <strong>@lang('Visites')</strong> <span class="badge badge-pink">{{ $bien->visites->count() }}</span>
            </a>

        </li>
        <li>
            <a data-toggle="pill" href="#nrv1"><i class="ti-wallet"></i>
                <strong>@lang('Offres d\'achat')</strong> <span
                    class="badge badge-pink">{{ $bien->offreachats->count() }}</span>
            </a>
        </li>
        {{-- @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
            <li><a data-toggle="pill" href="#nrv2"><i class="ti-files"></i>
                    <strong>@lang('Documents vendeur')</strong></a></li>
            <li><a data-toggle="pill" href="#nrv3"><i class="ti-files"></i>
                    <strong>@lang('Documents acquéreur')</strong></a></li>
        @endif --}}
    </ul>
    <br><br>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            @include('components.suiviaffaire.visite')
        </div>
        <div id="nrv1" class="tab-pane fade">
            @include('components.suiviaffaire.offre')
        </div>
        {{-- @if ($bien->statut === 'compromis' || $bien->statut === 'acte')
            <div id="nrv2" class="tab-pane fade">
                @include('components.suiviaffaire.doc_mandant')
            </div>
            <div id="nrv3" class="tab-pane fade">
                @include('components.suiviaffaire.doc_acquereur')
            </div>
        @endif --}}
    </div>
</div>
<!--end nav-->
{{-- </div>
    </div>
</div> --}}
<!---->
{{-- @include('components.suiviaffaire.state') --}}

{{-- Historique de l'annonce && Taxe foncière du bien --}}


<hr><br><br>
<div class="row">
    <div class="col-md-5 col-lg-5 col-sm-5 " style="background: #5c96b3; color: white;">
        <h4> <strong>@lang('Historique')</strong> @lang('du bien')</h4>

    </div>

</div>
<div class="row">
    <div class="col-md-5 col-lg-5 col-sm-5 ">
        <p>
            @lang('Ajouté le : ') {{ $bien->created_at->format('d-m-y à h:m') }}
        </p>
        <p>
            @lang('Dernière modification le : ') {{ $bien->updated_at->format('d-m-y à h:m') }}
        </p>
    </div>
</div>
<hr>

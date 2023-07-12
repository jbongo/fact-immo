@extends('layouts.app')
@section('content')
@section('page_title')
    Informations du contact
@endsection

<style>
    .container-biens {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .item-bien {
        /* flex: 1; */

        margin: 10px;
        padding: 10px;
        box-shadow: 1px 2px 10px #d8dadb;
        text-align: center;

    }
</style>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-6">
                    <div class="panel panel-default lobipanel-basic">
                        <div class="panel-heading" style="background-color:#2b4457; border-color:#2b4457; color:#fff">
                            Informations du contact.</div>
                        <div class="panel-body">
                            <div class="card alert">
                                <div class="card-body">
                                    <div class="user-profile">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="col-lg-12">
                                                    <div class="user-photo m-b-30">

                                                        @if ($contact->nature == 'Personne seule')
                                                            <i class="material-icons"
                                                                style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                person
                                                            </i>
                                                        @elseif($contact->nature == 'Couple')
                                                            <i class="material-icons"
                                                                style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                group
                                                            </i>
                                                        @else
                                                            <i class="material-icons"
                                                                style="font-size: 150px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">
                                                                contacts
                                                            </i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="user-work">
                                                    <h4 style="color: #32ade1;">&nbsp;</h4>
                                                    <div class="work-content">

                                                        @php
                                                            $color = [
                                                                'Partenaire' => 'badge-pink',
                                                                'Acquéreur' => 'badge-warning',
                                                                'Propriétaire' => 'badge-primary',
                                                                'Locataire' => 'badge-success',
                                                                'Notaire' => 'badge-danger',
                                                            ];
                                                            
                                                        @endphp

                                                        @foreach ($contact->typeContacts as $typeContact)
                                                            <span
                                                                class="badge {{ isset($color[$typeContact->type]) ? $color[$typeContact->type] : 'badge-default' }}">{{ $typeContact->type }}</span>
                                                        @endforeach
                                                        {{-- @if ($contact->est_partenaire)
                                                            <span class="badge badge-pink">Partenaire</span>
                                                        @endif

                                                        @if ($contact->est_acquereur)
                                                            <span class="badge badge-warning">Acquéreur</span>
                                                        @endif

                                                        @if ($contact->est_proprietaire)
                                                            <span class="badge badge-primary">Propriétaire</span>
                                                        @endif

                                                        @if ($contact->est_locataire)
                                                            <span class="badge badge-success">Locataire</span>
                                                        @endif

                                                        @if ($contact->est_notaire)
                                                            <span class="badge badge-danger">Notaire</span>
                                                        @endif --}}

                                                    </div>
                                                </div>
                                                <div class="user-skill">
                                                    <h4 style="color: #17475b;text-decoration: underline;">Options</h4>
                                                    <a type="button"
                                                        href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}"
                                                        class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i
                                                            class="ti-pencil"></i>Modifier</a>

                                                    {{-- <a type="button" data-toggle="modal"
                                                        data-target="#planifiate_usr"
                                                        class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10"><i
                                                            class="ti-email"></i>Envoyer un email</a> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="user-profile-name" style="color: #d68300;">
                                                    @if ($contact->nature == 'Couple')
                                                        {{ $contact->individu->civilite1 }} /
                                                        {{ $contact->individu->civilite2 }}
                                                        <br>
                                                        {{ $contact->individu->prenom1 }} {{ $contact->individu->nom1 }}
                                                        /
                                                        {{ $contact->individu->prenom2 }} {{ $contact->individu->nom2 }}
                                                    @else
                                                        {{ $contact->individu->civilite }}
                                                        {{ $contact->individu->nom }}
                                                        {{ $contact->individu->prenom }}
                                                    @endif

                                                </div>
                                                <div class="user-Location"><i class="ti-location-pin"></i>
                                                    {{ $contact->individu->ville }}</div>
                                                <div class="custom-tab user-profile-tab">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li role="presentation" class="active"><a href="#1"
                                                                aria-controls="1" role="tab"
                                                                data-toggle="tab">Détails</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="1">
                                                            <div class="contact-information">

                                                                @if ($contact->nature == 'Couple')
                                                                    <div class="email-content">
                                                                        <span
                                                                            class="contact-title"><strong>Email:</strong></span>
                                                                        <span class="contact-email"
                                                                            style="color: #ff435c; ">{{ $contact->individu->email1 }}</span>
                                                                        -
                                                                        <span class="contact-email"
                                                                            style="color: #ff435c; ">{{ $contact->individu->email2 }}</span>
                                                                    </div>
                                                                    <div class="phone-content">
                                                                        <span
                                                                            class="contact-title"><strong>Téléphone:</strong></span>
                                                                        <span class="phone-number"
                                                                            style="color: #1d4980; ">{{ $contact->individu->telephone_mobile1 }}
                                                                            @if ($contact->individu->telephone_mobile1 != null)
                                                                                -
                                                                            @endif
                                                                            {{ $contact->individu->telephone_fixe1 }}
                                                                        </span>
                                                                        <span class="phone-number"
                                                                            style="color: #1d4980;">/
                                                                            {{ $contact->individu->telephone_mobile2 }}
                                                                            @if ($contact->individu->telephone_mobile2 != null)
                                                                                -
                                                                            @endif
                                                                            {{ $contact->individu->telephone_fixe2 }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="email-content">
                                                                        <span
                                                                            class="contact-title"><strong>Email:</strong></span>
                                                                        <span class="contact-email"
                                                                            style="color: #ff435c; text-decoration: underline;">{{ $contact->individu->email }}</span>
                                                                    </div>
                                                                    <div class="phone-content">
                                                                        <span
                                                                            class="contact-title"><strong>Téléphone:</strong></span>
                                                                        <span class="phone-number"
                                                                            style="color: #ff435c; text-decoration: underline;">{{ $contact->individu->telephone_mobile }}
                                                                            @if ($contact->individu->telephone_mobile != null)
                                                                                -
                                                                            @endif
                                                                            {{ $contact->individu->telephone_fixe }}
                                                                        </span>
                                                                    </div>
                                                                @endif


                                                                <div class="address-content">
                                                                    <span
                                                                        class="contact-title"><strong>Adresse:</strong></span>
                                                                    <span
                                                                        class="mail-address">{{ $contact->individu->adresse }}</span>
                                                                </div>
                                                                <div class="website-content">
                                                                    <span class="contact-title">
                                                                        <strong>Code postal:</strong></span>
                                                                    <span
                                                                        class="contact-website">{{ $contact->individu->code_postal }}</span>
                                                                </div>
                                                                <div class="website-content">
                                                                    <span
                                                                        class="contact-title"><strong>Ville:</strong></span>
                                                                    <span
                                                                        class="contact-website">{{ $contact->individu->ville }}</span>
                                                                </div>
                                                                <div class="website-content">
                                                                    <span class="contact-title"><strong>Source du
                                                                            contact:</strong>
                                                                    </span>
                                                                    <span
                                                                        class="contact-website">{{ $contact->individu->source_contact }}</span>
                                                                </div>
                                                                <div class="website-content">
                                                                    <span class="contact-title"><strong>Notes:</strong>
                                                                    </span>
                                                                    <span
                                                                        class="contact-website">{{ $contact->individu->note }}</span>
                                                                </div>
                                                                <div class="gender-content">
                                                                    <span class="contact-title"><strong>Ajouté
                                                                            le:</strong></span>
                                                                    <span
                                                                        class="gender">{{ date('d-m-Y', strtotime($contact->created_at)) }}</span>
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
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default lobipanel-basic">
                        <div class="panel-heading" style="background-color:#43471f; border-color:#43471f; color:#fff">
                            Biens attachés au contact.</div>
                        <div class="panel-body">
                            <div class="card alert">
                                <div class="card-body">
                                    <div class="user-profile">
                                        <div class="row">

                                            <div class="container-biens">


                                                @foreach ($contact->biens as $bien)
                                                    <div class="item-bien">
                                                        <div>
                                                            @foreach ($bien->photosbiens as $photos)
                                                                @if ($photos->visibilite == 'visible' && $photos->image_position == 1)
                                                                    <img src="{{ asset('images/photos_bien/' . $photos->filename) }}"
                                                                        width="200px" height="150px" alt="">
                                                                    @php break; @endphp
                                                                @endif
                                                            @endforeach
                                                        </div>

                                                        <div>
                                                            <h4>
                                                                <b> {{ $bien->type_bien }}</b>
                                                                @if ($bien->type_bien != 'terrain')
                                                                    - {{ $bien->nombre_piece }} @lang('pièces') <br>
                                                                    - {{ $bien->surface_habitable }} @lang('m²')
                                                                @endif

                                                            </h4>

                                                            <h5> {{ $bien->ville }} ({{ $bien->code_postal }})</h5>

                                                            @if ($bien->type_offre == 'vente')
                                                                <h4><b> <span style="color:blue">
                                                                            {{ $bien->prix_public }}@lang('€')</b>
                                                                    </span>
                                                                </h4>
                                                            @else
                                                                <h4><b> <span style="color:blue">{{ $bien->loyer }}
                                                                            @lang('€')</b>
                                                                    </span> </h4>
                                                            @endif
                                                            <h6>@lang('Ajouté le '){{ $bien->created_at->format('d-m-Y') }}
                                                            </h6>
                                                            </h5>

                                                        </div>

                                                        <div>

                                                            <a href="{{ route('bien.show', Crypt::encrypt($bien->id)) }}"
                                                                title="@lang('Détails') {{ $bien->nom }}">
                                                                <img src="{{ asset('images/fleche-direction.png') }}"
                                                                    width="50px" height="55px" alt="">
                                                            </a>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-6">
                    <div class="panel panel-primary lobipanel-basic">
                        <div class="panel-heading" style="background-color:#2b4457">Entités associés.</div>
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow-x: inherit !important;">
                                <table id="individu_entite" class=" table student-data-table  m-t-20 table-hover"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('Type d\'entité')</th>
                                            <th>@lang('Raison sociale')</th>
                                            <th>@lang('Code_postal')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contact->individu->individu->entites as $entite)
                                        <tr>
                                            <td style="border-top: 4px solid #b8c7ca;">
                                                <span class="badge badge-danger">{{$entite->type}}</span>
                                            </td>
                                            <td style="border-top: 4px solid #b8c7ca;">{{$entite->raison_sociale}}</td>
                                            <td
                                                style="border-top: 4px solid #b8c7ca; color: #32ade1; text-decoration: underline;">
                                                <strong>{{$entite->code_postal}}</strong>
                                            </td>
                                            <td style="border-top: 4px solid #b8c7ca;">
                                                <span><a class="show1"
                                                        href="{{route('contact.entite.show', Crypt::encrypt($entite->id))}}"
                                                        title="@lang('Détails')"><i
                                                            class="large material-icons color-info">visibility</i></a></span>
                                                <span><a href="{{route('contact.individu.dissociate', [Crypt::encrypt($contact->individu->id), Crypt::encrypt($entite->id)])}}"
                                                        class="dissociate_entite" data-toggle="tooltip"
                                                        title="@lang('Dissocier')"><i
                                                            class="large material-icons color-danger">clear</i></a></span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>
@include('components.contact.individu_edit')
@stop
@section('js-content')
<script>
    $(document).ready(function() {
        $('#individu_entite').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        });
    });
</script>
<script>
    $("#code_postal").autocomplete({
        source: function(request, response) {
            $.ajax({
                beforeSend: function() {},
                url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                    "input[name='code_postal']").val(),
                data: {
                    q: request.term
                },
                dataType: "json",
                success: function(data) {
                    var postcodes = [];
                    response($.map(data.features, function(item) {
                        // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                        if ($.inArray(item.properties.city, postcodes) == -1) {
                            postcodes.push(item.properties.postcode);
                            return {
                                label: item.properties.postcode + " - " + item
                                    .properties.city,
                                city: item.properties.city,
                                value: item.properties.postcode
                            };
                        }
                    }));
                }
            });
        },
        // On remplit aussi la ville
        select: function(event, ui) {
            $('#ville').val(ui.item.city);
        }
    });
    $("#ville").autocomplete({
        source: function(request, response) {
            $.ajax({
                beforeSend: function() {},
                url: "https://api-adresse.data.gouv.fr/search/?city=" + $("input[name='ville']")
                    .val(),
                data: {
                    q: request.term
                },
                dataType: "json",
                success: function(data) {
                    var cities = [];
                    response($.map(data.features, function(item) {
                        // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                        if ($.inArray(item.properties.postcode, cities) == -1) {
                            cities.push(item.properties.postcode);
                            return {
                                label: item.properties.postcode + " - " + item
                                    .properties.city,
                                postcode: item.properties.postcode,
                                value: item.properties.city
                            };
                        }
                    }));
                }
            });
        },
        // On remplit aussi le CP
        select: function(event, ui) {
            $('#code_postal').val(ui.item.postcode);
        }
    });
    $("#adresse").autocomplete({
        source: function(request, response) {
            $.ajax({
                beforeSend: function() {},
                url: "https://api-adresse.data.gouv.fr/search/?postcode=" + $(
                    "input[name='code_postal']").val(),
                data: {
                    q: request.term
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data.features, function(item) {
                        return {
                            label: item.properties.name,
                            value: item.properties.name
                        };
                    }));
                }
            });
        }
    });
</script>
<script>
    $('a.dissociate_entite').click(function(b) {
        b.preventDefault();
        let that = $(this);
        var route = that.attr('href');
        var reload = 1;
        var warning = 'L\'entité sera dissociée de l\'individu, continuer ?';
        processAjaxSwal(route, warning, reload);
    })
</script>
@endsection

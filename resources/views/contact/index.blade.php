@extends('layouts.app')
@section('content')
@section('page_title')
    Contacts
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card alert">
            <a href="{{ route('contact.add') }}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                    class="ti-plus"></i>@lang('Ajouter')</a>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="entitelist" class="table-hover table student-data-table  m-t-20 table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Infos contact')</th>
                                <th>@lang('Adresse')</th>
                                <th>@lang('Individus associés')</th>
                                <th>@lang('Biens associés')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                        @if ($contact->nature == 'Personne morale')
                                            <img class="img-thumbnail"
                                                style=" width: 60px; height: 60px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                src="{{ asset('/images/photo_profile/' . 'entreprise.png') }}"
                                                alt="" />
                                            <p>
                                                <span style="font-size: 18px; font-weigth:bold;">
                                                    {{ $contact->entite->forme_juridique }} </span>
                                                <span style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                    {{ $contact->entite->raison_sociale }}</span>
                                            </p>
                                        @elseif($contact->nature == 'Personne seule')
                                            <img class="img-thumbnail"
                                                style=" width: 60px; height: 60px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                src="{{ asset('/images/photo_profile/' . 'user1.png') }}"
                                                alt="" />
                                            <p>
                                                <span style="font-size: 18px; font-weigth:bold;">
                                                    {{ $contact->individu->civilite }} </span>
                                                <span
                                                    style="font-size: 18px; font-weigth:bold; color:#8031db">{{ $contact->individu->prenom }}
                                                    {{ $contact->individu->nom }}</span>
                                            </p>
                                        @elseif($contact->nature == 'Groupe')
                                            <img class="img-thumbnail"
                                                style=" width: 60px; height: 60px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                src="{{ asset('/images/photo_profile/' . 'groupe.svg') }}"
                                                alt="" />
                                            <p>
                                                <span style="font-size: 18px; font-weigth:bold;">
                                                    {{ $contact->entite->type }} </span>

                                                <span style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                    {{ $contact->entite->nom }} </span>
                                            </p>
                                        @elseif($contact->nature == 'Couple')
                                            <img class="img-thumbnail"
                                                style=" width: 60px; height: 60px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                src="{{ asset('/images/photo_profile/' . 'couple.png') }}"
                                                alt="" />
                                            <p>
                                                <span style="font-size: 18px; font-weigth:bold;">
                                                    {{ $contact->individu->civilite1 }} /
                                                    {{ $contact->individu->civilite2 }} </span> <br>
                                                <span style="font-size: 18px; font-weigth:bold; color:#8031db">
                                                    {{ $contact->individu->nom1 }} / {{ $contact->individu->nom2 }}
                                                </span>
                                            </p>
                                        @else
                                            <img class="img-thumbnail"
                                                style=" width: 60px; height: 60px; border: 2px solid #8ba2ad;  border-radius: 20px; padding: 3px;"
                                                src="{{ asset('/images/photo_profile/' . 'contact.jpg') }}"
                                                alt="" />
                                        @endif
                                    </td>

                                    <td style="border-top: 4px solid #b8c7ca;">



                                        @if ($contact->est_partenaire)
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
                                        @endif


                                    </td>


                                    @if ($contact->nature == 'Personne morale')
                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->email }} </span>
                                                <br>
                                                <span style=" font-weigth:bold;">
                                                    {{ $contact->entite->telephone_fixe }} - </span> <span
                                                    style="font-weigth:bold;"> {{ $contact->entite->telephone_mobile }}
                                                </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->adresse }}
                                                </span> <br>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->code_postal }} -
                                                </span> <span style="font-weigth:bold;"> {{ $contact->entite->ville }}
                                                </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <span class="badge badge-primary">0</span>

                                        </td>
                                    @elseif($contact->nature == 'Personne seule')
                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->email }}
                                                </span> <br>
                                                <span style=" font-weigth:bold;">
                                                    {{ $contact->individu->telephone_fixe }} - </span> <span
                                                    style="font-weigth:bold;">
                                                    {{ $contact->individu->telephone_mobile }} </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->adresse }}
                                                </span> <br>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->code_postal }}
                                                    - </span> <span style="font-weigth:bold;">
                                                    {{ $contact->individu->ville }} </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <span class="badge badge-primary">0</span>

                                        </td>
                                    @elseif($contact->nature == 'Groupe')
                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->email }} </span>
                                                <br>
                                                <span style=" font-weigth:bold;">
                                                    {{ $contact->entite->telephone_fixe }} - </span> <span
                                                    style="font-weigth:bold;"> {{ $contact->entite->telephone_mobile }}
                                                </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->adresse }}
                                                </span> <br>
                                                <span style=" font-weigth:bold;"> {{ $contact->entite->code_postal }} -
                                                </span> <span style="font-weigth:bold;"> {{ $contact->entite->ville }}
                                                </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">

                                        </td>
                                    @elseif($contact->nature == 'Couple')
                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->email1 }} /
                                                    {{ $contact->individu->email2 }}</span> <br>
                                                <span style=" font-weigth:bold;">
                                                    {{ $contact->individu->telephone_fixe1 }} - </span> <span
                                                    style="font-weigth:bold;">
                                                    {{ $contact->individu->telephone_mobile1 }} </span> /
                                                <span style=" font-weigth:bold;">
                                                    {{ $contact->individu->telephone_fixe2 }} - </span> <span
                                                    style="font-weigth:bold;">
                                                    {{ $contact->individu->telephone_mobile2 }} </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <p>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->adresse }}
                                                </span> <br>
                                                <span style=" font-weigth:bold;"> {{ $contact->individu->code_postal }}
                                                    - </span> <span style="font-weigth:bold;">
                                                    {{ $contact->individu->ville }} </span> <br>
                                            </p>
                                        </td>

                                        <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                            <span class="badge badge-primary">0</span>

                                        </td>
                                    @else
                                    @endif

                                    <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                        <span class="badge badge-danger">5</span>

                                    </td>



                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span><a class="show1"
                                                href="{{ route('contact.show', Crypt::encrypt($contact->id)) }}"
                                                title="@lang('Détails')"><i
                                                    class="large material-icons color-info">visibility</i></a></span>
                                        <span><a class="show1"
                                                href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}"
                                                title="@lang('modifier')"><i
                                                    class="large material-icons color-success">edit</i></a></span>
                                        <span><a href="#" class="archive_notaire" data-toggle="tooltip"
                                                title="@lang('Archiver')"><i
                                                    class="large material-icons color-danger">delete</i></a></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.contact.entite_add')
@stop
@section('js-content')
<script>
    $(document).ready(function() {
        $('#entitelist').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        ($('#type').val() === "fournisseur") ? $('#sect1').show(): $('#sect1').hide();
        $('#type').change(function(e) {
            ($('#type').val() === "fournisseur") ? $('#sect1').show(): $('#sect1').hide();
        });
        if ($('#sous_type').val() === "personne_simple" || $('#sous_type').val() === "couple")
            $('#sect2').hide();
        else
            $('#sect2').show();
        $('#sous_type').change(function(e) {
            if ($('#sous_type').val() === "personne_simple" || $('#sous_type').val() === "couple")
                $('#sect2').hide();
            else
                $('#sect2').show();
        });
        if ($('#type').val() === "acquereur" || $('#type').val() === "mandant" || $('#type').val() === "autre")
            $('#sect3').show();
        else {
            $('#sect3').hide();
            $('#sect2').show();
            $('#sous_type').val("personne_morale");
        }
        $('#type').change(function(e) {
            if ($('#type').val() === "acquereur" || $('#type').val() === "mandant" || $('#type')
            .val() === "autre")
                $('#sect3').show();
            else {
                $('#sect3').hide();
                $('#sect2').show();
                $('#sous_type').val("personne_morale");
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
@endsection

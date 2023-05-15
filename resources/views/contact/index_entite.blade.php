@extends('layouts.app')
@section('content')
@section('page_title')
    Ajout d'une affaire
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card alert">
            <a href="#" data-toggle="modal" data-target="#entite_add"
                class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                    class="ti-plus"></i>@lang('Ajouter')</a>
            <div class="card-body">
                <div class="col-lg-4">
                    <div class="card bg-pink">
                        <div class="stat-widget-six">
                            <div class="stat-icon">
                                <i class="material-icons">person_pin</i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong>Acquéreurs</strong></div>
                                    <div class="stat-text"><strong>Total:
                                            {{ $query->where('type', 'acquereur')->count() }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-danger">
                        <div class="stat-widget-six">
                            <div class="stat-icon">
                                <i class="material-icons">person_pin</i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong>Mandants</strong></div>
                                    <div class="stat-text"><strong>Total:
                                            {{ $query->where('type', 'mandant')->count() }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-warning">
                        <div class="stat-widget-six">
                            <div class="stat-icon">
                                <i class="material-icons">check_circle</i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-heading"><strong>Toutes les entités</strong></div>
                                    <div class="stat-text"><strong>Total: {{ $query->count() }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="entitelist" class="table-hover table student-data-table  m-t-20 table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Raison sociale')</th>
                                <th>@lang('Forme juridique')</th>
                                <th>@lang('Personalité juridique')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Téléphone')</th>
                                <th>@lang('Code postal')</th>
                                <th>@lang('Individus associés')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $one)
                                <tr>
                                    <td style=" min-width: 120px; border-top: 4px solid #b8c7ca;">
                                        <img class="img-thumbnail"
                                            style="object-fit: cover; width: 100px; height: 100px; border: 2px solid #8ba2ad;background: #f0f0f0; border-style: solid; border-radius: 20px; padding: 3px;"
                                            src="{{ asset('/images/common/' . 'justice.png') }}" alt="" />
                                    </td>
                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span class="badge badge-pink">{{ $one->type }}</span>
                                    </td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->raison_sociale }}</td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->forme_juridique }}</td>
                                    <td style="border-top: 4px solid #b8c7ca;"><span
                                            class="badge badge-default">{{ $one->sous_type }}</span></td>
                                    <td
                                        style="border-top: 4px solid #b8c7ca; color: #32ade1; text-decoration: underline;">
                                        <strong>{{ $one->email }}</strong> </td>
                                    <td
                                        style="border-top: 4px solid #b8c7ca; color: brown; text-decoration: underline;">
                                        <strong> {{ $one->telephone }}</strong> </td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->code_postal }}</td>
                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span class="badge badge-warning">{{ $one->individus->count() }}</span>
                                    </td>
                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span><a class="show1"
                                                href="{{ route('contact.entite.show', Crypt::encrypt($one->id)) }}"
                                                title="@lang('Détails')"><i
                                                    class="large material-icons color-info">visibility</i></a></span>
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

@extends('layouts.app')
@section('content')
@section('page_title')
    Gestion des individus
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card alert">
            <a href="#" data-toggle="modal" data-target="#individu_add"
                class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                    class="ti-plus"></i>@lang('Ajouter')</a>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: inherit !important;">
                    <table id="individulist" class="table-hover table student-data-table  m-t-20 table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>@lang('Civilité')</th>
                                <th>@lang('Nom et prenom')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Téléphone')</th>
                                <th>@lang('Ville')</th>
                                <th>@lang('Code_postal')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $one)
                                <tr>
                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span class="badge badge-pink">{{ $one->civilite }}</span>
                                    </td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->nom }} {{ $one->prenom }}
                                    </td>
                                    <td
                                        style="border-top: 4px solid #b8c7ca; color: #32ade1; text-decoration: underline;">
                                        <strong>{{ $one->email }}</strong> </td>
                                    <td
                                        style="border-top: 4px solid #b8c7ca; color: brown; text-decoration: underline;">
                                        <strong> {{ $one->telephone }}</strong> </td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->ville }}</td>
                                    <td style="border-top: 4px solid #b8c7ca;">{{ $one->code_postal }}</td>
                                    <td style="border-top: 4px solid #b8c7ca;">
                                        <span><a class="show1"
                                                href="{{ route('contact.individu.show', CryptId($one->id)) }}"
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
@include('components.contact.individu_add')
@stop
@section('js-content')
<script>
    $(document).ready(function() {
        $('#individulist').DataTable({
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
@endsection

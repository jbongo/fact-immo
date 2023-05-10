@extends('layouts.app')
@section('content')
@section('page_title')
    Annonces
@endsection
<style>
    .btn-blue {
        background-color: #03a9f5;
        color: white;
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .linetop {
        border-top: 1px dotted;
    }
</style>

<div class="row">

    <div class="col-lg-12">
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a>
            </div>
        @endif
    </div>

</div>

<div class="row">
    <div class="col-lg-5 col-md-5">
        <a href="{{ route('diffusion_prog.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                class="ti-arrow-left "></i>@lang('Retour')</a>
    </div>

    <div class="col-lg-7 col-md-7">
        <div class="card alert nestable-cart">
            <div class="card-header">


                <div class="row col-lg-6 col-md-6">
                    <h4><strong style="color:blueviolet;">@lang('Total des annonces') :</strong><a href="#"> <span
                                class="badge">{{-- {{count($bien->annonces)}} --}}</span></a></h4>
                    <br>
                    <a type="button" href="{{ route('annonce.create', $bien_id_crypt) }}"
                        class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                            class="ti-pencil-alt"></i>@lang('Ajouter une annonce')</a>
                </div>
                <div class="row col-lg-6 col-md-6">
                    <h4>
                        <b> {{ $bien->type_bien }}</b>
                        @if ($bien->type_bien != 'terrain')
                            - {{ $bien->nombre_piece }} @lang('pièces')
                        @endif
                        - {{ $bien->surface_habitable }} @lang('m²')
                    </h4>
                    <h5> {{ $bien->ville }} ({{ $bien->code_postal }})</h5><br>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: inherit !important;">
                <table id="example" class=" table student-data-table  m-t-20 " style="width:100%">
                    <thead>
                        <tr>
                            <th>@lang('#')</th>
                            <th>@lang('titre')</th>
                            <th>@lang('prix')</th>
                            <th>@lang('photos/Description')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($annonces as $annonce)
                            <tr>
                                <td width="10%">
                                    <span>{{ $annonce->identifiant_annonce }}</span>
                                </td>
                                <td width="20%">
                                    <span>{{ $annonce->titre }}</span>
                                </td>

                                <td width="5%">
                                    <span>{{ $annonce->prix }} @lang('€')</span>
                                </td>
                                <td width="60%">
                                    <a class="btn btn-primary" data-toggle="collapse" href="#{{ $annonce->id }}"
                                        role="button" aria-expanded="false" aria-controls="">Voir</a>
                                    <div class="row">
                                        <div class="col">
                                            <div class="collapse multi-collapse" id="{{ $annonce->id }}">
                                                <div class="card card-body">
                                                    <p>{{ $annonce->description }}</p>
                                                    <hr>
                                                    <ul id="sortable_visible">
                                                        @foreach ($annonce->photosannonce as $photosbien)
                                                            @if ($photosbien->visibilite == 'visible')
                                                                <div class="col-lg-3 col-md-3"
                                                                    id="{{ $photosbien->id }}">
                                                                    <div
                                                                        style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                                                        <li><span class="badge badge-info "></span>
                                                                            <p><img src="{{ asset('/images/photos_bien/' . $photosbien->resized_name) }}"
                                                                                    alt="aaa" width="100%"
                                                                                    height="120px"></p>
                                                                        </li>
                                                                        <p
                                                                            style="border: 3px solid green; text-align:center">
                                                                            <a href="{{ route('photoDelete', $photosbien->id) }}"
                                                                                class="delete" data-toggle="tooltip"
                                                                                title="@lang('Supprimer cette photo')"><i
                                                                                    class="material-icons">delete_forever</i>
                                                                            </a>
                                                                            <a href="{{ route('bien.getPhoto', $photosbien->id) }}"
                                                                                title="@lang('Télécharger cette photo')"><i
                                                                                    class="material-icons">file_download</i>
                                                                            </a>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $annonce_id = Crypt::encrypt($annonce->id);
                                    @endphp
                                    <a href="{{ route('annonce.edit', $annonce_id) }}" type="button"
                                        class="btn btn-link btn-outline btn-rounded m-b-10 m-l-5"
                                        title="@lang('Modifier cette annonce') ">
                                        <i class="ti-pencil-alt"> </i> @lang('Modifier')
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





@endsection
@section('js-content')
@endsection

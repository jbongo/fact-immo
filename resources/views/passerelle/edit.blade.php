@extends('layouts.app')
@section('content')
@section('page_title')
    Modification de la passerelle {{ $passerelle->nom }}
@endsection
@if (session('ok'))
    <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        <strong> {{ session('ok') }}</strong>
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <a href="{{ route('passerelle.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                        class="ti-arrow-left "></i>@lang('Liste des passerelles')</a>
                <br>
                <br>
                <hr>

                <div class="form-validation">
                    <form class="form-valide" action="{{ route('passerelle.update', $passerelle->id) }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="site"> @lang('Type de passerelle') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <select
                                    class="js-select2 form-control {{ $errors->has('type_passerelle') ? 'is-invalid' : '' }}"
                                    id="type_passerelle" name="type_passerelle" style="width: 100%;"
                                    data-placeholder="Choose one.." required>

                                    @if (isset($passerelle->type))
                                        <option value="{{ $passerelle->type }}">{{ $passerelle->type }}</option>
                                    @endif
                                    <option value="Avec abonnement">@lang('Avec abonnement') </option>
                                    <option value="Sans abonnement">@lang('Sans abonnement') </option>
                                    <option value="Institutionnelle et partenaire">@lang('Institutionnelle et partenaire') </option>

                                </select>
                                @if ($errors->has('type_passerelle'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('type_passerelle') }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="nom"> @lang('Libellé de la passerelle') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                    value="{{ old('nom') ? old('nom') : $passerelle->nom }}" id="nom"
                                    name="nom" placeholder="leboncoin" required>
                                @if ($errors->has('nom'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="site"> @lang('site (site)') <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text"
                                    class="form-control {{ $errors->has('site') ? 'is-invalid' : '' }}"
                                    value="{{ old('site') ? old('site') : $passerelle->site }}" id="site"
                                    name="site" placeholder="http://leboncoin.fr" required>
                                @if ($errors->has('site'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('site') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="logo">@lang('Modifier le logo')</label>
                            <div class="col-lg-4">
                                <input type="file"
                                    class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                    value="{{ old('logo') }}" id="logo" name="logo">
                                @if ($errors->has('logo'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="contact">@lang('Contact') </label>
                            <div class="col-lg-6">
                                <input type="text"
                                    class="form-control {{ $errors->has('contact') ? ' is-invalid' : '' }}"
                                    id="contact" value="{{ old('contact') ? old('contact') : $passerelle->contact }}"
                                    name="contact" placeholder="Email, tel">
                                @if ($errors->has('contact'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('contact') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="text_ajouter">@lang('Texte à ajouter en fin d\'annonce')</label>
                            <div class="col-lg-6">
                                <textarea name="text_ajouter" class="form-control {{ $errors->has('text_ajouter') ? ' is-invalid' : '' }}"
                                    id="" cols="30" rows="10">{{ old('text_ajouter') ? old('text_ajouter') : $passerelle->texte_fin_annonce }}  </textarea>
                                @if ($errors->has('text_ajouter'))
                                    <br>
                                    <div class="alert alert-warning ">
                                        <strong>{{ $errors->first('text_ajouter') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" class="btn btn-primary">@lang('Modifier')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js-content')

@endsection

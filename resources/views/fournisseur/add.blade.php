@extends('layouts.app')
@section('content')
@section('page_title')
    Ajout d'un fournisseur
@endsection
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('ok') }}</strong>
            </div>
        @endif
        <div class="card">
            <div class="col-lg-12">
                <a href="{{ route('fournisseur.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                        class="ti-angle-double-left"></i>@lang('Liste des fournisseurs')</a>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide form-horizontal" action="{{ route('fournisseur.store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="row">
                            <hr>
                            <hr>
                            <hr>
                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="type">Type <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <select
                                            class="js-select2 form-control {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                            id="type" name="type" style="width: 100%;"
                                            data-placeholder="Choose one.." required>
                                            <option value="{{ old('type') }}">{{ old('statut') }}</option>
                                            <option value="passerelle">passerelle</option>
                                            <option value="autre">autre</option>

                                        </select>
                                        @if ($errors->has('type'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                            value="{{ old('nom') }}" id="nom" name="nom"
                                            placeholder="Nom.." required>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Site web
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="url"
                                            class="form-control {{ $errors->has('site_web') ? ' is-invalid' : '' }}"
                                            value="{{ old('site_web') }}" id="site_web" name="site_web"
                                            placeholder="site web..">
                                        @if ($errors->has('site_web'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('site_web') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone1">Contact
                                        1</label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('telephone1') ? ' is-invalid' : '' }}"
                                            id="telephone1" value="{{ old('telephone1') }}" name="telephone1"
                                            placeholder="">
                                        @if ($errors->has('telephone1'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('telephone1') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            id="email" value="{{ old('email') }}" name="email"
                                            placeholder="Email..">
                                        @if ($errors->has('email'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="login">Login
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('login') ? ' is-invalid' : '' }}"
                                            value="{{ old('login') }}" id="login" name="login" placeholder="">
                                        @if ($errors->has('login'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('login') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="password">Mot de passe
                                    </label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            value="{{ old('password') }}" id="password" name="password">
                                        @if ($errors->has('password'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone2">Contact
                                        2</label>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <input type="text"
                                            class="form-control {{ $errors->has('telephone2') ? ' is-invalid' : '' }}"
                                            id="telephone2" value="{{ old('telephone2') }}" name="telephone2"
                                            placeholder="">
                                        @if ($errors->has('telephone2'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{ $errors->first('telephone2') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row" style="text-align: center; margin-top: 50px;">
                            <div class="col-lg-8 ml-auto">
                                <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"
                                    id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
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

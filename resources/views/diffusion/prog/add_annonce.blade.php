@extends('layouts.app')
@section('content')
@section('page_title')
    Ajoutez une annonce - <span class="text-danger"> {{ $bien->type_offre }} de {{ $bien->type_bien }} à
        {{ $bien->prix_public }} € -
        {{ $bien->ville }} </span>
@endsection
@if (session('ok'))
    <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

        <strong> {{ session('ok') }}</strong>
    </div>
@endif
<div class="row">
    <div class="card alert">

        <div class="col-lg-10">
            <a href="{{ url()->previous() }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i
                    class="ti-arrow-left "></i>@lang('Retour')</a>
        </div>
        <hr>
        <hr>
        <hr>
        <div class="card-body">

            <div class="form-validation">
                <form class="form-valide" action="{{ route('annonce.add') }}" method="post">
                    {{ csrf_field() }}

                    <input type="text" hidden value="{{ $bien->id }}" name="bien_id">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="identifiant_annonce">@lang('Donnez un identifiant à votre annonce') <span
                                class="text-danger">* </span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="identifiant_annonce"
                                value="{{ old('identifiant_annonce') }}" name="identifiant_annonce" required>
                            @if ($errors->has('identifiant_annonce'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{ $errors->first('identifiant_annonce') }}</strong>
                                </div>
                            @endif
                        </div>

                    </div>
                    <br>
                    <hr>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="titre">@lang('Titre') <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="titre"
                                value="{{ old('titre') ? old('titre') : $bien->titre_annonce }}" name="titre"
                                required>
                            @if ($errors->has('titre'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{ $errors->first('titre') }}</strong>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="description">@lang('Description') <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="form-control" required name="description" id="" cols="30" rows="10"> {{ old('description') ? old('description') : $bien->description_annonce }} </textarea>
                            @if ($errors->has('description'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="prix">@lang('Prix') <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="number" class="form-control "
                                value="{{ old('prix') ? old('prix') : $bien->prix_public }}" id="titre"
                                name="prix" required>
                            @if ($errors->has('prix'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{ $errors->first('prix') }}</strong>
                                </div>
                            @endif
                        </div>

                    </div>
                    <br><br><br><br><br><br>
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-8 col-md-8 ml-auto">
                            <button type="submit" class="btn btn-success btn-lg">@lang('Etape suivante') <i
                                    class="ti-arrow-right "></i></button>
                        </div>
                    </div>
                </form>
            </div>




        </div>
    </div>
</div>
@stop
@section('js-content')


@endsection

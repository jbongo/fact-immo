<div class="modal fade" id="visite_add" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Plannifier une visite</strong></h5>
            </div>
            <div class="modal-body">
                <div class="form-validation">
                    <form class="form-appel form-horizontal form-visit"
                        action="{{ route('suiviaffaire.visite.add', Crypt::encrypt($bien->id)) }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="visitable_type">Type du visiteur<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-3">
                                <select class="js-select2 form-control" id="visitable_type" name="visitable_type"
                                    required>
                                    <option value="{{ Entite::class }}">Entité</option>
                                    <option value="{{ Individu::class }}">Individu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="vst1">
                            <label class="col-sm-4 control-label" for="visitable_id_entite">Associer le visiteur
                                (Entité)<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select class="selectpicker col-lg-8" id="visitable_id1" name="visitable_id_entite"
                                    data-live-search="true" data-style="btn-warning btn-rounded" required>
                                    <option></option>
                                    @foreach (Auth::user()->entites as $dr)
                                        <option value="{{ Crypt::encrypt($dr->id) }}"
                                            data-content="<img class='avatar-img' src='{{ asset('/images/common/' . 'justice.png') }}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{ $dr->type }}</span> {{ $dr->raison_sociale }}"
                                            data-tokens="{{ $dr->type }} {{ $dr->raison_sociale }} {{ $dr->forme_juridique }} {{ $dr->adresse }} {{ $dr->email }} {{ $dr->telephone }} {{ $dr->code_postal }} {{ $dr->ville }}">
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="vst2">
                            <label class="col-sm-4 control-label" for="visitable_id_individu">Associer le visiteur
                                (Individu)<span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select class="selectpicker col-lg-8" id="visitable_id2" name="visitable_id_individu"
                                    data-live-search="true" data-style="btn-info btn-rounded" required>
                                    <option></option>
                                    @foreach (Auth::user()->individus as $dr)
                                        <option value="{{ Crypt::encrypt($dr->id) }}"
                                            data-content="<img class='avatar-img' src='http://127.0.0.1:8000/images/photo_profile/default.png' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{ $dr->civilite }}</span> {{ $dr->nom }} {{ $dr->prenom }}"
                                            data-tokens="{{ $dr->civilite }} {{ $dr->nom }} {{ $dr->prenom }} {{ $dr->adresse }} {{ $dr->email }} {{ $dr->telephone }} {{ $dr->code_postal }} {{ $dr->ville }}">
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row @if ($errors->has('date_visite')) has-error @endif">
                            <label class="col-sm-4 control-label" for="date_visite">Date de la visite <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-3">
                                <input type="date" id="date_visite"
                                    class="form-control {{ $errors->has('date_visite') ? 'is-invalid' : '' }}"
                                    value="{{ old('date_visite') }}" name="date_visite" required>
                            </div>
                        </div>
                        <div class="form-group row @if ($errors->has('heure_visite')) has-error @endif">
                            <label class="col-sm-4 control-label" for="heure_visite">Heure de la visite <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-3">
                                <input type="time" id="heure_visite"
                                    class="form-control {{ $errors->has('heure_visite') ? 'is-invalid' : '' }}"
                                    value="{{ old('heure_visite') }}" name="heure_visite" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" id="vst_check" class="btn btn-primary submitappel">valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

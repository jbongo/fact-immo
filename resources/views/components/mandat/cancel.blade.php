<div class="modal fade" id="cancelation" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Annuler un mandat</strong></h5>
            </div>
            <div class="modal-body">
                <div class="panel lobipanel-basic panel-danger">
                    <div class="panel-heading">
                        <div class="panel-title">Attention</div>
                    </div>
                    <div class="panel-body">
                        Cette action est irreversible, il s'agit ici d'un mandat non conclu par une vente, une fois le
                        mandat annulé vous ne pourrez plus ajouter un autre mandat avec le meme numéro, s'il s'agit
                        d'une erreur de saisie, contactez directement un administrateur pour pouvoir rectifier les
                        informations.
                    </div>
                </div>
                <br>
                <div class="form-validation">
                    <form class="form-appel form-horizontal form-valid-mandat"
                        action="{{ route('mandat.cancel', Crypt::encrypt($mandat->id)) }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="raison_annulation">Raison d'annulation<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-3">
                                <select class="js-select2 form-control" id="raison_annulation" name="raison_annulation"
                                    required>
                                    <option>Le bien a été vendu par le mandant.</option>
                                    <option>Le bien a été vendu par un autre agent.</option>
                                    <option>Le mandant a decidé d'annuler le mandat.</option>
                                    <option>Le mandant ne veut pas prolonger le mandat après son expiration.</option>
                                    <option>Autre.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row @if ($errors->has('note_annulation')) has-error @endif">
                            <label class="col-sm-4 control-label" for="note_annulation">Commentaires<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-3">
                                <textarea rows="4" id="note_annulation"
                                    class="form-control {{ $errors->has('note_annulation') ? 'is-invalid' : '' }}" value="{{ old('note_annulation') }}"
                                    name="note_annulation" placeholder="..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary submitappel">valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

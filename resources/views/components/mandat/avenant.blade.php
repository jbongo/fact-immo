<div class="modal fade" id="avenant_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter un avenant</strong></h5>
          </div>
          <div class="modal-body">
                <div class="panel panel-info m-t-15">
                        <div class="panel-heading">Notice</div>
                        <div class="panel-body">
                                Vous devez créer un avenant de mandat si vous souhaitez modifier le prix de vente publique du bien lié au mandat.    
                        <br><br>
                        </div>
                    </div>
             <div class="form-validation">
                <form class="form-appel form-horizontal form-valid-mandat" action="{{route('mandat.avenant.store', CryptId($mandat->id))}}" method="post">
                 @csrf
                 <div class="form-group row">
                        <label class="col-sm-4 control-label" for="motif">Motif principal de l'avenant'<span class="text-danger">*</span></label>
                        <div class="col-lg-3">
                           <select class="js-select2 form-control" id="motif" name="motif" required>
                              <option value="prix_vente">Modification du prix de vente public.</option>
                              <option value="autre">Autre.</option>
                           </select>
                        </div>
                     </div>

                 <div class="form-group row @if($errors->has('date_modification'))has-error @endif">
                    <label class="col-sm-4 control-label" for="date_modification">Date de modification <span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                       <input type="date" id="date_modification" class="form-control {{$errors->has('date_modification') ? 'is-invalid' : ''}}" value="{{old('date_modification')}}" name="date_modification" required>
                    </div>
                 </div>
                 <div class="form-group row @if($errors->has('numero'))has-error @endif">
                    <label class="col-sm-4 control-label" for="numero">Numéro de l'avenant (optionnel)</label>
                    <div class="col-lg-3">
                       <input type="text" id="numero" class="form-control {{$errors->has('numero') ? 'is-invalid' : ''}}" value="{{old('numero')}}" name="numero" placeholder="Ex: 99258... ">
                    </div>
                 </div>
                 @if($mandat->objet === "mandat-vente")
                 <div class="form-group row @if($errors->has('prix_public'))has-error @endif">
                    <label class="col-sm-4 control-label" for="prix_public">Nouveau prix de vente publique (€)</label>
                    <div class="col-lg-3">
                       <input type="number" min="1" id="prix_public" class="form-control {{$errors->has('prix_public') ? 'is-invalid' : ''}}" value="{{(old('prix_public')) ? old('prix_public') : $mandat->bien->prix_public}}" name="prix_public" required>
                    </div>
                 </div>
                 @endif
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
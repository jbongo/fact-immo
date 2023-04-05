<div class="modal fade" id="mandat_gestion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel"><strong>Gestion</strong></h5>
          </div>
          <div class="modal-body">
                <div class="panel panel-pink m-t-15">
                        <div class="panel-heading">Prolonger un mandat expiré</div>
                        <div class="panel-body">La prolongation ou la reconduction tacite d'un mandat expiré implique l'accord du mandant, assurez vous d'avoir cet accord avant de prolonger le mandat.
                                <br><br>
                                <form class="form-valide form-horizontal" action="{{route('mandat.store')}}" method="POST">
                                   {{ csrf_field() }}
                                   <div class="form-group row">
                                       <label class="col-sm-4 control-label" for="prolog">Durée de la prolongation (mois)<span class="text-danger">*</span></label>
                                       <div class="col-lg-3">
                                          <input type="number" id="prolog" class="form-control" min="1" max="36" value="3" name="prolog" required>
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                               <button class="btn btn-pink btn-rounded btn-addon btn-xs m-b-10" id="ajouter"><i class="ti-plus"></i>Prolonger</button>
                                            </div>
                                         </div>
                                </form>
                            </div>
                    </div>
                    <div class="panel panel-info m-t-15">
                            <div class="panel-heading">Créer un avenant de mandat</div>
                            <div class="panel-body">
                                    Vous ne pouvez .    
                            <br><br>
                            </div>
                        </div>
                        <div class="panel panel-danger m-t-15">
                                <div class="panel-heading">Annuler le mandat</div>
                                <div class="panel-body">
                                        Cette action est irreversible, il s'agit ici d'un mandat non conclu par une vente, une fois le mandat annulé vous ne pourrez plus soumettre un autre mandat avec le meme numéro ni avec un autre numéro pour le meme bien, s'il s'agit d'une erreur de saisie, vous pouvez proceder à l'annulation
                                        et contacter directement un administrateur pour pouvoir créer un autre mandat plus tard.    
                                <br><br>
                                <form>
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                           <label class="col-lg-4 col-form-label" for="raison">@lang('Raison d\'annulation') <span class="text-danger">*</span></label>
                                           <div class="col-lg-4">
                                              <select class="js-select2 form-control" id="raison" name="raison" required>
                                                 <option>Erreur de saisie pendant la création du mandat.</option>
                                                 <option>Le bien a été vendu par le mandant.</option>
                                                 <option>Le bien a été vendu par un autre agent.</option>
                                                 <option>Le mandant a decidé d'annuler le mandat.</option>
                                                 <option>Le mandant ne veut pas prolonger le mandat après son expiration.</option>
                                                 <option>Autre.</option>
                                              </select>
                                           </div>
                                        </div>
                                        <div class="form-group row">
                                             <label class="col-sm-4 control-label" for="describe">Commentaires <span class="text-danger">*</span></label>
                                             <div class="col-lg-4">
                                                <textarea rows="4" id="describe" class="form-control" name="describe" placeholder="Exemple: Suite à un désacord avec le mandant, ce dérnier a décidé d'annuler le mandat..." required></textarea>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                                <div class="col-lg-8 ml-auto">
                                                   <button class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10" id="ajouter"><i class="ti-plus"></i>Annuler</button>
                                                </div>
                                             </div>
                                     </form>
                            </div>
                            </div>
                   <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                   </div>
          </div>
       </div>
    </div>
 </div>
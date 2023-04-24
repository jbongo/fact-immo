<div class="modal fade" id="entite_attache_individu" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Attacher des individus</strong></h5>
              </div>
              <div class="modal-body">
                    <div class="panel lobipanel-basic panel-danger">
                            <div class="panel-heading">
                               <div class="panel-title">Action requise.</div>
                            </div>
                            <div class="panel-body">
                               Assurez-vous d'avoir ajouté les individu de l'entité au préalable et choisissez les dans la liste ci-bas, sinon vous pouvez ajouter directement les individus à l'entité en basculant le bouton dessous sur oui. 
                               <br><br>
                               <div style="text-align: center;">
                               <input type="checkbox" unchecked data-toggle="toggle" id="individu_tps" name="individu_tps" data-off="Non" data-on="Oui" data-onstyle="success btn-rounded btn-sm" data-offstyle="danger btn-rounded btn-sm">
                            </div>
                              </div>
                         </div>
                         <!--form ajax individus-->
                         <div id="ajax_individus">
                            <div class="row">
                               <div class="col-md-7">
                         <div class="form-validation">
                           <form class="form-horizontal" id="form_vfc12" action="{{route('contact.individu.store')}}" method="post">
                            @csrf
                            <div class="form-group row">
                               <label class="col-sm-4 control-label" for="_civilite">Civilité<span class="text-danger">*</span></label>
                               <div class="col-lg-3">
                                  <select class="js-select2 form-control" id="_civilite" name="_civilite" required>
                                     <option value="M.">Monsieur</option>
                                     <option value="Mme.">Madame</option>
                                  </select>
                               </div>
                            </div>
                            <div class="form-group row">
                                 <label class="col-sm-4 control-label" for="_nom">Nom<span class="text-danger">*</span></label>
                                 <div class="col-lg-3">
                                    <input type="text" id="_nom" class="form-control" value="" name="_nom" placeholder="Ex: LEMAIRE..." required>
                                </div>
                              </div>
                              <div class="form-group row">
                               <label class="col-sm-4 control-label" for="_prenom">Prenom<span class="text-danger">*</span></label>
                               <div class="col-lg-3">
                                  <input type="text" id="_prenom" class="form-control" value="" name="_prenom" placeholder="Ex: Julie..." required>
                              </div>
                            </div>
                            <div class="form-group row">
                                   <label class="col-sm-4 control-label" for="_date_naissance">Date de naissance</label>
                                   <div class="col-lg-2">
                                      <input type="date" id="_date_naissance" class="form-control" value="" name="_date_naissance">
                                  </div>
                                </div>
                                <div class="form-group row">
                                 <label class="col-sm-4 control-label" for="_lieu_naissance">Lieu de naissance</label>
                                 <div class="col-lg-3">
                                    <input type="text" id="_lieu_naissance" class="form-control" value="" name="_lieu_naissance" placeholder="Ex: Paris">
                                </div>
                              </div>
                            <div class="form-group row">
                               <label class="col-sm-4 control-label" for="_code_postal">Code postal<span class="text-danger">*</span></label>
                               <div class="col-lg-2">
                                  <input type="text" id="_code_postal" class="form-control" value="" name="_code_postal" placeholder="Ex: 75001..." required>
                              </div>
                            </div>
                            <div class="form-group row">
                               <label class="col-sm-4 control-label" for="_ville">Ville<span class="text-danger">*</span></label>
                               <div class="col-lg-3">
                                  <input type="text" id="_ville" class="form-control" value="" name="_ville" placeholder="Ex: Paris..." required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-sm-4 control-label" for="_adresse">Adresse<span class="text-danger">*</span></label>
                              <div class="col-lg-4">
                                 <input type="text" id="_adresse" class="form-control" value="" name="_adresse" placeholder="Ex: 1 Rue Rivoli..." required>
                             </div>
                           </div>
                              <div class="form-group row">
                                <label class="col-sm-4 control-label" for="_email">Email<span class="text-danger">*</span></label>
                                <div class="col-lg-3">
                                   <input type="email" id="_email" class="form-control" value="" name="_email" placeholder="Ex: contact@gmail.com..." required>
                                </div>
                             </div>
                             <div class="form-group row">
                               <label class="col-sm-4 control-label" for="_telephone">Téléphone<span class="text-danger">*</span></label>
                               <div class="col-lg-2">
                                  <input type="text" id="_telephone" class="form-control" value="" name="_telephone" placeholder="Ex: 0600000000..." required>
                               </div>
                            </div>
                            <div class="form-group row" style="text-align: center;">
                              <button type="submit" id="individus_check" class="btn btn-primary individus_check"><strong>Valider</strong></button>
                           </div>
                           </form>
                        </div>
                     </div>
                     <div class="col-md-4">
                           <h4 style="color:#4eacd2;">Liste des ajouts</h4><br>
                           <ul class="list-group" id="lst_indv">
                             </ul>
                     </div>
                  </div>
                        <!--!!!!!!!!!!-->
                     </div>
                         <!--fin form ajax-->
                         <!--multiselect individus-->
                 <div class="form-validation" id="mvc55">
                    <form class="form-appel form-horizontal" action="{{route('contact.entite.attache', Crypt::encrypt($contact->id))}}" method="post">
                     @csrf
                     <div class="form-group row" id="op1">
                            <label class="col-sm-4 control-label" for="user">Selectionner les individus<span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                               <select class="selectpicker col-lg-8" id="user" name="user[]" data-live-search="true" data-style="btn-pink btn-rounded" multiple required>
                                  {{-- @foreach($query as $dr)
                                  @if($dr->entites->where('id', $contact->id)->count() == 0)
                                    <option  value="{{CryptId($dr->id)}}" data-content="<img class='avatar-img' src='http://127.0.0.1:8000/images/photo_profile/default.png' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{$dr->civilite}}</span> {{$dr->nom}} {{$dr->prenom}}" data-tokens="{{$dr->civilite}} {{$dr->nom}} {{$dr->prenom}} {{$dr->adresse}} {{$dr->email}} {{$dr->telephone}} {{$dr->code_postal}} {{$dr->ville}}"></option>
                                  @endif
                                  @endforeach                                 --}}
                               </select>
                            </div>
                         </div>
                         <div class="form-group row" style="text-align: center;">
                           <button type="submit" class="btn btn-primary"><strong>Valider</strong></button>
                        </div>
                     </form>
                    </div>
                    <!--fin multiselect individus-->
                    <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                  </div>
                 </div>
              </div>
           </div>
     </div>
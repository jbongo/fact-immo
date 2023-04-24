<div class="modal fade" id="entite_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Modifier une entité</strong></h5>
              </div>
              <div class="modal-body">
                 <div class="form-validation">
                    <form class="form-appel form-horizontal" action="{{route('contact.update', Crypt::encrypt($contact->id))}}" method="post">
                     @csrf
                     <div class="form-group row">
                        <label class="col-sm-4 control-label" for="type">Type de l'entité<span class="text-danger">*</span></label>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                           <select class="js-select2 form-control" id="type" name="type" required>
                              @if(old('role'))
                               <option selected value="{{old('type')}}">{{old('type')}}</option>
                              @else
                               <option selected value="{{$contact->entite->type}}">{{$contact->entite->type}}</option>
                              @endif
                              <option value="notaire">Etude de notaire</option>
                              <option value="acquereur">Acquéreur</option>
                              <option value="mandant">Mandant</option>
                              <option value="fournisseur">Fournisseur</option>
                              <option value="Partenaire">Partenaire</option>
                              <option value="autre">Autre</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group row" id="sect3">
                        <label class="col-sm-4 control-label" for="sous_type">Personnalité juridique<span class="text-danger">*</span></label>
                        <div class="col-lg-3">
                           <select class="js-select2 form-control" id="sous_type" name="sous_type" required>
                              @if(old('sous_type'))
                               <option selected value="{{old('sous_type')}}">{{old('sous_type')}}</option>
                              @else
                               <option selected value="{{$contact->entite->sous_type}}">{{$contact->entite->sous_type}}</option>
                              @endif
                              <option value="personne_morale">Personne morale</option>
                              <option value="personne_simple">Personne simple</option>
                              <option value="couple">Couple</option>
                              <option value="groupe">Groupe</option>
                              <option value="autre">Autre</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group row" id="sect1">
                        <label class="col-sm-4 control-label" for="sous_type_fournisseur">Type de fournisseur<span class="text-danger">*</span></label>
                        <div class="col-lg-3">
                           <select class="js-select2 form-control" id="sous_type_fournisseur" name="sous_type_fournisseur" required>
                              @if(old('sous_type_fournisseur'))
                               <option selected value="{{old('sous_type_fournisseur')}}">{{old('sous_type_fournisseur')}}</option>
                              @endif
                              <option value="passerelle">Passerelle de diffusion</option>
                              <option value="autre">Autre</option>
                           </select>
                        </div>
                     </div>
                     
                       <div class="form-group row @if($errors->has('raison_sociale'))has-error @endif">
                        <label class="col-sm-4 control-label" for="raison_sociale">Nom ou raison sociale<span class="text-danger">*</span></label>
                        <div class="col-lg-3">
                           <input type="text" id="raison_sociale" class="form-control" value="{{(old('raison_sociale')) ? old('raison_sociale') : $contact->entite->raison_sociale}}" name="raison_sociale" placeholder="Ex: SARL V4F..." required>
                           @if ($errors->has('raison_sociale'))
                           <br>
                           <div class="alert alert-warning ">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>{{$errors->first('raison_sociale')}}</strong> 
                           </div>
                           @endif
                       </div>
                     </div>
                     <div class="form-group row @if($errors->has('email'))has-error @endif">
                            <label class="col-sm-4 control-label" for="email">Email<span class="text-danger">*</span></label>
                            <div class="col-lg-3">
                               <input type="email" id="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" value="{{(old('email')) ? old('email') : $contact->entite->email}}" name="email" placeholder="Ex: contact@gmail.com..." required>
                               @if ($errors->has('email'))
                               <br>
                               <div class="alert alert-warning ">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>{{$errors->first('email')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         <div class="form-group row @if($errors->has('telephone'))has-error @endif">
                           <label class="col-sm-4 control-label" for="telephone">Téléphone<span class="text-danger">*</span></label>
                           <div class="col-lg-2">
                              <input type="text" id="telephone" class="form-control {{$errors->has('telephone') ? 'is-invalid' : ''}}" value="{{(old('telephone')) ? old('telephone') : $contact->entite->telephone}}" name="telephone" placeholder="Ex: 0600000000..." required>
                              @if ($errors->has('telephone'))
                              <br>
                              <div class="alert alert-warning ">
                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 <strong>{{$errors->first('telephone')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                        <div id="sect2">
                                <div class="form-group row @if($errors->has('forme_juridique'))has-error @endif">
                                        <label class="col-sm-4 control-label" for="forme_juridique">Forme juridique</label>
                                        <div class="col-lg-3">
                                           <input type="text" id="forme_juridique" class="form-control" value="{{(old('forme_juridique')) ? old('forme_juridique') : $contact->entite->forme_juridique}}" name="forme_juridique" placeholder="Ex: SARL, SAS...">
                                           @if ($errors->has('forme_juridique'))
                                           <br>
                                           <div class="alert alert-warning ">
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                              <strong>{{$errors->first('forme_juridique')}}</strong> 
                                           </div>
                                           @endif
                                       </div>
                                     </div>
                     
                     <div class="form-group row @if($errors->has('code_postal'))has-error @endif">
                        <label class="col-sm-4 control-label" for="code_postal">Code postal</label>
                        <div class="col-lg-2">
                           <input type="text" id="code_postal" class="form-control" value="{{(old('code_postal')) ? old('code_postal') : $contact->entite->code_postal}}" name="code_postal" placeholder="Ex: 75001...">
                           @if ($errors->has('code_postal'))
                           <br>
                           <div class="alert alert-warning ">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>{{$errors->first('code_postal')}}</strong> 
                           </div>
                           @endif
                       </div>
                     </div>
                     <div class="form-group row @if($errors->has('ville'))has-error @endif">
                        <label class="col-sm-4 control-label" for="ville">Ville</label>
                        <div class="col-lg-3">
                           <input type="text" id="ville" class="form-control" value="{{(old('ville')) ? old('ville') : $contact->entite->ville}}" name="ville" placeholder="Ex: Paris..." >
                           @if ($errors->has('ville'))
                           <br>
                           <div class="alert alert-warning ">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>{{$errors->first('ville')}}</strong> 
                           </div>
                           @endif
                       </div>
                     </div>
    
                     <div class="form-group row @if($errors->has('adresse'))has-error @endif">
                            <label class="col-sm-4 control-label" for="adresse">Adresse</label>
                            <div class="col-lg-4">
                               <input type="text" id="adresse" class="form-control" value="{{(old('adresse')) ? old('adresse') : $contact->entite->adresse}}" name="adresse" placeholder="Ex: 1 Rue Rivoli...">
                               @if ($errors->has('adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>{{$errors->first('adresse')}}</strong> 
                               </div>
                               @endif
                           </div>
                         </div>
                       
                     <div class="form-group row @if($errors->has('numero_siret'))has-error @endif">
                        <label class="col-sm-4 control-label" for="numero_siret">Numéro siret</label>
                        <div class="col-lg-2">
                           <input type="text" id="numero_siret" class="form-control {{$errors->has('numero_siret') ? 'is-invalid' : ''}}" value="{{(old('numero_siret')) ? old('numero_siret') : $contact->entite->numero_siret}}" name="numero_siret" placeholder="Ex: 729654789...">
                           @if ($errors->has('telephone'))
                           <br>
                           <div class="alert alert-warning ">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>{{$errors->first('telephone')}}</strong> 
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row @if($errors->has('numero_tva'))has-error @endif">
                        <label class="col-sm-4 control-label" for="numero_tva">Numéro TVA</label>
                        <div class="col-lg-2">
                           <input type="text" id="numero_tva" class="form-control {{$errors->has('numero_tva') ? 'is-invalid' : ''}}" value="{{(old('numero_tva')) ? old('numero_tva') : $contact->entite->numero_tva}}" name="numero_tva" placeholder="Ex: FR98456487...">
                           @if ($errors->has('numero_tva'))
                           <br>
                           <div class="alert alert-warning ">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>{{$errors->first('numero_tva')}}</strong> 
                           </div>
                           @endif
                        </div>
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
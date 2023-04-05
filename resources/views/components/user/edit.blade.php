<div class="modal fade" id="user_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel"><strong>Modifier une fiche utilisateur</strong></h5>
          </div>
          <div class="modal-body">
             <div class="panel lobipanel-basic panel-info">
                <div class="panel-heading">
                   <div class="panel-title">Informations</div>
                </div>
                <div class="panel-body">
                   Saisisez correctement les informations liées à l'utilisateur, tous les champs sont obligatoires. 
                </div>
             </div>
             <div class="form-validation">
                <form class="form-appel form-horizontal" action="{{route('user.update', CryptId($user->id))}}" method="post">
                 @csrf
                 <div class="form-group row">
                    <label class="col-sm-4 control-label" for="civilite">Civilité<span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                       <select class="js-select2 form-control" id="civilite" name="civilite" required>
                          @if(old('civilite'))
                           <option selected value="{{old('civilite')}}">{{old('civilite')}}</option>
                          @endif
                          <option value="M">Monsieur</option>
                          <option value="Mme">Madame</option>
                       </select>
                    </div>
                 </div>
                 <div class="form-group row @if($errors->has('nom'))has-error @endif">
                      <label class="col-sm-4 control-label" for="nom">Nom<span class="text-danger">*</span></label>
                      <div class="col-lg-3">
                         <input type="text" id="nom" class="form-control" value="{{$info->nom}}" name="nom" placeholder="Ex: LEMAIRE..." required>
                         @if ($errors->has('nom'))
                         <br>
                         <div class="alert alert-warning ">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>{{$errors->first('nom')}}</strong> 
                         </div>
                         @endif
                     </div>
                   </div>
                   <div class="form-group row @if($errors->has('prenom'))has-error @endif">
                    <label class="col-sm-4 control-label" for="prenom">Prenom<span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                       <input type="text" id="prenom" class="form-control" value="{{$info->prenom}}" name="prenom" placeholder="Ex: Julie..." required>
                       @if ($errors->has('prenom'))
                       <br>
                       <div class="alert alert-warning ">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>{{$errors->first('prenom')}}</strong> 
                       </div>
                       @endif
                   </div>
                 </div>
                 <div class="form-group row @if($errors->has('code_postal'))has-error @endif">
                    <label class="col-sm-4 control-label" for="code_postal">Code postal<span class="text-danger">*</span></label>
                    <div class="col-lg-2">
                       <input type="text" id="code_postal" class="form-control" value="{{$info->code_postal}}" name="code_postal" placeholder="Ex: 75001..." required>
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
                    <label class="col-sm-4 control-label" for="ville">Ville<span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                       <input type="text" id="ville" class="form-control" value="{{$info->ville}}" name="ville" placeholder="Ex: Paris..." required>
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
                     <label class="col-sm-4 control-label" for="adresse">Adresse<span class="text-danger">*</span></label>
                     <div class="col-lg-4">
                        <input type="text" id="adresse" class="form-control" value="{{$info->adresse}}" name="adresse" placeholder="Ex: 1 Rue Rivoli..." required>
                        @if ($errors->has('adresse'))
                        <br>
                        <div class="alert alert-warning ">
                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <strong>{{$errors->first('adresse')}}</strong> 
                        </div>
                        @endif
                    </div>
                  </div>
                   <div class="form-group row @if($errors->has('email'))has-error @endif">
                     <label class="col-sm-4 control-label" for="email">Email<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="email" id="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" value="{{$info->email}}" name="email" placeholder="Ex: contact@gmail.com..." required>
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
                       <input type="text" id="telephone" class="form-control {{$errors->has('telephone') ? 'is-invalid' : ''}}" value="{{$info->telephone}}" name="telephone" placeholder="Ex: 0600000000..." required>
                       @if ($errors->has('telephone'))
                       <br>
                       <div class="alert alert-warning ">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>{{$errors->first('telephone')}}</strong> 
                       </div>
                       @endif
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
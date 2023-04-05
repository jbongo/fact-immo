<div class="modal fade" id="offre_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter une offre</strong></h5>
         </div>
         <div class="modal-body">
            <div class="panel lobipanel-basic panel-warning">
               <div class="panel-heading">
                  <div class="panel-title">INSTRUCTIONS</div>
               </div>
               <div class="panel-body">
                  L'offre est imprimée en PDF et envoyée automatiquement au au mandant par email,
                  si elle est acceptée par le mandant l'étape pour signer le compromis sera déclenchée immédiatement. 
               </div>
            </div>
            <div class="form-validation">
               <form class="form-appel form-horizontal form-visit" action="{{route('suiviaffaire.offre.add', CryptId($affaire->id))}}" method="post">
                  @csrf
                  <div class="form-group row">
                     <label class="col-sm-4 control-label" for="entite_id">Associer l'acquéreur potentiel (Entité)<span class="text-danger">*</span></label>
                     <div class="col-lg-4">
                        <select class="selectpicker col-lg-8" id="entite_id" name="entite_id" data-live-search="true" data-style="btn-danger btn-rounded" required>
                           <option></option>
                           @foreach(Auth::user()->entites as $dr)
                           <option  value="{{CryptId($dr->id)}}" data-content="<img class='avatar-img' src='{{asset('/images/common/'."justice.png")}}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{$dr->type}}</span> {{$dr->raison_sociale}}" data-tokens="{{$dr->type}} {{$dr->raison_sociale}} {{$dr->forme_juridique}} {{$dr->adresse}} {{$dr->email}} {{$dr->telephone}} {{$dr->code_postal}} {{$dr->ville}}"></option>
                           @endforeach                                
                        </select>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('montant'))has-error @endif">
                     <label class="col-sm-4 control-label" for="montant">Montant de l'offre TTC (€)<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="number" min="1" step="1" id="montant" class="form-control {{$errors->has('montant') ? 'is-invalid' : ''}}" value="{{old('montant')}}" name="montant" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('frais_agence'))has-error @endif">
                     <label class="col-sm-4 control-label" for="frais_agence">Frais d'agence (€)<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="number" min="1" step="1" id="frais_agence" class="form-control {{$errors->has('frais_agence') ? 'is-invalid' : ''}}" value="{{old('frais_agence')}}" name="frais_agence" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('date_debut'))has-error @endif">
                     <label class="col-sm-4 control-label" for="date_debut">Date effective de l'offre <span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="date" id="date_debut" class="form-control {{$errors->has('date_debut') ? 'is-invalid' : ''}}" value="{{old('date_debut')}}" name="date_debut" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('date_expiration'))has-error @endif">
                     <label class="col-sm-4 control-label" for="date_expiration">Date de fin de l'offre<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="date" id="date_expiration" class="form-control {{$errors->has('date_expiration') ? 'is-invalid' : ''}}" value="{{old('date_expiration')}}" name="date_expiration" required>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-4 control-label" for="conditions_suspensives">Résumé des conditions suspensives (à ajouter au compromis plus tard)</label>
                     <div class="col-lg-4">
                        <textarea rows="6" id="conditions_suspensives" class="form-control {{$errors->has('conditions_suspensives') ? 'is-invalid' : ''}}" value="{{old('conditions_suspensives')}}" name="conditions_suspensives" placeholder="Ex: Acceptation d'un pret bancaire..."></textarea>
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

<!--Duplicate offre-->
<div class="modal fade" id="offre_counter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter une contre offre</strong></h5>
         </div>
         <div class="modal-body">
            <div class="panel lobipanel-basic panel-info">
               <div class="panel-heading">
                  <div class="panel-title">INSTRUCTIONS</div>
               </div>
               <div class="panel-body">
                  La contre offre permet de faire une nouvelle offre à partir d'une offre rejetée en changeant seulement le montant et les frais d'agence. 
               </div>
            </div>
            <div class="form-validation">
               <form class="form-horizontal form_contre_offre" action="#" method="post">
                  @csrf
                  <div class="form-group row @if($errors->has('montant'))has-error @endif">
                     <label class="col-sm-4 control-label" for="montant">Montant de l'offre TTC (€)<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="number" min="1" step="1" id="montant_counter" class="form-control {{$errors->has('montant') ? 'is-invalid' : ''}}" value="{{old('montant')}}" name="montant" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('frais_agence'))has-error @endif">
                     <label class="col-sm-4 control-label" for="frais_agence">Frais d'agence (€)<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="number" min="1" step="1" id="frais_agence_counter" class="form-control {{$errors->has('frais_agence') ? 'is-invalid' : ''}}" value="{{old('frais_agence')}}" name="frais_agence" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('date_debut'))has-error @endif">
                     <label class="col-sm-4 control-label" for="date_debut">Date effective de l'offre <span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="date" id="date_debut_counter" class="form-control {{$errors->has('date_debut') ? 'is-invalid' : ''}}" value="{{old('date_debut')}}" name="date_debut" required>
                     </div>
                  </div>
                  <div class="form-group row @if($errors->has('date_expiration'))has-error @endif">
                     <label class="col-sm-4 control-label" for="date_expiration">Date de fin de l'offre<span class="text-danger">*</span></label>
                     <div class="col-lg-3">
                        <input type="date" id="date_expiration_counter" class="form-control {{$errors->has('date_expiration') ? 'is-invalid' : ''}}" value="{{old('date_expiration')}}" name="date_expiration" required>
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
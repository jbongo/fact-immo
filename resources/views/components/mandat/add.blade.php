<div class="modal fade" id="mandat_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter un mandat</strong></h5>
              </div>
              <div class="modal-body">
                 <div class="form-validation">
                    <form class="form-appel form-horizontal form-valid-mandat" action="{{route('mandat.store')}}" method="post">
                     @csrf
                     <div class="form-group row">
                            <label class="col-sm-4 control-label" for="objet">Objet du mandat<span class="text-danger">*</span></label>
                            <div class="col-lg-3">
                               <select class="js-select2 form-control" id="objet" name="objet" required>
                                  @if(old('objet'))
                                  <option selected value="{{old('objet')}}">{{old('objet')}}</option>
                                  @endif
                                  <option value="mandat-vente">Mandat de vente</option>
                                  <option value="mandat-recherche">Mandat de recherche</option>
                               </select>
                            </div>
                         </div>
                         <div class="form-group row">
                                <label class="col-sm-4 control-label" for="type">Type du mandat<span class="text-danger">*</span></label>
                                <div class="col-lg-3">
                                   <select class="js-select2 form-control" id="type" name="type" required>
                                      @if(old('type'))
                                      <option selected value="{{old('type')}}">{{old('type')}}</option>
                                      @endif
                                      <option value="simple">Simple</option>
                                      <option value="exclusif">Exclusif</option>
                                      <option id="ty45g" value="semi-exclusif">Semi exclusif</option>
                                   </select>
                                </div>
                             </div>
                             @php $offset = NULL @endphp
                             <div class="form-group row" id="op1">
                                    <label class="col-sm-4 control-label" for="bien_id">Associer le bien<span class="text-danger">*</span></label>
                                    <div class="col-lg-4">
                                       <select class="selectpicker col-lg-8" id="bien_id" name="bien_id" data-live-search="true" data-style="btn-info btn-rounded" required>
                                             <option></option>
                                          @foreach($biens as $bien)
                                          @foreach($bien->photosbiens as $photos) @if($photos->visibilite == "visible" && $photos->image_position == 1) @php $src=asset("images/photos_bien/".$photos->filename)@endphp @php $offset = 1 @endphp @break @endif @endforeach @if($offset == NULL)@php $src=asset('/images/common/'."home.jpg")@endphp @else @php $offset = NULL @endphp @endif
                                          <option value="{{CryptId($bien->id)}}" data-content="<img class='square-img' src='{{$src}}' alt=''> <strong>__{{$bien->titre_annonce}}</strong>" data-tokens="{{$bien->titre_annonce}}"></option>
                                          @endforeach                                
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group row" id="fcf55">
                                        <label class="col-sm-4 control-label" for="entite_id">Associer l'entité<span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                           <select class="selectpicker col-lg-8" id="entite_id" name="entite_id" data-live-search="true" data-style="btn-warning btn-rounded" required>
                                                 <option></option>
                                                 @foreach($entite as $dr)
                                                   <option  value="{{CryptId($dr->id)}}" data-content="<img class='avatar-img' src='{{asset('/images/common/'."justice.png")}}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{$dr->type}}</span> {{$dr->raison_sociale}}" data-tokens="{{$dr->type}} {{$dr->raison_sociale}} {{$dr->forme_juridique}} {{$dr->adresse}} {{$dr->email}} {{$dr->telephone}} {{$dr->code_postal}} {{$dr->ville}}"></option>
                                                 @endforeach                                
                                           </select>
                                        </div>
                                     </div>
                                 <div class="form-group row @if($errors->has('numero'))has-error @endif">
                                        <label class="col-sm-4 control-label" for="numero">Numéro du mandat<span class="text-danger">*</span></label>
                                        <div class="col-lg-3">
                                           <input type="text" id="numero" class="form-control {{$errors->has('numero') ? 'is-invalid' : ''}}" value="{{old('numero')}}" name="numero" placeholder="Ex: 99258... " required>
                                        </div>
                                     </div>
                                     <div class="form-group row @if($errors->has('date_debut'))has-error @endif">
                                            <label class="col-sm-4 control-label" for="date_debut">Date du début <span class="text-danger">*</span></label>
                                            <div class="col-lg-3">
                                               <input type="date" id="date_debut" class="form-control {{$errors->has('date_debut') ? 'is-invalid' : ''}}" value="{{old('date_debut')}}" name="date_debut" required>
                                            </div>
                                         </div>
                                         <div class="form-group row @if($errors->has('date_fin'))has-error @endif">
                                            <label class="col-sm-4 control-label" for="date_fin">Date de fin <span class="text-danger">*</span></label>
                                            <div class="col-lg-3">
                                               <input type="date" id="date_fin" class="form-control {{$errors->has('date_fin') ? 'is-invalid' : ''}}" value="{{old('date_fin')}}" name="date_fin" required>
                                            </div>
                                         </div>
                                         <div class="form-group row @if($errors->has('describe'))has-error @endif">
                                            <label class="col-sm-4 control-label" for="describe">Notes</label>
                                            <div class="col-lg-3">
                                               <textarea rows="4" id="describe" class="form-control {{$errors->has('describe') ? 'is-invalid' : ''}}" value="{{old('describe')}}" name="describe" placeholder="..."></textarea>
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
<div class="modal fade" id="notaire_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Attacher des notaires</strong></h5>
              </div>
              <div class="modal-body">
                 <div class="form-validation">
                    <form class="form-horizontal form-notaire-attach" action="{{route('suiviaffaire.notaire.store', CryptId($affaire->id))}}" method="post">
                     @csrf
                                 <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="notaire_compromis_attach">Associer le notaire pour le compromis<span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                           <select class="selectpicker col-lg-8" id="notaire_compromis_attach" name="notaire_compromis_attach" data-live-search="true" data-style="btn-info btn-rounded" required>
                                                 <option></option>
                                                 @foreach(Auth::user()->entites as $dr)
                                                    @if($dr->type === "notaire")
                                                   <option  value="{{CryptId($dr->id)}}" data-content="<img class='avatar-img' src='{{asset('/images/common/'."justice.png")}}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{$dr->type}}</span> {{$dr->raison_sociale}}" data-tokens="{{$dr->type}} {{$dr->raison_sociale}} {{$dr->forme_juridique}} {{$dr->adresse}} {{$dr->email}} {{$dr->telephone}} {{$dr->code_postal}} {{$dr->ville}}"></option>
                                                 @endif
                                                   @endforeach                                
                                           </select>
                                        </div>
                                     </div>
                                     <div class="form-group row">
                                            <label class="col-sm-4 control-label" for="notaire_acte_attach">Associer le notaire pour l'acte<span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                               <select class="selectpicker col-lg-8" id="notaire_acte_attach" name="notaire_acte_attach" data-live-search="true" data-style="btn-warning btn-rounded" required>
                                                     <option></option>
                                                     @foreach(Auth::user()->entites as $dr)
                                                        @if($dr->type === "notaire")
                                                       <option  value="{{CryptId($dr->id)}}" data-content="<img class='avatar-img' src='{{asset('/images/common/'."justice.png")}}' alt=''><span class='user-avatar'></span><span class='badge badge-pink'>{{$dr->type}}</span> {{$dr->raison_sociale}}" data-tokens="{{$dr->type}} {{$dr->raison_sociale}} {{$dr->forme_juridique}} {{$dr->adresse}} {{$dr->email}} {{$dr->telephone}} {{$dr->code_postal}} {{$dr->ville}}"></option>
                                                     @endif
                                                       @endforeach                                
                                               </select>
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
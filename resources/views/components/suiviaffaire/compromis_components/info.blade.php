@php
    $rdv = unserialize($affaire->rendez_vous_compromis);
    $notaire = \App\Models\Entite::where('id', $rdv['notaire_id'])->firstOrFail();
@endphp
<!--info rdv compromis-->
<div class="panel panel-danger lobipanel-basic">
   <div class="panel-heading"><strong>Détails du rendez-vous compromis</strong></div>
   <div class="panel-body">
      <div class="user-profile">
         <div class="row">
            <div class="col-lg-5">
               <div class="user-work">
                  <h4 style="color: #32ade1;text-decoration: underline;">Signataires</h4>
                  <div class="table-responsive">
                     <table class="table table-hover table-striped">
                        <thead>
                           <tr>
                              <th>Civilité</th>
                              <th>Nom et prénom</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($affaire->mandat->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                              <td><span><a href="{{route('contact.individu.show', CryptId($one->id))}}" data-toggle="tooltip" title="Voir le signatairer"><i class="large material-icons color-info">visibility</i></a> </span></td>
                           </tr>
                           @endforeach
                           @if($compromis_actif != NULL)
                           @foreach($compromis_actif->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                              <td><span><a href="{{route('contact.individu.show', CryptId($one->id))}}" data-toggle="tooltip" title="Voir le signatairer"><i class="large material-icons color-info">visibility</i></a> </span></td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="user-skill">
                  <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                  <a type="button" class="btn btn-info btn-rounded btn-addon btn-xs m-b-10 edit_compromis_rdv"><i class="ti-settings"></i>Editer</a>
                  <a type="button" href="{{route('suiviaffaire.rdv.action', [Cryptid($affaire->id), CryptId("rendez_vous_compromis"), CryptId("reject")])}}" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10 cancel_compromis"><i class="ti-close"></i>Annuler</a>
                  <a type="button" href="{{route('suiviaffaire.rdv.action', [Cryptid($affaire->id), CryptId("rendez_vous_compromis"), CryptId("confirm")])}}" class="btn btn-success btn-rounded btn-addon btn-xs m-b-10 confirm_compromis"><i class="ti-save"></i>Valider</a>
               </div>
            </div>
            <div class="col-lg-7">
               <div class="custom-tab user-profile-tab">
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                  </ul>

                  

                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="1">
                            <div class="form-validation" id="form_edit_compromis">
                                    <form class="form-appel form-horizontal form-update-compromis" action="{{route('suiviaffaire.offre.add', CryptId($affaire->id))}}" method="post">
                                     @csrf
                                     <div class="form-group row">
                                            <label class="col-sm-4 control-label" for="edit_adresse_cmp">Adresse du rendez-vous<span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                               <input type="text" id="edit_adresse_cmp" class="form-control" value="{{$rdv['adresse']}}" name="edit_adresse_cmp" placeholder="Ex: 25 Rue CARNOT..." required>
                                            </div>
                                         </div>
                                         <div class="form-group row">
                                              <label class="col-sm-4 control-label" for="edit_cmpl_adresse_cmp">Complément d'adresse</label>
                                              <div class="col-lg-4">
                                                 <input type="text" id="edit_cmpl_adresse_cmp" class="form-control" value="{{$rdv['complement_adresse']}}" name="edit_cmpl_adresse_cmp" placeholder="Ex: 25 Rue CARNOT...">
                                              </div>
                                           </div>
                                         <div class="form-group row">
                                          <label class="col-sm-4 control-label" for="edit_code_postal_cmp">Code postal<span class="text-danger">*</span></label>
                                          <div class="col-lg-4">
                                             <input type="text" id="edit_code_postal_cmp" class="form-control" value="{{$rdv['code_postal']}}" name="edit_code_postal_cmp" placeholder="Ex: 75008" required>
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label class="col-sm-4 control-label" for="edit_ville_cmp">Ville<span class="text-danger">*</span></label>
                                          <div class="col-lg-4">
                                             <input type="text" id="edit_ville_cmp" class="form-control" value="{{$rdv['ville']}}" name="edit_ville_cmp" placeholder="Ex: Paris..." required>
                                          </div>
                                       </div>
                                         <div class="form-group row">
                                            <label class="col-sm-4 control-label" for="edit_date_compromis">Date du rendez vous<span class="text-danger">*</span></label>
                                            <div class="col-lg-4">
                                               <input type="date" id="edit_date_compromis" class="form-control" value="{{date('Y-m-d',strtotime($rdv['date']))}}" min="" name="date_compromis" required>
                                            </div>
                                         </div>
                                         <div class="form-group row">
                                          <label class="col-sm-4 control-label" for="edit_heure_compromis">Heure du rendez vous<span class="text-danger">*</span></label>
                                          <div class="col-lg-4">
                                             <input type="time" id="edit_heure_compromis" class="form-control" value="{{$rdv['heure']}}" name="edit_heure_compromis" required>
                                          </div>
                                        </div>
                                        <div class="form-group row" style="text-align: center;">
                                                <button type="submit" id="edit_compromis_check" class="btn btn-warning update_compromis"><strong>Valider</strong></button>
                                             </div>
                                    </form>
                                </div>
                        <div class="contact-information" id="global_infos_compromis">      
                           <div class="address-content">
                              <span class="contact-title"><strong style="color:#e8853e;">Date de signature:</strong></span>
                              <strong>{{date('d-m-Y',strtotime($rdv['date']))}}</strong>
                           </div>
                           <div class="website-content">
                              <span class="contact-title"><strong style="color:#e8853e;">Heure:</strong></span>
                              <span class="birth-date"><span class="badge badge-info"><strong>{{$rdv['heure']}}</strong></span></span>
                           </div>
                           <div class="email-content">
                              <span class="contact-title"><strong style="color:#e8853e;">Statut:</strong></span>
                              @if($rdv['statut'] === "En préparation")
                              <span class="badge badge-warning"><strong>{{strtoupper($rdv['statut'])}}</strong></span>
                              @elseif($rdv['statut'] === "Confirmation")
                              <span class="badge badge-danger"><strong>{{strtoupper($rdv['statut'])}}</strong></span>
                              @else
                              <span class="badge badge-success"><strong>{{strtoupper($rdv['statut'])}}</strong></span>
                              @endif
                           </div>
                           <div class="address-content">
                              <span class="contact-title"><strong style="color:#e8853e;">Adresse:</strong></span>
                              <span class="mail-address">{{$rdv['adresse'].', '.$rdv['complement_adresse']}}</span>
                           </div>
                           <div class="website-content">
                              <span class="contact-title"><strong style="color:#e8853e;">Code postal:</strong></span>
                              <span class="contact-website">{{$rdv['code_postal']}}</span>
                           </div>
                           <div class="website-content">
                              <span class="contact-title"><strong style="color:#e8853e;">ville:</strong></span>
                              <span class="contact-website">{{$rdv['ville']}}</span>
                           </div>
                           <div class="website-content">
                              <div class="col-lg-7">
                                 <div class="card" style="border: 5px solid #b7cae2; border-radius: 10px;">
                                    <div class="stat-widget-one">
                                       <div class="stat-icon dib"><i class="material-icons color-success border-success"> account_balance </i></div>
                                       <div class="stat-content dib">
                                          <div class="stat-text"><strong>{{$notaire->raison_sociale}}</strong></div>
                                          <div class="stat-digit">
                                             <td><span><a href="{{route('contact.entite.show', CryptId($rdv['notaire_id']))}}" data-toggle="tooltip" title="Voir le signatairer"><i class="large material-icons color-info">visibility</i></a> </span></td>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--fin info-->
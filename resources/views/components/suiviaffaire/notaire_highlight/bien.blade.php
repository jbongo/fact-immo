<div class="row">
        <div class="panel lobipanel-basic panel-success">
           <div class="panel-heading">
              <div class="panel-title"><strong>Détails du bien et du mandat</strong></div>
           </div>
           <div class="panel-body">
              <div class="col-lg-6">
                 <div class="custom-tab user-profile-tab">
                    <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Bien</a></li>
                    </ul>
                    <div class="tab-content">
                       <div role="tabpanel" class="tab-pane active" id="1">
                          <div class="contact-information">
                             <div class="phone-content">
                                <span class="contact-title"><strong>Type:</strong></span>
                                <span class="phone-number"><span class="badge badge-dark">{{$bien->type_bien}}</span></span>
                             </div>
                             <div class="address-content">
                                <span class="contact-title"><strong>Nombre de pieces:</strong></span>
                                <span class="mail-address">{{$bien->nombre_piece}}</span>
                             </div>
                             <div class="email-content">
                                <span class="contact-title"><strong>Surface habitable:</strong></span>
                                <span class="contact-email">{{$bien->surface_habitable}} m²</span>
                             </div>
                             <div class="website-content">
                                <span class="contact-title"><strong>Surface terrain:</strong></span>
                                <span class="contact-website">{{$bien->surface_terrain}} m²</span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>Adresse:</strong></span>
                                <span class="contact-skype">{{$bien->biensecteur->adresse_bien.' '.$bien->code_postal.' '.$bien->ville}}</span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>DPE:</strong></span>
                                <span class="contact-skype"><span class="badge badge-warning">{{$bien->biendetail->diagnostic_dpe_consommation}}</span></span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>GES:</strong></span>
                                <span class="contact-skype"><span class="badge badge-pink">{{$bien->biendetail->diagnostic_dpe_ges}}</span></span>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-lg-6">
                 <div class="custom-tab user-profile-tab">
                    <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Mandat</a></li>
                    </ul>
                    <div class="tab-content">
                       <div role="tabpanel" class="tab-pane active" id="1">
                          <div class="contact-information">
                             <div class="phone-content">
                                <span class="contact-title"><strong>Numéro du mandat:</strong></span>
                                <span class="phone-number">{{$affaire->mandat->numero}}</span>
                             </div>
                             <div class="address-content">
                                <span class="contact-title"><strong>Date de signature:</strong></span>
                                <span class="mail-address">{{date('d-m-Y',strtotime($affaire->mandat->date_debut))}}</span>
                             </div>
                             <div class="email-content">
                                <span class="contact-title"><strong>Type de mandat:</strong></span>
                                <span class="contact-email"><span class="badge badge-info">{{$affaire->mandat->type}}</span></span>
                             </div>
                             <div class="website-content">
                                <span class="contact-title"><strong>Prix de vente public:</strong></span>
                                <span class="contact-website">{{$bien->bienprix->prix_public}}</span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>Montant de l'offre:</strong></span>
                                <span class="contact-skype">{{$compromis->montant}} €</span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>Honnoraires:</strong></span>
                                <span class="contact-skype">{{$compromis->frais_agence}} €</span>
                             </div>
                             <div class="skype-content">
                                <span class="contact-title"><strong>A charge de:</strong></span>
                                <span class="contact-skype"><span class="badge badge-info">{{$compromis->charge}}</span></span>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <div class="row">
        <div class="col-lg-6">
           <div class="panel lobipanel-basic panel-info">
              <div class="panel-heading">
                 <div class="panel-title"><strong>Détails du vendeur</strong></div>
              </div>
              <div class="panel-body">
                 <div class="user-profile">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="user-job-title"><span class="badge badge-danger">{{$mandant->sous_type}}</span></div>
                          @if($mandant->sous_type === "personne_morale")
                          <div class="custom-tab user-profile-tab">
                             <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Informations entité</a></li>
                             </ul>   
                             <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="1">
                                   <div class="contact-information">
                                      <div class="website-content">
                                         <span class="contact-title"><strong>Forme juridique:</strong></span>
                                         <span class="contact-website"><span class="badge badge-info">{{$mandant->forme_juridique}}</span></span>
                                      </div>
                                      <div class="phone-content">
                                         <span class="contact-title"><strong>Raison sociale:</strong></span>
                                         <span class="phone-number">{{$mandant->raison_sociale}}</span>
                                      </div>
                                      <div class="email-content">
                                         <span class="contact-title"><strong>Email:</strong></span>
                                         <span class="contact-email">{{$mandant->email}}</span>
                                      </div>
                                      <div class="address-content">
                                         <span class="contact-title"><strong>Address:</strong></span>
                                         <span class="mail-address">{{$mandant->adresse.' '.$mandant->code_postal.' '.$mandant->ville}}</span>
                                      </div>
                                      <div class="skype-content">
                                         <span class="contact-title"><strong>Téléphone:</strong></span>
                                         <span class="contact-skype">{{$mandant->telephone}}</span>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          @endif
                       </div>
                    </div>
                 </div>
                 <!--table-->
                 <div class="user-profile">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="custom-tab user-profile-tab">
                             <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tb1" aria-controls="1" role="tab" data-toggle="tab">Liste des personnes</a></li>
                             </ul>
                             <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tb1">
                                   <div class="table-responsive">
                                      <table class="table table-hover table-striped">
                                         <thead>
                                            <tr>
                                               <th>Nom et prenom</th>
                                               <th>Email et téléphone</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                            @foreach($mandant->individus as $one)
                                            <tr>
                                                <th scope="row"><span class="badge badge-pink">{{$one->civilite}}</span> <strong>{{$one->nom.' '.$one->prenom}}</strong></th>
                                                <td><strong class="color-info">{{$one->email}}</strong><br>
                                                   <strong>{{$one->telephone}}</strong>
                                                </td>
                                             </tr>
                                            @endforeach
                                         </tbody>
                                      </table>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!--table fin-->
              </div>
           </div>
        </div>
        <div class="col-lg-6">
           <div class="panel lobipanel-basic panel-pink">
              <div class="panel-heading">
                 <div class="panel-title"><strong>Détails de l'acquéreur</strong></div>
              </div>
              <div class="panel-body">
                 <div class="user-profile">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="user-job-title"><span class="badge badge-danger">{{$acquereur->sous_type}}</span></div>
                          @if($mandant->sous_type === "personne_morale")
                          <div class="custom-tab user-profile-tab">
                             <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tet1" aria-controls="1" role="tab" data-toggle="tab">Informations entité</a></li>
                             </ul>
                             <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tet1">
                                   <div class="contact-information">
                                      <div class="website-content">
                                         <span class="contact-title"><strong>Forme juridique:</strong></span>
                                         <span class="contact-website"><span class="badge badge-info">{{$acquereur->forme_juridique}}</span></span>
                                      </div>
                                      <div class="phone-content">
                                         <span class="contact-title"><strong>Raison sociale:</strong></span>
                                         <span class="phone-number">{{$acquereur->raison_sociale}}</span>
                                      </div>
                                      <div class="email-content">
                                         <span class="contact-title"><strong>Email:</strong></span>
                                         <span class="contact-email">{{$acquereur->email}}</span>
                                      </div>
                                      <div class="address-content">
                                         <span class="contact-title"><strong>Address:</strong></span>
                                         <span class="mail-address">{{$acquereur->adresse.' '.$acquereur->code_postal.' '.$acquereur->ville}}</span>
                                      </div>
                                      <div class="skype-content">
                                         <span class="contact-title"><strong>Téléphone:</strong></span>
                                         <span class="contact-skype">0612547896</span>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          @endif
                       </div>
                    </div>
                 </div>
                 <!--table-->
                 <div class="user-profile">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="custom-tab user-profile-tab">
                             <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tbrs" aria-controls="1" role="tab" data-toggle="tab">Liste des personnes</a></li>
                             </ul>
                             <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tbrs">
                                   <div class="table-responsive">
                                      <table class="table table-hover table-striped">
                                         <thead>
                                            <tr>
                                               <th>Nom et prenom</th>
                                               <th>Email et téléphone</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                             @foreach($acquereur->individus as $one)
                                             <tr>
                                                 <th scope="row"><span class="badge badge-pink">{{$one->civilite}}</span> <strong>{{$one->nom.' '.$one->prenom}}</strong></th>
                                                 <td><strong class="color-info">{{$one->email}}</strong><br>
                                                    <strong>{{$one->telephone}}</strong>
                                                 </td>
                                              </tr>
                                             @endforeach
                                         </tbody>
                                      </table>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!--table fin-->
              </div>
           </div>
        </div>
     </div>
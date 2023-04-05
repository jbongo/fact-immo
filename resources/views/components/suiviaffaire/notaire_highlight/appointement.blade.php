@if($affaire->statut === "compromis" && $affaire->rendez_vous_compromis === NULL)
<div class="panel lobipanel-basic panel-danger">
        <div class="panel-heading">
            <div class="panel-title"><strong>Rendez-vous compromis non fixé !</strong></div>
        </div>
        <div class="panel-body">
            Le rendez-vous pour la signature n'est pas encore fixé, vous pourrez le fixer en fonction de vos disponibilités en cliquant sur le boutton ci-dessous, un email contenant les details du rendez-vous sera envoyé aux vendeurs et acquéreurs.
        </div>
    </div>
@endif

@if($affaire->statut === "compromis" && $affaire->rendez_vous_compromis != NULL)
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
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($affaire->mandat->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                           </tr>
                           @endforeach
                           @if($compromis != NULL)
                           @foreach($compromis->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-7">
               <div class="custom-tab user-profile-tab">
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                  </ul>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="1">
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
@endif

@if($affaire->statut === "acte" && $affaire->rendez_vous_acte === NULL)
<div class="panel lobipanel-basic panel-danger">
        <div class="panel-heading">
            <div class="panel-title"><strong>Rendez-vous acte non fixé !</strong></div>
        </div>
        <div class="panel-body">
            Le rendez-vous pour la signature n'est pas encore fixé, vous pourrez le fixer en fonction de vos disponibilités en cliquant sur le boutton ci-dessous, un email contenant les details du rendez-vous sera envoyé aux vendeurs et acquéreurs.
        </div>
    </div>
@endif

@if($affaire->statut === "acte" && $affaire->rendez_vous_acte != NULL)
@php
    $rdv = unserialize($affaire->rendez_vous_acte);
    $notaire = \App\Models\Entite::where('id', $rdv['notaire_id'])->firstOrFail();
@endphp
<!--info rdv compromis-->
<div class="panel panel-danger lobipanel-basic">
   <div class="panel-heading"><strong>Détails du rendez-vous acte</strong></div>
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
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($affaire->mandat->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                           </tr>
                           @endforeach
                           @if($compromis != NULL)
                           @foreach($compromis->entite->individus as $one)
                           <tr>
                              <td><span class="badge badge-dark">{{$one->civilite}}</span></td>
                              <td><strong>{{$one->nom}} {{$one->prenom}}</strong></td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-7">
               <div class="custom-tab user-profile-tab">
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                  </ul>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="1">
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
@endif

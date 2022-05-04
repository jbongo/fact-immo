@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Profil du prospect 
@endsection
<style>
.modal-content {
    border-radius: 50px;
    width: 90%;
}
</style>
<div class="row">

   <div class="col-lg-12">
   
      <div class="card">
    <a href="{{route('prospect.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('liste des prospects ')</a>
      
         <div class="card-body">
            <div class="col-lg-6">
            
            
               <div class="panel panel-default lobipanel-basic">
                  <div class="panel-heading">Fiche Prospect.</div>
                  <div class="panel-body">
                     <div class="card alert">
                        <div class="card-body">
                           <div class="user-profile">
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="col-lg-12">
                                       <div class="user-photo m-b-30">
                                          <img class="img-responsive" style="object-fit: cover; width: 225px; height: 225px; border: 5px solid #8ba2ad; border-style: solid; border-radius: 20px; padding: 3px;" src="{{asset('/images/avatar/'.(($prospect->civilite == "Mme." || $prospect->civilite == "Mme") ? "user_female.jpg ": "user_male.jpg"))}}" alt="">
                                       </div>
                                    </div>
    
                                    <div class="user-skill">
                                       <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                                       @if (auth()->user()->role == "admin")
                                            <a href="{{route('prospect.edit',Crypt::encrypt($prospect->id) )}}"  class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                       @endif
                                            <a href="{{route('prospect.fiche',Crypt::encrypt($prospect->id) )}}" target="_blank"  class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Fiche prospect</a>
                          
                                        
                                     
                                    </div>
                                 </div>
                                 <div class="col-lg-8">
                                    <div class="user-profile-name" style="color: #d68300;">{{$prospect->civilite}} {{$prospect->nom}} {{$prospect->prenom}}</div>
                                    <div class="user-Location"><i class="ti-location-pin"></i> {{$prospect->ville}}</div>
                                    
                                    <div class="custom-tab user-profile-tab">
                                       <ul class="nav nav-tabs" role="tablist">
                                          <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                                       </ul>
                                       <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane active" id="1">
                                             <div class="contact-information">
                                               
                                                <div class="phone-content">
                                                   <span class="contact-title"><strong>Téléphone Personnel:</strong></span>
                                                   <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$prospect->telephone_portable}}</span>
                                                </div>
                                                <div class="phone-content">
                                                    <span class="contact-title"><strong>Téléphone Fixe:</strong></span>
                                                    <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$prospect->telephone_fixe}}</span>
                                                 </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Adresse:</strong></span>
                                                   <span class="mail-address">{{$prospect->adresse}}</span>
                                                </div>
                                                
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Code postal:</strong></span>
                                                   <span class="contact-website">{{$prospect->code_postal}}</span>
                                                </div>
                                                
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Ville:</strong></span>
                                                   <span class="contact-website">{{$prospect->ville}}</span>
                                                </div>
                                              
                                                <div class="email-content">
                                                   <span class="contact-title"><strong>Email:</strong></span>
                                                   <span class="contact-email" style="color: #ff435c; text-decoration: underline;">{{$prospect->email}}</span>
                                                </div>
                                               
                                             </div>
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Date d'ajout:</strong></span>
                                                   <span class="gender">{{date('d-m-Y',strtotime($prospect->created_at ))}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Commentaire prospect:</strong></span>
                                                   <span class="gender">{{$prospect->commentaire_pro}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">
                                                {{-- <h4 style="color: #32ade1;text-decoration: underline;">Role utilisateur</h4> --}}
                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Commentaire admin:</strong></span>
                                                   <span class="gender">{{$prospect->commentaire_perso}}</span>
                                                </div>
                                             </div>
                                             
                                             
                                             <hr>
                                             @if($prospect->est_mandataire == true )
                                                <a href="{{route('mandataire.show',Crypt::encrypt($prospect->user_id) )}}"  class="btn btn-default btn-rounded btn-addon btn-sm m-b-10"><i class="ti-link"></i>Profil mandataire</a>
                                             @endif
                                             <hr>
                                             
                                             @if($prospect->renseigne == true )
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Date de naissance :</strong></span>
                                                   <span class="gender"> @if($prospect->date_naissance != null) {{$prospect->date_naissance->format('d/m/Y')}} @endif </span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Lieu de naissance :</strong></span>
                                                   <span class="gender">{{$prospect->lieu_naissance}}</span>
                                                </div>
                                             </div>
                                             
                                             
{{--                                              
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Département de naissance :</strong></span>
                                                   <span class="gender">{{$prospect->departement_naissance}}</span>
                                                </div>
                                             </div> --}}
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Situation familliale :</strong></span>
                                                   <span class="gender">{{$prospect->situation_familliale}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Nationalité :</strong></span>
                                                   <span class="gender">{{$prospect->nationalite}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>	Nom du père :</strong></span>
                                                   <span class="gender">{{$prospect->nom_pere}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Nom de la mère :</strong></span>
                                                   <span class="gender">{{$prospect->nom_mere}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Statut souhaité :</strong></span>
                                                   <span class="gender">{{$prospect->statut_souhaite}}</span>
                                                </div>
                                             </div>
                                             
                                             
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Codes postaux souhaités:</strong></span>
                                                   <span class="gender">{{$prospect->code_postaux}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Numéro RSAC:</strong></span>
                                                   <span class="gender">{{$prospect->numero_rsac}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Numéro SIRET:</strong></span>
                                                   <span class="gender">{{$prospect->numero_siret}}</span>
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Carte d'identité :</strong></span>
                                                   
                                                   @if($prospect->piece_identite != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"piece_identite"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Attestion responsabilité  :</strong></span>
                                                   
                                                   @if($prospect->attestation_responsabilite != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"attestation_responsabilite"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Rib :</strong></span>
                                                   
                                                   @if($prospect->rib != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"rib"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             
                                             <div class="basic-information">                                                
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Photo :</strong></span>
                                                   
                                                   @if($prospect->photo != null)
                                                        <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité" style="color: #fff"   href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"photo"])}}"  class="  m-b-10 m-l-5 ">Télécharger <i class="ti-download"></i> </a>
                                                   
                                                   @else 
                                                        <span class="contact-title text-danger"><strong> Non Ajoutée </strong></span>                                                  
                                                   @endif                                                
                                                </div>
                                             </div>
                                             
                                             @else 
                                             
                                             
                                             
                                             
                                             @endif
                                            
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
         
                
          
            <div class="col-lg-6">



<hr style="border:2px solid red">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="ti-id-badge f-s-48 color-danger m-r-1"></i> <label  style="font-weight: bold">Fiche (formulaire) envoyée par mail au prospect</label>
                                </div>
                                <br>
                                
                                <div class="media-body">
                                    
                                    <p><label class="color-primary">La fiche a t'elle été consultée par le prospect ? :</label>  @if($prospect->a_ouvert_fiche == true)<span  style="color:white" class="badge badge-success">Oui</span>@else <span class="badge badge-danger" style="color:white"  >Non</span> @endif </p>
                                    <p><label class="color-primary">La fiche a t'elle été renseignée par le prospect ? :</label>  @if($prospect->renseigne == true)<span  style="color:white" class="badge badge-success">Oui</span>@else <span class="badge badge-danger" style="color:white"  >Non</span> @endif </p>
                                </div>
                                
                                <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:20px; margin-top: 50px;">&Eacute;TAPES POUR PASSER &Aacute; MANDATAIRE</span>
                                
                                 <div>
                                  <hr>
                                    <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:15px; margin-top: 40px;">&Eacute;TAPE 1  
                                          @if($prospect->modele_contrat_envoye == true) 
                                             <span style="color: #00f5a4; font-size: 5px; margin-left:10px " >  <i class="small material-icons">check_circle</i></span>                                            
                                          @else
                                             <span style="color: #df450d; font-size: 5px; margin-left:10px " >  <i class="small material-icons">highlight_off</i></span>
                                          @endif
                                    </span>
                                    <br>
                                   
                                
                                    <span><a href="{{route('prospect.envoyer_modele_contrat',Crypt::encrypt($prospect->id) )}}" style="background: #3b4842" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Envoyer le modèle de contrat à  ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->modele_contrat_envoye == true) Renvoyer @else Envoyer @endif le modèle de contrat </a> </span>
                                    <span><a href="{{route('prospect.telecharger_modele_contrat',Crypt::encrypt($prospect->id) )}}" target="_blank" style="background: #641142" class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang('Télécharger le modèle de contrat à  ') {{ $prospect->nom }}"><i class="ti-download"></i>Télécharger le modèle de contrat </a> </span>
                                    
                                    @if($prospect->date_envoi_modele_contrat != null)
                                       <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:13px; margin-top: 20px; color:#1a068c"> Dernier envoi du modèle de contrat | {{$prospect->date_envoi_modele_contrat->format('d/m/Y')}}  </span>
                                    @endif
                                    <hr>
                                    <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:15px; margin-top: 60px;">&Eacute;TAPE 2
                                       @if($prospect->fiche_envoyee == true) 
                                             <span style="color: #00f5a4; font-size: 5px; margin-left:10px " >  <i class="small material-icons">check_circle</i></span> 
                                          
                                          @else
                                             <span style="color: #df450d; font-size: 5px; margin-left:10px " >  <i class="small material-icons">highlight_off</i></span>
                                       @endif
                                    </span>
                                    <br>
                                    
                                    
                                    <span><a href="{{route('prospect.envoi_mail_fiche',Crypt::encrypt($prospect->id) )}}"class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"  data-toggle="tooltip" title="@lang('Envoyer la fiche à remplir à ') {{ $prospect->nom }}"><i class="ti-email"></i>@if($prospect->fiche_envoyee == true) Renvoyer @else Envoyer @endif  fiche prospect </a> </span>
                                    
                                    @if($prospect->date_envoi_fiche != null)
                                       <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:13px; margin-top: 20px; color:#1a068c"> Dernier envoi de la fiche | {{$prospect->date_envoi_fiche->format('d/m/Y')}}  </span>
                                    @endif
                                    <hr> 
                                    <span style="display:flex; flex-direction:row; justify-content:center; font-weight:bold; font-size:15px; margin-top: 60px;">&Eacute;TAPE 3
                                       @if($prospect->est_mandataire == true) 
                                             <span style="color: #00f5a4; font-size: 5px; margin-left:10px " >  <i class="small material-icons">check_circle</i></span> 
                                          
                                          @else
                                             <span style="color: #df450d; font-size: 5px; margin-left:10px " >  <i class="small material-icons">highlight_off</i></span>
                                       @endif
                                    </span>
                                    <br>
                                 
                                                                  
                                    <span><a  @if($prospect->fiche_envoyee == true)  href="{{route('prospect.prospect_a_mandataire',Crypt::encrypt($prospect->id) )}}" class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5" @else
                                    
                                       class="btn btn-flat btn-addon m-b-10 m-l-5" href="#" @endif data-toggle="tooltip" title="@lang('Passer le prospect à mandataire ') {{ $prospect->nom }}"><i class="ti-email"></i>Passer à mandataire </a> </span>
                                    
                                 </div>  
                              
                                 
                                
                             
                              
                              
                            </div>
                        </div>
                    </div>
                </div>

   
   
<hr style="border:2px solid red">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="media">

              
               <div class="media-left media-middle">
                  <i class="ti-list f-s-48 color-danger m-r-1"></i> <label for="" style="font-weight: bold">Liste des tâches </label>  <hr>  
                  <span><a href="{{route('prospect.agenda.show',$prospect->id )}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="@lang(' Voir Agenda ') {{ $prospect->nom }}"><i class="ti-calendar "></i>
                     Agenda</a></span>
               </div>
                <div class="col-lg-12">
                  <div class="card alert">
                      <div class="card-header">
                         
                          
                          <div class="card-header-right-icon">
                              <ul>
                                  <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                                  <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="recent-comment m-t-20">
                      
                      
                      @foreach ($agendas as $agenda)
                            <div class="media">
                             
                              <div class="media-body">
                                                                       
                                    <h4 class="media-heading">{{$agenda->type_rappel}} <span> <a href="#" data-toggle="modal" data-target="#add-agenda-{{$agenda->id}}" data-toggle="tooltip" title="@lang('Modifier ')"><i class=" material-icons color-warning">edit</i></a></span>  </h4>
                                  <p>{{$agenda->titre}} : <i>{{$agenda->description}} </i>  </p> 
                                  <div class="comment-action">
                                 @if($agenda->est_terminee == true )
                                    <div class="badge badge-success">Terminée</div>
                                 @else 
                                    <div class="badge badge-danger">Non Terminée</div>
                                 @endif
                                      <span class="m-l-10">
                             {{-- <a href="#"><i class="ti-check color-success"></i></a>
                             <a href="#"><i class="ti-close color-danger"></i></a>
                             <a href="#"><i class="fa fa-reply color-primary"></i></a> --}}
                          </span>
                                  </div>
                                  @php 
                                       $date_deb = new DateTime($agenda->date_deb);
                                  @endphp
                                  <p class="comment-date">{{$date_deb->format('d/m/Y')}} à {{$agenda->heure_deb}}</p>
                              </div>
                          </div>
                    
                    
                    
                       <!-- Modal Add agenda -->
                     <div class="modal fade none-border" id="add-agenda-{{$agenda->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><strong>Ajouter un évènement</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('prospect.agenda.update')}}" method="post">
                                    
                                    @csrf
                                    <input type="hidden" name="id" value="{{$agenda->id}}" />
                                    <input type="hidden" name="prospect_id" value="{{$prospect->id}}" />
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Date début</label>
                                            <input class="form-control form-white" placeholder="" value="{{$agenda->date_deb}}" type="date" name="date_deb" />
                                        </div><div class="col-md-6">
                                            <label class="control-label">Date Fin</label>
                                            <input class="form-control form-white" placeholder="" value="{{$agenda->date_fin}}" type="date" name="date_fin" />
                                        </div>
                                        
                                        <div class="col-md-6">
                                          <label class="control-label">Type de rappel</label>
                                          <select name="type_rappel"  class="form-control form-white" id="type_rappel" required>
                                              <option value="{{$agenda->type_rappel}} ">{{$agenda->type_rappel}} </option>
                                              <option value="appel">appel</option>                                                    
                                              <option value="rappel">rappel</option>
                                              <option value="rdv">rdv</option>
                                              <option value="autre">autre</option>
                                          </select>
                                      </div>
                                      
                                        <div class="col-md-6">
                                            <label class="control-label">Heure début</label>
                                            <input class="form-control form-white" placeholder="" type="time" value="{{$agenda->heure_deb}}"  min="06:00" max="23:00" required name="heure_deb" />
                                        </div>
                  
                                    </div>
                                    <hr>
                                    <div class="row">
                                    
                                        
                                        
                                        <div class="col-md-6">
                                            <label class="control-label text-danger">Tâche terminée ?</label>
                                            <select name="est_terminee" class="form-control form-white" id="est_terminee" required>
                                                <option value="{{$agenda->est_terminee == true ? 'true' : 'false'}}">{{$agenda->est_terminee == true ? 'Oui' : 'Non'}}</option>
                                               
                                                <option value="true">Oui </option>                                    
                                                <option value="false">Non</option>                                    
                                              
                                            </select>
                                        </div>
                                    
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Titre</label>
                                            <input class="form-control form-white" placeholder="" value="{{$agenda->titre}} " type="text" name="titre" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="control-label">Description</label>
                                           <textarea name="description" class="form-control" id="" cols="30" rows="5">{{$agenda->description}} </textarea>
                                        </div>
                                    </div>
                                    
                                    
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                                    
                                    <input type="submit" class="btn btn-success waves-effect waves-light save-agenda"  value="Modifier">
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL -->
  
  
                       @endforeach
                      
                      </div>
                  </div>
                  <!-- /# card -->
              </div>
              
              
              <div class="media-left media-middle">
               <i class="ti-folder f-s-48 color-danger m-r-1"></i> <label for="" style="font-weight: bold">Bibliothèque</label>
               </div>
          
             <br>
             <br>
           
           <div class="col-lg-12">
             <div class="card alert">
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table table-hover">
                             <thead>
                                 <tr>
                                     <th>Document</th>
                                     <th>Envoyé le</th>
                                     <th>Lu le</th>
                                     <th>avez-vous compris ?</th>
                                     <th></th>
                                 </tr>
                             </thead>
                             <tbody>
                             
                               @foreach ($documents as $document)
                               
                               <tr>
                                  <td>{{$document->nom}}</td>
                                  <td>@if($prospect->getBibliotheque($document->id)!= null) <span class="text-success" style="font-size: 13px"> {{$prospect->getBibliotheque($document->id)->pivot->created_at->format('d/m/Y') }} </span> @else <span class="text-danger" style="font-size: 13px"> non envoyé   @endif</td>
                                  
                                  
                                  <td>@if($prospect->getBibliotheque($document->id) && $prospect->getBibliotheque($document->id)->pivot->est_fichier_vu == true ) <span class="text-warning" style="font-size: 13px">{{$prospect->getBibliotheque($document->id)->pivot->updated_at->format('d/m/Y') }} </span>  @endif</td>
                                  <td>@if($prospect->getBibliotheque($document->id)!= null) 
                                  
                                    @if($prospect->getBibliotheque($document->id)->pivot->question1 == "Oui") <span  style="color:white; font-size: 10px" class="badge badge-success">Oui</span>@elseif($prospect->getBibliotheque($document->id)->pivot->question1 == "Non") <span class="badge badge-danger" style="color:white; font-size: 10px" >Non</span> @endif
                                
                                  
                                  @endif</td>
                                  <td><a href="{{route('bibliotheque.envoyer', [$document->id,$prospect->id, "prospect" ])}}"  style="background: #3b4842" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5" data-toggle="tooltip" title="Envoyer par mail"><i class="ti-email"></i>Envoyer  </a></td>

                              </tr>
                               @endforeach
                             
                                
                                
                    
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
           <hr>
              
              
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

@endsection
@section('js-content')
<script>

 $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('a.send-access').click(function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
})

    swalWithBootstrapButtons({
        title: '@lang('Le prospect recevra ses accès. Continuer ?')',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: '@lang('Oui')',
        cancelButtonText: '@lang('Non')',
        
    }).then((result) => {
        if (result.value) {
            $('[data-toggle="tooltip"]').tooltip('hide')
                $.ajax({                        
                    url: that.attr('href'),
                    type: 'get'
                })
                .done(function () {
                        that.parents('tr').remove()
                })

            swalWithBootstrapButtons(
            'Envoyé!',
            'Un email a été envoyé au prospect.',
            'success'
            )
            
            
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Envoi annulé',
            'error'
            )
        }
    })
        })
    })

</script>
@endsection
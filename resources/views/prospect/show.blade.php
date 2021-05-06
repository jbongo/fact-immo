@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Profil du prospect 
@endsection
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="col-lg-6">
               <div class="panel panel-default lobipanel-basic">
                  <div class="panel-heading">Fiche utilisateur.</div>
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
                                        
                                        @if (auth()->user()->role == "admin" && $prospect->contrat != null)
                                       <a href="{{route('prospect.send_access',[ Crypt::encrypt($prospect->id) ,Crypt::encrypt($prospect->contrat->id) ])}}" title="Envoyer les accès au prospect" class="btn btn-default btn-rounded btn-addon btn-xs m-b-10 send-access"><i class="ti-pencil"></i>Envoyer les accès </a>
                                        @endif
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
                                                   <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$prospect->telephone_personnel}}</span>
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
            @if ($prospect->role == "prospect")
                
          
            <div class="col-lg-6">
              
               <div class="panel panel-success lobipanel-basic">
                     <div class="panel-heading">Statistiques.</div>
                     <div class="panel-body">
                           <div class="col-lg-4 col-md-4 col-sm-4 ">
                                 <div class="card bg-danger">
                                     <div class="media">
                                         <div class="media-left meida media-middle">
                                             <span><i class="ti-home f-s-48 color-white"></i></span>
                                         </div>
                                         <div class="media-body media-text-right">
                                         <h4>{{$nb_affaire}}</h4>
                                             <h5>Affaires</h5>
                                         </div>
                                     </div>
                                 </div>
                                </div>
                            
                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                    <div class="card bg-primary">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="ti-money f-s-48 color-white"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h4>{{number_format($prospect->chiffre_affaire,2,'.',' ')}}€</h4>
                                                <h5>Chiffre d'affaires</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                    <div class="card bg-success">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="ti-money f-s-48 color-white"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <h4>{{$nb_filleul}}</h4>
                                                <h5>Filleuls</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                     </div>
                  </div>


            @if($parrain != null)

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <i class="ti-id-badge f-s-48 color-danger m-r-15"></i>
                                </div>
                                <div class="media-body">
                                    <h4>Parrain</h4>
                                    <p><label class="color-primary">{{$parrain->nom}} {{$parrain->prenom}}</label> </p>
                                </div>
                                {{-- <div class="media-right media-middle f-s-30">
                                    18000
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            @endif

                  
                    @if($nb_filleul > 0)
                    <div class="panel panel-default lobipanel-basic">
                        <div class="panel-heading">Filleuls.</div>
                        <div class="panel-body">
                             
                                <div class="table-responsive" style="overflow-x: inherit !important;">
                                        <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Nom filleul')</th>
                                                    <th>@lang('Rang')</th>
                                                    <th>@lang('Expire le')</th>
                                                    <th>@lang('Action')</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($filleuls as $filleul)
                                                <tr>
                                           
                                                    <td style="color: #32ade1; text-decoration: underline;">
                                                    <strong>{{$filleul->user->nom}} {{$filleul->user->prenom}}</strong> 
                                                    </td>
                                                    <td style="color: #e05555;; text-decoration: underline;">
                                                        <strong> {{$filleul->rang}} </strong> 
                                                    </td>
                                                    <td style="color: #e05555;">
                                                        @php 
                                                            $date_expire = strtotime($filleul->user->contrat->date_deb_activite.'+3 year');
                                                            $date_expire = date('d-m-Y', $date_expire);
                                                        @endphp 
                                                        <strong> {{$date_expire}} </strong> 
                                                    </td>
                                                                                     
                                                    <td>
                                                        <span><a href="{{route('prospect.show',Crypt::encrypt($filleul->user_id))}}" data-toggle="tooltip" title="@lang('Détail ') {{ $filleul->nom }}"><i class="large material-icons color-warning">visibility</i></a></span>
                                                    </td>
                                                </tr>
                                        @endforeach
                                          </tbody>
                                        </table>
                                    </div>
                                
                        </div>
                    </div>
                    @endif
             
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
@if ($prospect->role == "prospect")
<div class="row">
    <div class="panel panel-warning lobipanel-basic">
        <div class="panel-heading">Contrat.</div>
        <div class="panel-body">
            @if ($prospect->contrat != null)
    <a href="{{route('contrat.historique', Crypt::encrypt($prospect->contrat->id))}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-timer"></i>@lang('Voir l\'historique du contrat')</a> 
            @endif
                <div class="row">
                        <div class="col-lg-12">
                            
                            @if ($prospect->contrat == null)
                            <label class="color-red" >  <h4>  Pas de contrat </h4></label> <hr>
                                @if (auth()->user()->role == "admin")
                                    @php
                                        $prospect_id = Crypt::encrypt($prospect->id);
                                    @endphp
                                    <a class="btn btn-default btn-flat btn-addon btn-lg m-b-10 m-l-5 " href="{{route('contrat.create',$prospect_id)}}" ><i class="ti-plus"></i>Ajouter contrat</a> <hr>
                                @endif
                            @else 
                                @if (auth()->user()->role == "admin")
                                    <a href="{{route('contrat.edit',Crypt::encrypt($prospect->contrat->id) )}}"  class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                @endif
                            <div class="card">
                                <div class="col-lg-10">
                                </div>
                                <div class="card-body">
                    
                                    <div class="panel-body">
                                        <fieldset class="col-md-12">
                                            <legend>Infos basiques</legend>
                                            <div class="panel panel-warning">
                                                <div class="panel-body">
                    
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                    
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label" for="forfait_entree">Forfait d'entrée (€)<span class="text-danger">*</span></label>
                                                                    <div class="col-lg-4">
                                                                    <label class="color-primary">{{$prospect->contrat->forfait_entree}}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-6 col-form-label" for="est_starter">Démarrage en tant que Starter ?</label>
                                                                    <label class="color-primary">{{$prospect->contrat->est_demarrage_starter == 1 ? "Oui" : "Non"}}</label>
                                                                    
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-6 col-form-label" for="a_parrain">Le prospect a t'il un parrain ?</label>
                                                                    <label class="color-primary">{{$prospect->contrat->a_parrain == 1 ? "Oui" : "Non"}}</label>
                                                                </div>
                                                                
                                                                @if ($prospect->contrat->a_parrain == 1)
                                                                    <div class="form-group row" id="parrain-id">
                                                                        <label class="col-lg-4 col-form-label" for="parrain_id">Parrain</label>
                                                                        <div class="col-lg-8">
                                                                        <label class="color-primary">{{$parrain->nom}} {{$parrain->prenom}}</label>  
                                                                            {{--**********************  --}}
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                


                                                            </div>
                    
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label" for="date_entree">Date d'entrée<span class="text-danger">*</span></label>
                                                                    <div class="col-lg-4">
                                                                    <label class="color-primary">{{$prospect->contrat->date_entree}}</label>

                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label" for="date_debut">Date de début d'activité<span class="text-danger">*</span></label>
                                                                    <div class="col-lg-4">
                                                                    <label class="color-primary">{{$prospect->contrat->date_deb_activite}}</label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label" for="ca_depart">Chiffre d'affaires de départ<span class="text-danger">*</span></label>
                                                                    <div class="col-lg-4">
                                                                        <label class="color-primary">{{number_format($prospect->contrat->ca_depart,2,'.',' ')}} €</label>                                                                        
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                    
                                    <div class="panel-body">
                                        <fieldset class="col-md-12">
                                            <legend>Commission directe</legend>
                                            <div class="panel panel-warning">
                                                <div class="panel-body">
                    
                                                    {{-- PACK STARTER --}}
                                                @if ($prospect->contrat->est_demarrage_starter == 1)
                                                    
                                                <div class="row" id="pack_starter">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12 col-sm-12 "style="color: #5c96b3; ">
                                                                <h4> <strong><center> @lang('Starter') </center></strong></h4>                          
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                           
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="pourcentage_depart_starter">Pourcentage de départ du prospect<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <label class="color-primary">{{$prospect->contrat->pourcentage_depart_starter}} %</label>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group row" id="max-starter-parrent">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="duree_max_starter">Durée maximum du pack Starter<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <label class="color-primary">{{$prospect->contrat->duree_max_starter}} </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-form-label" for="duree_gratuite_starter">Durée de la gratuité (mois)<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <label class="color-primary">{{$prospect->contrat->duree_gratuite_starter}} </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    @if ($prospect->contrat->a_palier_starter == 1)
                                                        
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                    
                                                            <div class="col-lg-12 col-md-12 col-sm-12" id="palier_starter">
                                                                <div class="panel panel-pink m-t-15">
                                                                    <div class="panel-heading"></div>
                                                                    <div class="panel-body">
                                                                        <div class="input_fields_wrap_starter">
                                                                        <span>Niveau starter actuel : {{$niveau_starter}}</span>
                                                                            <div class="card alert">
                                                                                    <div class="card-header">
                                                                                        <h4><strong>Paliers Starter</strong> </h4>
                                                                                    </div>

                                                                                    <div class="card-body">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-bordered">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Niveau</th>
                                                                                                        <th>Pourcentage en +</th>
                                                                                                        <th>chiffre affaires min</th>
                                                                                                        <th>chiffre affaires max</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                @foreach ($palier_starter as $pal)
                                                                                               
                                                                                                    
                                                                                                
                                                                                                    <tr  @if ($pal[0] == $niveau_starter) style="background-color:linen" @endif>
                                                                                                        <th class="color-primary" scope="row">{{$pal[0]}}</th>
                                                                                                        <td>{{$pal[1]}}</td>
                                                                                                        <td>{{number_format($pal[2],2,'.',' ')}} €</td>
                                                                                                        <td>{{number_format($pal[3],2,'.',' ')}} €</td>
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
                                                            </div>
                                                        </div>
                                                        @else 
                                                            <label class="color-danger">pas de palier starter</label>
                                                        @endif
                    
                                                    </div>
                                                    @endif
                                                    
                    
                                                {{-- </div> --}}
                                                {{-- FIN PACK STARTER --}}
                    
                    
                    
                                                {{-- PACK EXPERT --}}
                                                <br>
                                                <hr>
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-sm-12 "style="color: #5c96b3; ">
                                                            <h4> <strong><center> @lang('Expert') </center></strong></h4>                          
                                                        </div>
                                                    </div><hr>
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="pourcentage_depart_expert">Pourcentage de départ du prospect<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <label class="color-primary">{{$prospect->contrat->pourcentage_depart_expert}} %</label>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                           
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-form-label" for="duree_gratuite_expert">Durée de la gratuité (mois)<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <label class="color-primary">{{$prospect->contrat->duree_gratuite_expert}} </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    @if ($prospect->contrat->a_palier_expert == 1)
                                                        
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                    
                                                            <div class="col-lg-12 col-md-12 col-sm-12" id="palier_expert">
                                                                <div class="panel panel-pink m-t-15">
                                                                    <div class="panel-heading"></div>
                                                                    <div class="panel-body">
                                                                        <div class="input_fields_wrap_expert">
                                                                        <span>Niveau expert actuel : {{$niveau_expert}}</span>                                                                            
                                                                            <div class="card alert">
                                                                                    <div class="card-header">
                                                                                        <h4><strong>Paliers Expert</strong> </h4>
                                                                                    </div>

                                                                                    <div class="card-body">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-bordered">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Niveau</th>
                                                                                                        <th>Pourcentage en +</th>
                                                                                                        <th>chiffre affaires min</th>
                                                                                                        <th>chiffre affaires max</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                @foreach ($palier_expert as $pal)
                                                                                                    <tr @if ($pal[0] == $niveau_expert) style="background-color:linen" @endif>
                                                                                                        <th class="color-primary" scope="row">{{$pal[0]}}</th>
                                                                                                        <td>{{$pal[1]}}</td>
                                                                                                        <td>{{number_format($pal[2],2,'.',' ') }} €</td>
                                                                                                        <td>{{number_format($pal[3],2,'.',' ') }} €</td>
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
                                                            </div>
                                                        </div>
                    
                                                    </div>
                                                    @else 
                                                        <label class="color-danger">pas de palier expert</label>
                                                    @endif
                    
                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                    
                                                            <div class="col-lg-12" id="expert-par">
                                                                <div class="panel panel-default m-t-15">
                                                                    <div class="panel-heading-default"><strong>Paramètres du pack expert</strong></div>
                                                                    <div class="panel-body">
                                                                        <br>
                                                                        <br>
                                                                        </strong>
                    
                                                                        <div class="row">
                                                                            <div class="col-lg-6-col-md-6 col-sm-6">
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="nombre_vente_min">Nombre de vente minimum</label>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                                        <label class="color-primary">{{$prospect->contrat->nombre_vente_min}} </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="nombre_mini_filleul">Nombre minimum de filleuls parrainés</label>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                                        <label class="color-primary">{{$prospect->contrat->nombre_mini_filleul}} </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6-col-md-6 col-sm-6">
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="chiffre_affaire">Chiffre d'affaires (€) </label>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                                        <label class="color-primary">{{$prospect->contrat->chiffre_affaire}} €</label>
                                                                                    </div>
                                                                                </div>
                                                                                <strong>Si ces conditions ne sont pas réunies alors:
                                                                                <br>
                                                                                <br>
                                                                                </strong>
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="a_soustraitre">A soustraire (%)</label>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                                        <label class="color-primary">{{$prospect->contrat->a_soustraitre}} %</label>
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
                                                {{-- FIN PACK EXPERT --}}
                    
                    
                    
                    
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>
                    
                                    <div class="panel-body" id="parrainage_div">
                                        <fieldset class="col-md-12">
                                            <legend>Parrainage</legend>
                                            <div class="panel panel-warning">
                                                <div class="panel-body">
                    
                                                    <div class="row">
                                                                                <!-- /# column -->
                                            <div class="col-lg-6">
                                                    <div class="card alert">
                                                        <div class="card-header">
                                                            <h4>&Eacute;volution de l'impact </h4>
                                
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                           
                                                                            <th>Année</th>
                                                                            <th>1er filleul</th>
                                                                            <th>2<sup> ème</sup> filleul</th>
                                                                            <th>3<sup> ème</sup> filleul</th>
                                                                            <th>4<sup> ème</sup> filleul</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="color-primary" scope="row">1</th>
                                                                            <td>5%</td>
                                                                            <td>5%</td>
                                                                            <td>5%</td>
                                                                            <td>5%</td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="color-primary" scope="row">2</th>
                                                                            <td>3%</td>
                                                                            <td>4%</td>
                                                                            <td>5%</td>
                                                                            <td>5%</td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="color-primary" scope="row">3</th>
                                                                            <td>1%</td>
                                                                            <td>3%</td>
                                                                            <td>4%</td>
                                                                            <td>5%</td>
                                                                            
                                                                        </tr>
                                                                       
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group row" id="max-starter-parrent">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label col-form-label" for="prime_max_forfait">Prime forfaitaire si le parrain est à 100% (€)<span class="text-danger">*</span></label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                                    <label class="color-primary">{{$prospect->contrat->prime_forfaitaire}} €</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                    
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>
                    
                                    <div class="panel-body">
                                        <fieldset class="col-md-12">
                                            <legend>Pack pub</legend>
                                            <div class="panel panel-warning">
                                                <div class="panel-body">
                    
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="color-primary">{{$prospect->contrat->packpub->nom}} &nbsp;&nbsp;</label>
                                                                <label class="color-danger">{{$prospect->contrat->packpub->tarif}} €</label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                    
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
            
                
        </div>
        @endif
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
<div class="row">
    <div class="col-lg-12">
        <div class="card p-0">
            <div class="media">
                <div class="p-5 bg-dark media-left media-middle">
                    <i class="ti-info-alt f-s-28 color-white"></i>
                </div>
                <div class="p-10 media-body">
                    <h4 class="color-dark m-r-10">@lang('Propriétaire du bien') </h4>
                    
                    <div class="progress progress-sm m-t-10 m-b-0">
                        <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-6 col-lg-6">
        <div style="text-align: center;">
            <label class="control-label" for="ajouter_proprietaire">Créer un nouveau propriétaire<span class="text-danger">*</span></label>
        
            <input type="checkbox" unchecked data-toggle="toggle" id="ajouter_proprietaire" name="ajouter_proprietaire" data-off="Non" data-on="Oui" data-onstyle="success  btn-sm" data-offstyle="danger btn-sm">
         </div>
    </div>
</div>

<div class="row" id="ancien_proprietaire" style="margin-top: 30px">  
    <div class="col-md-6 col-lg-6">
        <div class="form-group row" id="op1">
            <label class="control-label col-md-6 col-lg-6" for="proprietaire_id"> Selectionnez le propriétaire <span class="text-danger">*</span> </label>
            <div class="col-lg-8">
               <select class="selectpicker col-lg-8" id="proprietaire_id" name="proprietaire_id" data-live-search="true" data-style="btn-pink btn-rounded"  required>
                  @foreach($contacts as $contact)                 
                    @if($contact->type =="entité")
                    <option  value="{{$contact->id}}" data-content="<img class='avatar-img' src='{{asset("images/photo_profile/default.png")}}' alt=''/>
                    <span class='user-avatar'></span><span class='badge badge-pink'>  {{$contact->entite->forme_juridique}}</span> {{$contact->entite->raison_sociale}} " data-tokens="{{$contact->entite->forme_juridique}} {{$contact->entite->raison_sociale}}"></option>
                    @else 
                    {{-- // 'personne_seule', 'couple', 'personne_morale', 'groupe', 'autre' --}}
                        @if($contact->nature == "Propriétaire")
                        <option  value="{{$contact->id}}" data-content="<img class='avatar-img' src='{{asset("images/photo_profile/couple.png")}}'alt=''/>
                        <span class='user-avatar'></span><span class='badge badge-pink'>  {{$contact->individu->civilite}}</span> {{$contact->nom}} {{$contact->individu->prenom}}" data-tokens="{{$contact->individu->civilite}} {{$contact->individu->nom}} {{$contact->individu->prenom}}  "></option>
                        @endif
                    @endif
                  @endforeach                                
               </select>
            </div>
        </div>
    </div>
</div>

<div id="nouveau_proprietaire"  style="margin-top: 30px">

    <div class="row">
        
        <input type="hidden" name="nature" value="Propriétaire">
        
        <div class="col-lg-3 col-md-3 col-sm-3  ">
            <div class="form-group ">
                <label class="col-lg-8  col-md-8  col-sm-48 control-label" style="padding-top: 5px;" for="type_contact1">Personne seule <span class="text-danger">*</span></label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                   <input type="radio" style="height: 22px;" class="form-control" id="type_contact1" name="nature_proprietaire" value="Personne seule" required>
                   @if ($errors->has('nature_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nature_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-3  ">

             <div class="form-group ">
                <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact2">Personne morale <span class="text-danger">*</span></label>
                <div class="col-lg-2 col-md-2 col-sm-2">
                   <input type="radio" style="height: 22px;" class="form-control"  id="type_contact2" name="nature_proprietaire"  value="Personne morale" required>
                   @if ($errors->has('nature_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nature_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-3 div_proprietaire ">

            <div class="form-group ">
               <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact3">Couple <span class="text-danger">*</span></label>
               <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="radio" style="height: 22px;" class="form-control" id="type_contact3" name="nature_proprietaire" value="Couple" required>
                  @if ($errors->has('nature_proprietaire'))
                  <br>
                  <div class="alert alert-warning ">
                     <strong>{{$errors->first('nature_proprietaire')}}</strong> 
                  </div>
                  @endif
               </div>
            </div>
       </div>
       <div class="col-lg-3 col-md-3 col-sm-3  ">

            <div class="form-group ">
               <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact4">Groupe <span class="text-danger">*</span></label>
               <div class="col-lg-2 col-md-2 col-sm-2">
                  <input type="radio" style="height: 22px;" class="form-control" id="type_contact4" name="nature_proprietaire" value="Groupe" required>
                  @if ($errors->has('nature_proprietaire'))
                  <br>
                  <div class="alert alert-warning ">
                     <strong>{{$errors->first('nature_proprietaire')}}</strong> 
                  </div>
                  @endif
               </div>
            </div>
       </div>
       
   
    </div>
    <input type="hidden" id="type" name="type">
    
    <div class="row">
         <hr>
        
         <div class="col-lg-6 col-md-6 col-sm-6">

                
              <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite1">@lang('Civilité') <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <select class="js-select2 form-control " id="civilite1" name="civilite1_proprietaire" style="width: 100%;" required>
                      <option value="{{old('civilite1')}}">{{old('civilite1_proprietaire')}}</option>
                      <option value="M">M</option>
                      <option value="Mme">Mme</option>
                   </select>
                   @if ($errors->has('civilite1_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('civilite1_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             
             
             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom1">Nom <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('nom1_proprietaire')}}" id="nom1" name="nom1_proprietaire"  required>
                   @if ($errors->has('nom1_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nom1_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>

             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom1">Prénom <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text"  class="form-control" value="{{old('prenom1_proprietaire')}}" id="prenom1" name="prenom1_proprietaire"  required>
                   @if ($errors->has('prenom1_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('prenom1_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email1">Email <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control" id="email1" value="{{old('email1_proprietaire')}}" name="email1_proprietaire"  required>
                   @if ($errors->has('email1_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('email1_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             
             <div class="form-group div_personne_couple">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_mobile1">Téléphone mobile </label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <input type="text" class="form-control " value="{{old('telephone_mobile1_proprietaire')}}" id="telephone_mobile1"  name="telephone_mobile1_proprietaire"  >
                    @if ($errors->has('telephone_mobile1_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('telephone_mobile1_proprietaire')}}</strong> 
                    </div>
                    @endif     
                 </div>
             </div>

            <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_fixe1">Téléphone fixe </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('telephone_fixe1_proprietaire')}}" id="telephone_fixe1" name="telephone_fixe1_proprietaire"  >
                   @if ($errors->has('telephone_fixe1_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('telephone_fixe1_proprietaire')}}</strong> 
                   </div>
                   @endif     
                </div>

            </div>
             

              <div class="form-group div_personne_seule">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <select class="js-select2 form-control " id="civilite" name="civilite_proprietaire" style="width: 100%;" required>
                       <option value="{{old('civilite_proprietaire')}}">{{old('civilite_proprietaire')}}</option>
                       <option value="M">M</option>
                       <option value="Mme">Mme</option>
                    </select>
                    @if ($errors->has('civilite_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('civilite_proprietaire')}}</strong> 
                    </div>
                    @endif
                 </div>
              </div>

              <div class="form-group div_personne_seule">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span class="text-danger">*</span></label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <input type="text" class="form-control " value="{{old('nom_proprietaire')}}" id="nom" name="nom_proprietaire"  required>
                    @if ($errors->has('nom_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('nom_proprietaire')}}</strong> 
                    </div>
                    @endif
                 </div>
              </div>

              <div class="form-group div_personne_seule">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom <span class="text-danger">*</span></label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <input type="text"  class="form-control" value="{{old('prenom')}}" id="prenom" name="prenom_proprietaire"  required>
                    @if ($errors->has('prenom_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('prenom_proprietaire')}}</strong> 
                    </div>
                    @endif
                 </div>
              </div>
              
              <div class="form-group div_personne_morale">
                <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="forme_juridique">Forme juridique<span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <select class="js-select2 form-control" id="forme_juridique" name="forme_juridique_proprietaire" style="width: 100%;" required>
                      <option value="{{old('forme_juridique_proprietaire')}}">{{old('forme_juridique_proprietaire')}}</option>
                      
                      <option value="">Non défini</option>
                      <option value="EURL">EURL - Entreprise unipersonnelle à responsabilité limitée</option>
                      <option value="EI">EI - Entreprise individuelle</option>
                      <option value="SARL">SARL - Société à responsabilité limitée</option>
                      <option value="SA">SA - Société anonyme</option>
                      <option value="SAS">SAS - Société par actions simplifiée</option>
                      <option value="SCI">SCI - Société civile immobilière</option>
                      <option value="SNC">SNC - Société en nom collectif</option>
                      <option value="EARL">EARL - Entreprise agricole à responsabilité limitée</option>
                      <option value="EIRL">EIRL - Entreprise individuelle à responsabilité limitée (01.01.2010)</option>
                      <option value="GAEC">GAEC - Groupement agricole d'exploitation en commun</option>
                      <option value="GEIE">GEIE - Groupement européen d'intérêt économique</option>
                      <option value="GIE">GIE - Groupement d'intérêt économique</option>
                      <option value="SASU">SASU - Société par actions simplifiée unipersonnelle</option>
                      <option value="SC">SC - Société civile</option>
                      <option value="SCA">SCA - Société en commandite par actions</option>
                      <option value="SCIC">SCIC - Société coopérative d'intérêt collectif</option>
                      <option value="SCM">SCM - Société civile de moyens</option>
                      <option value="SCOP">SCOP - Société coopérative ouvrière de production</option>
                      <option value="SCP">SCP - Société civile professionnelle</option>
                      <option value="SCS">SCS - Société en commandite simple</option>
                      <option value="SEL">SEL - Société d'exercice libéral</option>
                      <option value="SELAFA">SELAFA - Société d'exercice libéral à forme anonyme</option>
                      <option value="SELARL">SELARL - Société d'exercice libéral à responsabilité limitée</option>
                      <option value="SELAS">SELAS - Société d'exercice libéral par actions simplifiée</option>
                      <option value="SELCA">SELCA - Société d'exercice libéral en commandite par actions</option>
                      <option value="SEM">SEM - Société d'économie mixte</option>
                      <option value="SEML">SEML - Société d'économie mixte locale</option>
                      <option value="SEP">SEP - Société en participation</option>
                      <option value="SICA">SICA - Société d'intérêt collectif agricole</option>
                      
                   </select>
                   @if ($errors->has('forme_juridique_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('forme_juridique_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
              
              <div class="form-group div_personne_morale">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="raison_sociale">Raison sociale <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text"  class="form-control" value="{{old('raison_sociale_proprietaire')}}" id="raison_sociale" name="raison_sociale_proprietaire"  required>
                   @if ($errors->has('raison_sociale_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('raison_sociale_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             
             <div class="form-group div_personne_groupe">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom_groupe">Nom du groupe <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text"  class="form-control" value="{{old('nom_groupe_proprietaire')}}" id="nom_groupe" name="nom_groupe_proprietaire"  required>
                   @if ($errors->has('nom_groupe_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nom_groupe_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
            </div>
            
 
      
            <div id="source_div">
                <div class="form-group row" >
                 <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="source_id">Source du contact</label>
                 <div class="col-lg-8">
                         <select class="selectpicker col-lg-6" id="source_id" name="source_id_proprietaire" data-live-search="true" data-style="btn-warning btn-rounded">
                          
                          <option value=""> </option>                                        
                          <option value="Réseaux sociaux">Réseaux sociaux</option>
                          <option value="Bouche à oreille">Bouche à oreille</option>
                          <option value="Internet">Internet</option>
                          <option value="Autre">Autre</option>
                            
                         </select>
                    </div>
                 </div>
            </div>
            
             

         </div>
         
         <div class="col-lg-6 col-md-6 col-sm-6">       
           
            <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite2">@lang('Civilité') <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <select class="js-select2 form-control " id="civilite2" name="civilite2_proprietaire" style="width: 100%;" required>
                      <option value="{{old('civilite2_proprietaire')}}">{{old('civilite2_proprietaire')}}</option>
                      <option value="M">M</option>
                      <option value="Mme">Mme</option>
                   </select>
                   @if ($errors->has('civilite2_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('civilite2_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>

             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom2">Nom <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('nom2_proprietaire')}}" id="nom2" name="nom2_proprietaire"  required>
                   @if ($errors->has('nom2_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nom2_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>

             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom2">Prénom <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text"  class="form-control" value="{{old('prenom2_proprietaire')}}" id="prenom2" name="prenom2_proprietaire"  required>
                   @if ($errors->has('prenom2_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('prenom2_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email2">Email <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control" id="email2" value="{{old('email2_proprietaire')}}" name="email2_proprietaire"  required>
                   @if ($errors->has('email2_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('email2_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             
             <div class="form-group div_personne_couple">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_mobile2">Téléphone mobile </label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <input type="text" class="form-control " value="{{old('telephone_mobile2_proprietaire')}}" id="telephone_mobile2"  name="telephone_mobile2_proprietaire"  >
                    @if ($errors->has('telephone_mobile2_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('telephone_mobile2_proprietaire')}}</strong> 
                    </div>
                    @endif     
                 </div>
             </div>

            <div class="form-group div_personne_couple">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_fixe2">Téléphone fixe </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('telephone_fixe2_proprietaire')}}" id="telephone_fixe2" name="telephone_fixe2_proprietaire"  >
                   @if ($errors->has('telephone_fixe2_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('telephone_fixe2_proprietaire')}}</strong> 
                   </div>
                   @endif     
                </div>

            </div>
             
           
           
            <div class="form-group div_personne_tout">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email <span class="text-danger">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control" id="email" value="{{old('email_proprietaire')}}" name="email_proprietaire"  required>
                   @if ($errors->has('email_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('email_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
            </div>
             
            <div class="form-group div_personne_tout">
                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_mobile">Téléphone mobile </label>
                 <div class="col-lg-8 col-md-8 col-sm-8">
                    <input type="text" class="form-control " value="{{old('telephone_mobile_proprietaire')}}" id="telephone_mobile"  name="telephone_mobile_proprietaire"  >
                    @if ($errors->has('telephone_mobile_proprietaire'))
                    <br>
                    <div class="alert alert-warning ">
                       <strong>{{$errors->first('telephone_mobile_proprietaire')}}</strong> 
                    </div>
                    @endif     
                 </div>
            </div>

            <div class="form-group div_personne_tout">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_fixe">Téléphone fixe </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('telephone_fixe_proprietaire')}}" id="telephone_fixe" name="telephone_fixe_proprietaire"  >
                   @if ($errors->has('telephone_fixe_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('telephone_fixe_proprietaire')}}</strong> 
                   </div>
                   @endif     
                </div>

            </div>
             
                           
             <div class="form-group div_personne_morale ">
                <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_siret">Numéro siret</label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" id="numero_siret" class="form-control " value="{{old('numero_siret_proprietaire')}}" name="numero_siret_proprietaire" >
                   @if ($errors->has('telephone_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>{{$errors->first('telephone_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
             <div class="form-group div_personne_morale ">
                <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_tva">Numéro TVA</label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" id="numero_tva" class="form-control " value="{{old('numero_tva_proprietaire')}}" name="numero_tva_proprietaire" >
                   @if ($errors->has('numero_tva_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>{{$errors->first('numero_tva_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
             </div>
              
             
             
         </div>
     </div>
     
     <div class="col-md-12 col-lg-12 col-sm-12 " style="background:#175081; color:white!important; padding:10px ">
        <strong>Informations complémentaires (utiles pour générer des documents et des statistiques)  </strong>                  
     </div>
       
     <br>
     <br>
     <br>
       
     <div class="row">
        
       
        <div class="col-lg-6 col-md-6 col-sm-6">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse_proprietaire">Adresse </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control " value="{{old('adresse_proprietaire')}}" id="adresse_proprietaire" name="adresse_proprietaire"  >
                   @if ($errors->has('adresse_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('adresse_proprietaire')}}</strong> 
                   </div>
                   @endif   
                </div>
             </div>

           

             <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal_proprietaire">Code postal </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control" value="{{old('code_postal_proprietaire')}}" id="code_postal_proprietaire"  name="code_postal_proprietaire"  >
                   @if ($errors->has('code_postal_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('code_postal_proprietaire')}}</strong> 
                   </div>
                   @endif 
                </div>
             </div>

             <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ville_proprietaire">Ville </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control" value="{{old('ville_proprietaire')}}" id="ville_proprietaire" name="ville_proprietaire"  >
                   @if ($errors->has('ville_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('ville_proprietaire')}}</strong> 
                   </div>
                   @endif 
                </div>
             </div>
             
             <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="pays_proprietaire">Pays </label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                   <input type="text" class="form-control {{ $errors->has('pays_proprietaire') ? ' is-invalid' : '' }}" value="{{old('pays_proprietaire')}}" id="pays_proprietaire" value="France" name="pays_proprietaire" placeholder="Entez une lettre et choisissez.." >
                   @if ($errors->has('pays_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('pays_proprietaire')}}</strong> 
                   </div>
                   @endif 
                </div>
             </div>


        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">

           
          
            
            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="note">Note</label>
                <div class="col-lg-8 col-md-8 col-sm-8">
                  <textarea name="note_proprietaire" id="note" class="form-control" cols="30" rows="5"> {{old('note_proprietaire')}}</textarea>
                   @if ($errors->has('note_proprietaire'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('note_proprietaire')}}</strong> 
                   </div>
                   @endif
                </div>
            </div>
            
            
        </div>
    </div>
    

</div>

























<br>
<hr>






<div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="media">
                    <div class="p-5 bg-dark media-left media-middle">
                        <i class="ti-info-alt f-s-28 color-white"></i>
                    </div>
                    <div class="p-10 media-body">
                        <h4 class="color-dark m-r-10">@lang('Mandat du bien') </h4>
                        
                        <div class="progress progress-sm m-t-10 m-b-0">
                            <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>


        
    <div class="row">
        <div class="col-md-6 col-lg-6">
        
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero_mandat">Numéro Mandat </label>
                <div class="col-lg-6 col-md-6 col-sm-6">
                   <input type="text" class="form-control" value="{{old('numero_mandat')}}" id="numero_mandat" name="numero_mandat"  >
                   @if ($errors->has('numero_mandat'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('numero_mandat')}}</strong> 
                   </div>
                   @endif 
                </div>
            </div>
                            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="taxe_habitation_info_fin">type </label>
                <div class="col-lg-6 col-md-6">                
                    <select name="type_mandat" id="type_mandat" class="form-control " required >
                        <option value=""></option>
                        <option value="Simple">Simple</option>
                        <option value="Exclusif">Exclusif</option>
                        <option value="Exclusif">Semi-Exclusif</option>
                    </select>                    
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="tacite_reconduction_mandat">Tacite reconduction </label>
                <div class="col-lg-6 col-md-6">                
                    <select name="tacite_reconduction_mandat" id="tacite_reconduction_mandat" class="form-control " required >
                       
                            <option value="0">Sans tacite reconduction</option>
                            <option value="1">1 mois</option>
                            <option value="2">2 mois</option>
                            <option value="3">3 mois</option>
                            <option value="4">4 mois</option>
                            <option value="5">5 mois</option>
                            <option value="6">6 mois</option>
                            <option value="7">7 mois</option>
                            <option value="8">8 mois</option>
                            <option value="9">9 mois</option>
                            <option value="10">10 mois</option>
                            <option value="11">11 mois</option>
                            <option value="12">12 mois</option>
                            <option value="13">13 mois</option>
                            <option value="14">14 mois</option>
                            <option value="15">15 mois</option>
                            <option value="16">16 mois</option>
                            <option value="17">17 mois</option>
                            <option value="18">18 mois</option>
                            <option value="19">19 mois</option>
                            <option value="20">20 mois</option>
                            <option value="21">21 mois</option>
                            <option value="22">22 mois</option>
                            <option value="23">23 mois</option>
                            <option value="24">24 mois</option>
                            <option value="36">36 mois</option>
                            <option value="48">48 mois</option>
                            <option value="120">10 ans</option>
                            <option value="360">30 ans</option>
                            <option value="1188">99 ans</option>
                  
                    </select>                    
                </div>
            </div>
            

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="note_mandat">Note </label>
                <div class="col-lg-6 col-md-6">
                    <textarea name="note_mandat" class="form-control " id="note_mandat" cols="30" rows="10"></textarea>
                </div>
            </div>

          
       

        </div>

        <div class="col-md-6 col-lg-6">


            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_debut_mandat">Date de début </label>
                <div class="col-lg-6 col-md-6 col-sm-6">
                   <input type="date" class="form-control" value="{{old('date_debut_mandat')}}" id="date_debut_mandat" name="date_debut_mandat"  >
                   @if ($errors->has('date_debut_mandat'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('date_debut_mandat')}}</strong> 
                   </div>
                   @endif 
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_fin_mandat">Date de fin </label>
                <div class="col-lg-6 col-md-6 col-sm-6">
                   <input type="date" class="form-control" value="{{old('date_fin_mandat')}}" id="date_fin_mandat" name="date_fin_mandat"  >
                   @if ($errors->has('date_fin_mandat'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('date_fin_mandat')}}</strong> 
                   </div>
                   @endif 
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="duree_irrevocabilite_mandat">Durée irrévocabilité </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text"  class="form-control " id="duree_irrevocabilite_mandat" name="duree_irrevocabilite_mandat" > 
                   
                </div>
            </div>

        </div>
    </div> 
     




































<br>
<hr>






<div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="media">
                    <div class="p-5 bg-dark media-left media-middle">
                        <i class="ti-info-alt f-s-28 color-white"></i>
                    </div>
                    <div class="p-10 media-body">
                        <h4 class="color-dark m-r-10">@lang('Informations financières ') </h4>
                        
                        <div class="progress progress-sm m-t-10 m-b-0">
                            <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            {{-- VENTE --}}
            <div class=" row div_prix_vente" >
                <label class="col-lg-2 col-md-2 col-form-label" for="prix_net_info_fin">@lang('Prix') </label>
                <div class="col-lg-10 col-md-10">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_net_info_fin">@lang('Prix net vendeur (€)') <span class="text-danger">*</span> </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" required min="0" class="form-control " id="prix_net_info_fin" name="prix_net_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_info_fin">@lang('Public (€)') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" required class="form-control "  id="prix_public_info_fin" name="prix_public_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
      
                    <div class="row">
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_acquereur_info_fin">@lang('Honoraires charge Acquéreur') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_acquereur_info_fin_non" name="honoraire_acquereur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_acquereur_info_fin_oui"  name="honoraire_acquereur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_honoraire_acquereur_info_fin">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_acquereur_info_fin">@lang('Part Acquéreur (TTC) €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_acquereur_info_fin" name="part_acquereur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_prix_info_fin">@lang('Taux Prix Public %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="taux_prix_info_fin" name="taux_prix_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div> 
                    </div>

                    <div class="row">
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_vendeur_info_fin">@lang('Honoraires charge Vendeur') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_vendeur_info_fin_non" name="honoraire_vendeur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_vendeur_info_fin_oui" name="honoraire_vendeur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_honoraire_vendeur_info_fin">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_vendeur_info_fin">@lang('Part Vendeur (TTC) €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_vendeur_info_fin" name="part_vendeur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_net_info_fin">@lang('Taux Net Vendeur %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0"  class="form-control "  id="taux_net_info_fin" name="taux_net_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div>  
                    </div>

                </div>
            </div>
          {{-- LOCATION --}}
          <div class="div_prix_location">                        
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="loyer">@lang('Loyer (€)') <span class="text-danger">*</span> </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" required min="0" class="form-control " id="loyer" name="loyer" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="complement_loyer">@lang('Complément Loyer €') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" required class="form-control "  id="complement_loyer" name="complement_loyer" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
      
                    <div class="row"  >
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_acquereur_info_fin">@lang('Part Locataire') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_acquereur_info_fin_non" name="honoraire_acquereur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_acquereur_info_fin_oui"  name="honoraire_acquereur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_part_locataire">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_acquereur_info_fin">@lang('Montant €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_acquereur_info_fin" name="part_acquereur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_prix_info_fin">@lang('Pourcentage %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="taux_prix_info_fin" name="taux_prix_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div> 
                    </div>

                    <div class="row" >
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_vendeur_info_fin">@lang('Part Propriétaire') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_vendeur_info_fin_non" name="honoraire_vendeur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_vendeur_info_fin_oui" name="honoraire_vendeur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_part_proprietaire">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_vendeur_info_fin">@lang('Montant €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_vendeur_info_fin" name="part_vendeur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_net_info_fin">@lang('Pourcentage %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0"  class="form-control "  id="taux_net_info_fin" name="taux_net_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div>  
                    </div>

                </div>
            </div>
    </div>
    <br>
    <hr>
        
    <div class="row">
        <div class="col-md-6 col-lg-6">

                            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="estimation_valeur_info_fin">@lang('Estimation') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="estimation_valeur_info_fin">@lang('Valeur') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('estimation_valeur_info_fin')}}" id="estimation_valeur_info_fin" name="estimation_valeur_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="estimation_date_info_fin">@lang('date') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="date"  class="form-control "  id="estimation_date_info_fin" name="estimation_date_info_fin" placeholder="" > 
                            </div>
                        </div>                                    
                    </div>                    
                    <hr>

                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="viager_valeur_info_fin">@lang('Viager') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="viager_valeur_info_fin">@lang('Prix du bouquet') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('viager_valeur_info_fin')}}" id="viager_valeur_info_fin" name="viager_valeur_info_fin"  > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="viager_rente_mensuelle_info_fin">@lang('Rente Mensuelle') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('viager_rente_mensuelle_info_fin')}}" id="viager_rente_mensuelle_info_fin" name="viager_rente_mensuelle_info_fin" > 
                            </div>
                        </div>                                    
                    </div>                    
                    <hr>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="travaux_a_prevoir_info_fin">@lang('Travaux à prévoir') </label>
                <div class="col-lg-6 col-md-6">
                <input type="text"  class="form-control " id="travaux_a_prevoir_info_fin" name="travaux_a_prevoir_info_fin"  > 
                    
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="depot_garanti_info_fin">@lang('Dépôt de garantie') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="depot_garanti_info_fin" name="depot_garanti_info_fin" placeholder="@lang('€')" > 
                   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="taxe_habitation_info_fin">@lang('Taxe d\'habitation') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="taxe_habitation_info_fin" name="taxe_habitation_info_fin" placeholder="@lang('€')" > 
                    
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Taxe foncière') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin" placeholder="@lang('€')" > 
                    
                </div>
            </div>

        </div>

        <div class="col-md-6 col-lg-6">

            <div class="row div_prix_vente">
                    <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Charges Mensuelles')  </label>
                    <div class="col-lg-6 col-md-6">
                                                      
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                                <div class="col-lg-8 col-md-8">
                                    <textarea class="form-control"  name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin" cols="30" rows="3" ></textarea>
                                </div>
                            </div>                                    
                        </div>
                        <hr>
                    </div>
            </div>

            <div class="row div_prix_location">
                    <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Charges Locatives')  </label>
                    <div class="col-lg-6 col-md-6">                                                      
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                                <div class="col-lg-6 col-md-6">
                                    <textarea class="form-control"  name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin" cols="30" rows="3" ></textarea>
                                </div>
                            </div>                                    
                        </div>
                        <hr>
                    </div>
                   
                  
                    <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Durée du bail (mois)')  </label>
                        <div class="col-lg-8 col-md-8">
                            <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="mois" > 
                        </div>
                    </div>
                    
            </div>

        </div>
    </div> 
     
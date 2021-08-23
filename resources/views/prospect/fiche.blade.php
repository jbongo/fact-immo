<!DOCTYPE html>
<html>
  <head>
    <title>Fiche Info</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <style>
      html, body {
      min-height: 100%;
      }
      body, div, form, input, select, textarea, p { 
      padding: 0;
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #666;
      line-height: 22px;
      }
      h1 {
      position: absolute;
      margin: 0;
      font-size: 32px;
      color: #fff;
      z-index: 2;
      }
      .testbox {
      display: flex;
      justify-content: center;
      align-items: center;
      height: inherit;
      padding: 20px;
      }
      form {
      width: 100%;
      padding: 20px 200px 20px 200px;
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 0 230px 0 #4282bf; 
      }
      .banner {
      /* position: relative; */
      height: 210px;
      /* background-image: url("/images/fiche_info2.jpg");   */
      background-size: cover;
  
    
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #0aa0d9; 
      
      text-align: center;
      }
      
      .banner > img {
        z-index:1;
      }
      .banner::after {
      content: "";
      /* position: absolute; */
      width: 100%;
      height: 100%;
      }
      p.top-info {
      margin: 10px 0;
      }
      input, select, textarea {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      }
      input {
      /* width: calc(100% - 10px); */
      padding: 5px;
      }
      select {
      width: 100%;
      padding: 7px 0;
      background: transparent;
      }
      textarea {
      width: calc(100% - 12px);
      padding: 5px;
      }
      .item:hover p, .item:hover i, .question:hover p, .question label:hover, input:hover::placeholder {
      color: #8ebf42;
      }
      .item input:hover, .item select:hover, .item textarea:hover {
      border: 1px solid transparent;
      box-shadow: 0 0 8px 0 #223646;
      color: #8ebf42;
      }
      .item {
      position: relative;
      margin: 10px 0;
      }
      input[type="date"]::-webkit-inner-spin-button {
      display: none;
      }
      .item i, input[type="date"]::-webkit-calendar-picker-indicator {
      position: absolute;
      font-size: 20px;
      color: #a9a9a9;
      }
      .item i {
      right: 2%;
      top: 30px;
      z-index: 1;
      }
      [type="date"]::-webkit-calendar-picker-indicator {
      right: 1%;
      z-index: 2;
      opacity: 0;
      cursor: pointer;
      }
      /* input[type=radio] {
      width: 0;
      visibility: hidden;
      } */
      /* label.radio {
      position: relative;
      display: inline-block;
      margin: 5px 20px 25px 0;
      cursor: pointer;
      }
      .question span {
      margin-left: 30px;
      }
      label.radio:before {
      content: "";
      position: absolute;
      left: 0;
      width: 17px;
      height: 17px;
      border-radius: 50%;
      border: 2px solid #8ebf42;
      } */
      /* label.radio:after {
      content: "";
      position: absolute;
      width: 8px;
      height: 4px;
      top: 6px;
      left: 5px;
      background: transparent;
      border: 3px solid #8ebf42;
      border-top: none;
      border-right: none;
      transform: rotate(-45deg);
      opacity: 0;
      } */
      /* input[type=radio]:checked + label:after {
      opacity: 1;
      } */
      .btn-block {
      margin-top: 10px;
      text-align: center;
      }
      button {
      width: 150px;
      padding: 10px;
      border: none;
      border-radius: 5px; 
      background: #223646;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      }
      button:hover {
      background: #0aa0d9;
      }
      @media (min-width: 568px) {
      .name-item, .city-item {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      }
      .name-item input, .city-item input {
      width: calc(50% - 20px);
      }
      .city-item select {
      width: calc(50% - 8px);
      }
      }
    </style>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
  
  
  
  
  
  
  
  <body>
    <div class="testbox">
    <form action="{{route('prospect.sauvegarder_fiche', Crypt::encrypt($prospect->id))}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="banner">
        
        <img src="{{asset('/images/logo.jpg')}}" width="400px" alt="">
          <h1>Fiche Info</h1>
        </div>
        <br>
        @if (session('ok'))
          <div class="alert alert-success ">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
          </div>
        @endif       
       <br>
       
       @if($prospect->commentaire_pro != null )
       <span> <strong>Commentaire:  </strong> {{$prospect->commentaire_pro}}</span>
       <br><br>
       @endif
       
       <h3>Madame, Monsieur</h3>
       
       <h5>Une petite démarche administrative avant de rentrer dans le vif du sujet. <br>
       Merci de nous retourner les éléments suivants:
       </h5>
       
       <hr style="border-top: 4px solid #3e3a92">
       <br>
       
        <br>
        <div class="form-row item">
            <div class="form-group col-3">
              <label for="civilite">Civilité <span>*</span> </label>
              <select name="civilite" id="civilite" required>
              @if($prospect->civilite != null)
              <option value="{{$prospect->civilite}}" >{{$prospect->civilite}}</option>
              @endif
              <option value="M">M</option>
              <option value="Mme">Mme</option>
              </select>
            </div>
            
            @if ($errors->has('civilite'))
               <br>
               <div class="alert alert-warning ">
                  <strong>{{$errors->first('civilite')}}</strong> 
               </div>
             @endif
           
        </div>
        
        
    
        
        
        
        <div class="form-row item">
            <div class="form-group col-md-6">
              <label for="nom">Nom de naissance <span>*</span></label>
              <input type="text" name="nom" value="{{old('nom') ? old('nom') : $prospect->nom}}" required class="form-control" id="nom" placeholder="">
                @if ($errors->has('nom'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nom')}}</strong> 
                   </div>
                 @endif
            </div>
            <div class="form-group col-md-6">
              <label for="nom_usage">Nom d'usage</label>
              <input type="text" name="nom_usage" value="{{old('nom_usage') ? old('nom_usage') : $prospect->nom_usage}}"  class="form-control" id="nom_usage" placeholder="">
                @if ($errors->has('nom_usage'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('nom_usage')}}</strong> 
                   </div>
                 @endif
            </div>
        </div>
        
        <div class="form-row item">
            <div class="form-group col-md-12">
              <label for="prenom">Prénom <span>*</span></label>
              <input type="text" name="prenom" value="{{old('prenom') ? old('prenom') : $prospect->prenom}}" required class="form-control" id="prenom" placeholder="">
                @if ($errors->has('prenom'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('prenom')}}</strong> 
                   </div>
                 @endif
            </div>
            
        </div>
        <br>
        {{-- <hr style="border-top: 4px solid #3e3a92"> --}}
        <br>
        
        
        <div class="form-row item">
            <div class="form-group col-md-12">
              <label for="adresse">Adresse <span>*</span></label>
              <input type="text" name="adresse" value="{{old('adresse') ? old('adresse') : $prospect->adresse}}" required class="form-control" id="adresse" placeholder="">
                @if ($errors->has('adresse'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('adresse')}}</strong> 
                   </div>
                 @endif
            </div>
            
        </div>
        
        <div class="form-row item">
            <div class="form-group col-md-6">
              <label for="code_postal">Code Postal <span>*</span></label>
              <input type="text" name="code_postal" value="{{old('code_postal') ? old('code_postal') : $prospect->code_postal}}" required class="form-control" id="code_postal" placeholder="">
                @if ($errors->has('code_postal'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('code_postal')}}</strong> 
                   </div>
                 @endif
            </div>
            <div class="form-group col-md-6">
              <label for="ville">Ville <span>*</span></label>
              <input type="text" name="ville" value="{{old('ville') ? old('ville') : $prospect->ville}}" required class="form-control" id="ville" placeholder="" >
                @if ($errors->has('ville'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('ville')}}</strong> 
                   </div>
                 @endif
            </div>
        </div>
        
        <div class="form-row item">
            <div class="form-group col-md-6">
              <label for="telephone_fixe">Téléphone Fixe (personnel)</label>
              <input type="text" name="telephone_fixe"  value="{{old('telephone_fixe') ? old('telephone_fixe') : $prospect->telephone_fixe}}" class="form-control" id="telephone_fixe" placeholder="">
                @if ($errors->has('telephone_fixe'))
                   <br>
                   <div class="alert alert-warning ">
                      <strong>{{$errors->first('telephone_fixe')}}</strong> 
                   </div>
                 @endif
            </div>
            <div class="form-group col-md-6">
              <label for="telephone_portable">Téléphone portable (personnel/professionnel) <span>*</span> </label>
              <input type="text" name="telephone_portable"  value="{{old('telephone_portable') ? old('telephone_portable') : $prospect->telephone_portable}}" class="form-control" id="telephone_portable" placeholder="" required>
                @if ($errors->has('telephone_portable'))
                  <br>
                  <div class="alert alert-warning ">
                     <strong>{{$errors->first('telephone_portable')}}</strong> 
                  </div>
                @endif
            </div>
        </div>
        
        
        
        
        
        <div class="form-row item">
            <div class="form-group col-md-12">
              <label for="email">Email (personnel) <span>*</span></label>
              <input type="email" name="email"  value="{{old('email') ? old('email') : $prospect->email}}" class="form-control" id="email" reqired    >
              @if ($errors->has('email'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('email')}}</strong> 
                 </div>
               @endif
            </div>
        </div>
        
     
        <div class="form-row ">
            <div class="form-group col-md-6">
              <label for="date_naissance">Date de naissance <span>*</span></label>
              <input type="date" name="date_naissance"  value="{{old('date_naissance') ? old('date_naissance') : $prospect->date_naissance}}" class="form-control" id="date_naissance" placeholder    ="" required>
              @if ($errors->has('date_naissance'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('date_naissance')}}</strong> 
                 </div>
               @endif
            </div>
            <div class="form-group col-md-6">
              <label for="lieu_naissance">Lieu de naissance <span>*</span> </label>
              <input type="text" name="lieu_naissance"  value="{{old('lieu_naissance') ? old('lieu_naissance') : $prospect->lieu_naissance}}" class="form-control" id="lieu_naissance" placeholder    ="" required>
              @if ($errors->has('lieu_naissance'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('lieu_naissance')}}</strong> 
                 </div>
               @endif
            </div>
        </div>
        
        <div class="form-row item">
            <div class="form-group col-md-6">
              <label for="situation_familliale">Situation familliale <span>*</span> </label>
              <select name="situation_familliale"  class="form-control"  id="situation_familliale">
              
              @if($prospect->situation_familliale != null)
              <option value="{{$prospect->situation_familliale}}" >{{$prospect->situation_familliale}}</option>
              @endif
              
              <option value="marié">marié</option>
              <option value="pacsé">pacsé</option>
              <option value="divorcé">divorcé</option>
              <option value="séparé">séparé</option>
              <option value="célibataire">célibataire</option>
              <option value="veuf">veuf</option>
            
              </select>
                            
            </div>
            <div class="form-group col-md-6">
              <label for="nationalite">Nationalité <span>*</span> </label>
              <input type="text" name="nationalite"  value="{{old('nationalite') ? old('nationalite') : $prospect->nationalite}}" class="form-control" id="nationalite" placeholder   ="" required>
              @if ($errors->has('nationalite'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('nationalite')}}</strong> 
                 </div>
               @endif
            </div>
        </div>
        
        
       <br>
       <br>
       <h3>Infos nécessaires pour l'inscription à la CCI</h3>
       
       <hr style="border-top: 4px solid #3e3a92">
       <br>
       
       <br>
       
       <div class="form-row item">
        <div class="form-group col-md-6">
          <label for="nom_pere">Nom et prénom(s) du père <span>*</span> </label>
          <input type="text" name="nom_pere"  value="{{old('nom_pere') ? old('nom_pere') : $prospect->nom_pere}}" class="form-control" id="nom_pere" placeholder=""  required>
              @if ($errors->has('nom_pere'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('nom_pere')}}</strong> 
                 </div>
               @endif
        </div>
        <div class="form-group col-md-6">
          <label for="nom_mere">Nom (de jeune fille) et prénom(s) de la mère <span>*</span> </label>
          <input type="text" name="nom_mere"  value="{{old('nom_mere') ? old('nom_mere') : $prospect->nom_mere}}" class="form-control" id="nom_mere" placeholder="" required>
              @if ($errors->has('nom_mere'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('nom_mere')}}</strong> 
                 </div>
               @endif
        </div>
      </div>
      
      
      <div class="form-row item">
        <div class="form-group col-md-6">
          <div class="question">
            <p>Statut souhaité:<span>*</span></p> 
            <div class="question-answer">
              <input type="radio" value="auto-entrepreneur" @if($prospect->statut_souhaite == "auto-entrepreneur") checked @endif  id="radio_1" name="statut_souhaite"  required/>
              <label for="radio_1" class="radio"><span>Auto-entrepreneur</span></label>
              
              <input type="radio" value="portage-salarial" @if($prospect->statut_souhaite == "portage-salarial") checked @endif  id="radio_2" name="statut_souhaite" />
              <label for="radio_2" class="radio"><span>Portage salarial</span></label>
              
              <input type="radio" value="independant" @if($prospect->statut_souhaite == "independant") checked @endif  id="radio_4" name="statut_souhaite" />
              <label for="radio_4" class="radio"><span>Indépendant</span></label>
              
              <input type="radio" value="Autre" @if($prospect->statut_souhaite == "Autre") checked @endif  id="radio_3" name="statut_souhaite" />
              <label for="radio_3" class="radio"><span>Autre</span></label>
            </div>
          </div>
        </div>
       
      </div>
      
      
   
     
      
       
      
      

     <br><br>
        <div class="form-row item">
          <div class="form-group col-md-6">
            <label for="numero_rsac">Numéro R.S.A.C</label>
            <input type="text" name="numero_rsac"  value="{{old('numero_rsac') ? old('numero_rsac') : $prospect->numero_rsac}}" class="form-control" id="numero_rsac" placeholder="">
                @if ($errors->has('numero_rsac'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('numero_rsac')}}</strong> 
                 </div>
               @endif
          </div>
          <div class="form-group col-md-6">
            <label for="numero_siret">Numéro de SIRET</label>
            <input type="text" name="numero_siret"  value="{{old('numero_siret') ? old('numero_siret') : $prospect->numero_siret}}" class="form-control" id="numero_siret" placeholder="">
                @if ($errors->has('numero_siret'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('numero_siret')}}</strong> 
                 </div>
               @endif
          </div>
        </div>
      
      
        <div class="form-row item">
          <div class="form-group col-md-6">
            <label for="code_postaux">Codes postaux (plus précis que le département) que vous souhaitez utiliser sur votre zone d'action (séparez les codes postaux par une virgule)</label>
          <textarea name="code_postaux" class="form-control" id="code_postaux" cols="30" rows="10">{{old('code_postaux') ? old('code_postaux') : $prospect->code_postaux}}</textarea>
          </div>
         
        </div>
        
        
        <br><br>
        <div class="form-row item">
          <div class="form-group col-md-6">
            <label for="piece_identite">Carte d'identité scannée recto verso</label>
            @if($prospect->piece_identite != null)
            <a class="btn btn-warning color-info" title="Télécharger la pièce d'identité' "  href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"piece_identite"])}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger <i class="ti-download"></i> </a>
         @endif
            <input type="file" name="piece_identite" class="form-control" id="piece_identite" placeholder="" accept=".pdf, image/png, image/jpeg">
             @if ($errors->has('piece_identite'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('piece_identite')}}</strong> 
                 </div>
               @endif
          </div>
          <div class="form-group col-md-6">
            <label for="rib">Le RIB que vous utiliserez pour votre activité</label>
            @if($prospect->rib != null)
              <a class="btn btn-warning color-info" title="Télécharger le rib' "  href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"rib"])}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger <i class="ti-download"></i> </a>
           @endif
            <input type="file" name="rib" class="form-control" id="rib" placeholder="" accept=".pdf,image/png, image/jpeg">
             @if ($errors->has('rib'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('rib')}}</strong> 
                 </div>
               @endif
          </div>
          
         
        </div>
        
        <br>
        <div class="form-row item">
        
          <div class="form-group col-md-6">
            <label for="attestation_responsabilite">Attestation responsabilité civile</label>
            @if($prospect->attestation_responsabilite != null)
              <a class="btn btn-warning color-info" title="Télécharger l'Attestation responsabilité civile' "  href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"attestation_responsabilite"])}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger <i class="ti-download"></i> </a>
            @endif
            <input type="file" name="attestation_responsabilite" class="form-control" id="attestation_responsabilite" placeholder="" accept=".pdf, image/png, image/jpeg">
                @if ($errors->has('attestation_responsabilite'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('attestation_responsabilite')}}</strong> 
                 </div>
                @endif
          
          </div>
          
          <div class="form-group col-md-6">
            <label for="photo">Photo professionnelle </label>
            @if($prospect->photo != null)
              <a class="btn btn-warning color-info" title="Télécharger la photo' "  href="{{route('prospect.telecharger',[ Crypt::encrypt($prospect->id),"photo"])}}"  class="  m-b-10 m-l-5 " id="ajouter">Télécharger <i class="ti-download"></i> </a>
            @endif
            <input type="file" name="photo" class="form-control" id="photo" placeholder="" accept="image/png, image/jpeg">
             @if ($errors->has('photo'))
                 <br>
                 <div class="alert alert-warning ">
                    <strong>{{$errors->first('photo')}}</strong> 
                 </div>
               @endif
         
          </div>
        </div>
        
        
        <br><br>
        
        <div class="btn-block">
          <button type="submit" >Valider</button>
        </div>
      </form>
    </div>
    
    
  
    
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

 
@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'une affaire
@endsection
<div class="row">
	<div class="col-lg-12">
		@if (session('ok'))
		<div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> {{ session('ok') }}</strong>
		</div>
		@endif
		<div class="card">
			<div class="col-lg-10">
			</div>
			<div class="card-body">
                <form class="form-valide3" enctype="multipart/form-data" action="{{ route('compromis.add') }}" method="post">
                    {{ csrf_field() }}
                    <div class="panel-body">
                    

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                @if ($errors->has('numero_mandat'))
                                <br>
                                    <div class="alert alert-warning " style="color:black">
                                        <strong>{{$errors->first('numero_mandat')}}, vérifiez vos affaires en cours ou archivées.</strong> 
                                    </div>
                                @endif
        
                            </div>
                        </div>

                        <fieldset class="col-md-12">
                            <legend>Infos Partage</legend>
                            <div class="panel panel-warning">
                                <div class="panel-body">                      
    
                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">                                                
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="partage">Partage avec Agence/Agent ? <span class="text-danger">*</span></label>
                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                    <select class="js-select2 form-control" id="partage" name="partage" required>
                                                        <option value="Non">Non</option>
                                                        <option value="Oui">Oui</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4" id="div_hors_reseau">
                                            <div class="form-group row" >                                                
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="hors_reseau">Agence/Agent réseau ? <span class="text-danger">*</span></label>
                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                    <select class="js-select2 form-control" id="hors_reseau" name="hors_reseau" required>
                                                        <option value="Non">Oui</option>
                                                        <option value="Oui">Non</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4" id="div_agent_reseau">
                                            <div class="form-group row" >
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="agent_id">Choisir agent / agence <span class="text-danger">*</span> </label>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <select class="selectpicker " id="agent_id" name="agent_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                        @foreach ($agents as $agent )
                                                            <option value="{{ $agent->id }}" data-tokens="{{ $agent->nom }} {{ $agent->prenom }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group div_agent_hors_reseau" >
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="nom_agent">Nom de l'agence <span class="text-danger">*</span></label>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                
                                                    <input class="form-control" type="text" value="{{old('nom_agent') ? old('nom_agent') : " " }}" id="nom_agent" name="nom_agent" required >
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group" id="div_pourcentage_agent">
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="pourcentage_agent">Mon % de partage <span class="text-danger">*</span></label>
                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                    <input class="form-control" type="number" min="0" max="100" value="{{old('pourcentage_agent') ? old('pourcentage_agent') : 0}}" id="pourcentage_agent" name="pourcentage_agent" required>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-lg-4 col-md-4 col-sm-4" id="div_je_porte_affaire">
                                            <div class="form-group row">
                                                <label class="col-lg-7 col-md-7 col-sm-7" for="je_porte_affaire">Je porte l'affaire</label> 
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <input type="checkbox" checked data-toggle="toggle" id="je_porte_affaire" name="je_porte_affaire" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>
                                            <div class="alert alert-success" style="color:red;" id="div_partage_non_porte_alert">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Info !</strong> L'affaire sera renseignée par <label id="label_partage_name"> </label>.
                                            </div>
                                            <div class="alert alert-success" style="color:red;" id="div_partage_porte_alert">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Info !</strong> Si vous portez l'affaire, c'est vous qui ferez la demande de facture STYL'IMMO .
                                            </div>
                                        </div>
                                       
                                       <div class="div_agence_externe1">
                                    
                                       
                                       </div>
                                        
                                        
                                        
                                        
                                        <div class="col-lg-4 col-md-4 col-sm-4" id="div_mandat_partage">
                                            
                                        </div>

                                        
                                    </div>
                                    
                                    
                                    <div class="row div_agence_externe2">

                                      

                                    </div>


                                        
                                </div>
                            </div>
                        </fieldset>
                    </div>				
                    <br>

                    <div id="div_total">


                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group ">
                                    
                                    <label class="col-lg-7 col-md-7 col-sm-7" for="type_affaire">Type d'affaire <span class="text-danger">*</span></label>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <select class="js-select2 form-control" id="type_affaire" name="type_affaire" required>
                                            <option value="Vente">Vente</option>
                                            <option value="Location">Location</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                           
                        
                        </div>
<br>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group ">
                                    <label class=" col-lg-7 col-md-7 col-sm-7 " for="description_bien">Description du bien<span class="text-danger">*</span></label>
                                    <div class=" col-lg-12 col-md-12 col-sm-12 ">
                                        <textarea class="form-control" maxlength="180" name="description_bien" id="description_bien" cols="50" rows="5" required>{{old('description_bien')}}</textarea>
                                        <span id="rchars" style="color:#2805B8">180</span> <span style="color:#2805B8"> Caractères restants </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group ">
                                    <label class="col-lg-7 col-md-7 col-sm-7 " for="code_postal_bien">Code postal du bien <span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                                        <input class="form-control" type="text" value="{{old('code_postal_bien')}}" id="code_postal_bien" name="code_postal_bien" required >                                        
                                    </div>
                                </div>                
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group ">
                                    <label class="col-lg-7 col-md-7 col-sm-7 " for="ville_bien">Ville du bien <span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                                        <input class="form-control" type="text" value="{{old('ville_bien')}}" id="ville_bien" name="ville_bien" required >                                        
                                    </div>
                                </div>                
                            </div>
                        </div>
                    <br>

                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Infos Propriétaire / Vendeur</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">
                                                
                                                    <label class="col-lg-12 col-md-12 col-sm-12 col-form-label" for="civilite_vendeur">Civilité / Forme Juridique<span class="text-danger">*</span></label>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 ">
                                                        <select class="js-select2 form-control" id="civilite_vendeur" name="civilite_vendeur" >
                                                            <option value="M.">M.</option>
                                                            <option value="Mme">Mme</option>
                                                            <option value="MM.">MM.</option>
                                                            <option value="Mmes">Mmes</option>
                                                            <option value="M. et Mme">M. et Mme</option>
                                                            <option value="MM. et Mmes">MM. et Mmes</option>
                                                            <option value="M. & M.">M. & M.</option>
                                                            <option value="Mme & Mme">Mme & Mme</option>
                                                            <option value="Indivision">Indivision</option>
                                                            <option value="Consorts">Consorts</option>
                                                            <option value="SCI">SCI</option>
                                                            <option value="SARL">SARL</option>
                                                            <option value="EURL">EURL</option>
                                                            <option value="EI">EI</option>
                                                            <option value="SCP">SCP</option>
                                                            <option value="SA">SA</option>
                                                            <option value="SAS">SAS</option>
                                                            <option value="SNC">SNC</option>
                                                            <option value="EARL">EARL</option>
                                                            <option value="EIRL">EIRL</option>
                                                            <option value="GIE">GIE</option>
                                                            <option value="Autre">Autre</option>
                                                        </select>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group" id="div_nom_vendeur"> {{old('nom_vendeur')}}
                                                <label for="nom_vendeur">Nom(s) <span class="text-danger">*</span> <span style="color:red; font-size:12px">indiquer la raison sociale ou les noms et prénoms de tous les vendeurs (ex : Dupond Jean, Tamar Sarah)</span> </label>
                                                <input class="form-control" type="text"  value="{{old('nom_vendeur') ? old('nom_vendeur') : " "}}" id="nom_vendeur" name="nom_vendeur" required  >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse1_vendeur">Adresse </label>
                                                    <input class="form-control" type="text" value="{{old('adresse1_vendeur')}}" id="adresse1_vendeur" name="adresse1_vendeur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse2">Complément d'adresse </label>
                                                    <input class="form-control" type="text" value="{{old('adresse2_vendeur')}}" id="adresse2_vendeur" name="adresse2_vendeur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="code_postal_vendeur">Code Postal </label>
                                                    <input class="form-control" type="text" value="{{old('code_postal_vendeur')}}" id="code_postal_vendeur" name="code_postal_vendeur" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville_vendeur">Ville </label>
                                                    <input class="form-control" type="text" value="{{old('ville_vendeur')}}" id="ville_vendeur" name="ville_vendeur" >
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
                        <legend>Infos Locataire / Acquéreur</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">
                                                
                                                <label class="col-lg-12 col-md-12 col-sm-12 col-form-label" for="civilite_acquereur">Civilité / Forme Juridique <span class="text-danger">*</span></label>
                                                <div class="col-lg-8 col-md-8 col-sm-8 ">
                                                    <select class="js-select2 form-control" id="civilite_acquereur" name="civilite_acquereur" >
                                                            <option value="M.">M.</option>
                                                            <option value="Mme">Mme</option>
                                                            <option value="MM.">MM.</option>
                                                            <option value="Mmes">Mmes</option>
                                                            <option value="M. et Mme">M. et Mme</option>
                                                            <option value="MM. et Mmes">MM. et Mmes</option>
                                                            <option value="M. & M.">M. & M.</option>
                                                            <option value="Mme & Mme">Mme & Mme</option>
                                                            <option value="Indivision">Indivision</option>
                                                            <option value="Consorts">Consorts</option>
                                                            <option value="SCI">SCI</option>
                                                            <option value="SARL">SARL</option>
                                                            <option value="EURL">EURL</option>
                                                            <option value="EI">EI</option>
                                                            <option value="SCP">SCP</option>
                                                            <option value="SA">SA</option>
                                                            <option value="SAS">SAS</option>
                                                            <option value="SNC">SNC</option>
                                                            <option value="EARL">EARL</option>
                                                            <option value="EIRL">EIRL</option>
                                                            <option value="GIE">GIE</option>
                                                            <option value="Autre">Autre</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group" id="div_nom_acquereur">
                                                <label for="nom_acquereur" >Nom(s) <span class="text-danger">*</span><span style="color:red; font-size:12px">indiquer la raison sociale ou les noms et prénoms de tous les acquéreurs (ex : Dupond Jean, Tamar Sarah)</label>
                                                <input class="form-control" type="text" value="{{old('nom_acquereur') ? old('nom_acquereur') : " "}}" id="nom_acquereur" name="nom_acquereur" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse1_acquereur">Adresse </label>
                                                    <input class="form-control" type="text" value="{{old('adresse1_acquereur')}}" id="adresse1_acquereur" name="adresse1_acquereur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse2_acquereur">Complément d'adresse </label>
                                                    <input class="form-control" type="text" value="{{old('adresse2_acquereur')}}" id="adresse2_acquereur" name="adresse2_acquereur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="code_postal_acquereur">Code Postal </label>
                                                    <input class="form-control" type="text" value="{{old('code_postal_acquereur')}}" id="code_postal_acquereur" name="code_postal_acquereur" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville_acquereur">Ville </label>
                                                    <input class="form-control" type="text" value="{{old('ville_acquereur')}}" id="ville_acquereur" name="ville_acquereur" >
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
                        <legend>Infos Mandat</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4" >
                                            <div id="div_numero_mandat">

                                                <div class="form-group">
                                                    <label for="numero_mandat">Numéro Mandat <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" min="10000" max="99999" value="{{old('numero_mandat')}}" id="numero_mandat" name="numero_mandat" required>
                                                </div>
                                                @if ($errors->has('numero_mandat'))
                                                    <br>
                                                    <div class="alert alert-warning " style="color:black">
                                                        <strong>{{$errors->first('numero_mandat')}}, vérifiez vos affaires en cours ou archivées.</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="date_mandat">Date mandat <span class="text-danger">*</span> </label>
                                                <input class="form-control" type="date" value="{{old('date_mandat')}}" id="date_mandat" name="date_mandat" required >
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
                        <legend>Autres Infos</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row">                                                
                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="charge">Charge vendeur/Acquereur <span class="text-danger">*</span></label>
                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                    <select class="js-select2 form-control" id="charge" name="charge" required>
                                                        <option value="Vendeur">Vendeur</option>
                                                        <option value="Acquéreur">Acquéreur</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4" id="div_net_vendeur">
                                            <div class="form-group">
                                                <label for="net_vendeur">Net Vendeur TTC<span class="text-danger">*</span></label>
                                                <input class="form-control" min="0" step="0.1" type="number" value="{{old('net_vendeur')}}" id="net_vendeur" name="net_vendeur" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="frais_agence">Frais d'agence TTC <span class="text-danger">*</span> </label>
                                                <input class="form-control" min="0" step="0.1" type="number" value="{{old('frais_agence')}}" id="frais_agence" name="frais_agence" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                           <div class="form-group">
                                               <label for="scp_notaire">SCP Notaire <span class="text-danger">*</span> </label>
                                               <input class="form-control" type="texte" value="{{old('scp_notaire')}}" id="scp_notaire" name="scp_notaire" required>
                                           </div>
                                       </div>
                                       
                                       <div class="col-lg-4 col-md-4 col-sm-4">
                                           <div class="form-group">
                                               <label for="date_vente">Date provisoire de la Vente / Date entrée logement <span class="text-danger">*</span> </label>
                                               <input class="form-control" type="date" value="" id="date_vente" name="date_vente"  required>
                                           </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="date_signature">Date de signature du compromis / Bail  </label>
                                                <input class="form-control" type="date" value="" id="date_signature" name="date_signature"  >
                                                <div id="label_pdf_compromis" class="alert alert-warning" style="color: #1e003c;" role="alert">Le champs Date de signature du compromis devient obligatoire quand vous renseignez le fichier (compromis signé) </div>

                                            </div>
                                        </div>

                                   </div>

                                    <div class="row">
                                 
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group ">
                                                    <label class=" col-lg-7 col-md-7 col-sm-7 " for="observations">Observations </span></label>
                                                    <div class=" col-lg-12 col-md-12 col-sm-12 ">
                                                        <textarea class="form-control"  name="observations" id="observations" cols="50" rows="5" ></textarea>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="pdf_compromis">Fichier pdf du compromis / contrat de bail </label>
                                                    <input class="form-control" accept=".pdf" type="file" value="" id="pdf_compromis" name="pdf_compromis"  >
                                                    <div id="" class="alert alert-info" style="color: #1e003c;" role="alert"> Pour que l'affaire passe sous compromis, il rajouter le fichier. Ajouter le fichier 10 jours max après la signature </div>
                                                </div>
                                            </div>

                                    </div>

                                    
                                    
                            </div>
                        </div>
                    </fieldset>
                </div>				
                <br>

            </div>
            
			<div class="form-validation">				
                <div class="form-group row" style="text-align: center; margin-top: 50px;">
                    <div class="col-lg-8 ml-auto">
                        <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 " id="enregistrer"><i class="ti-file"></i>Enregistrer</button>
                    </div>
                </div>				
            </div>
            
        </form>
		</div>
	</div>
</div>
</div>
@stop
@section('js-content')

{{-- enregistrement charge / adresse obligatoire --}}

<script>
    $('#adresse1_vendeur').attr('required', 'required');
    $('#code_postal_vendeur').attr('required', 'required');
    $('#ville_vendeur').attr('required', 'required');
    
    $('#charge').on('change',function(){

      if($('#charge').val() == "Vendeur"){

            $('#adresse1_vendeur').attr('required', 'required');
            $('#code_postal_vendeur').attr('required', 'required');
            $('#ville_vendeur').attr('required', 'required');

            $('#adresse1_acquereur').removeAttr('required');
            $('#code_postal_acquereur').removeAttr('required');
            $('#ville_acquereur').removeAttr('required');

            swal("L'adresse du vendeur est obligatoire");


      }else{
            $('#adresse1_acquereur').attr('required', 'required');
            $('#code_postal_acquereur').attr('required', 'required');
            $('#ville_acquereur').attr('required', 'required');

            $('#adresse1_vendeur').removeAttr('required');
            $('#code_postal_vendeur').removeAttr('required');
            $('#ville_vendeur').removeAttr('required');

            swal("L'adresse de l'acquéreur est obligatoire");

      }
        
    });

</script>
<script>

  // Acquereur Vendeur
// $('#div_raison_sociale_vendeur').hide();
// $('#div_raison_sociale_acquereur').hide();
$('#div_mandat_partage').hide();
$('#div_partage_non_porte_alert').hide();

// $('#civilite_vendeur').change(function(){
//     if($('#civilite_vendeur').val() =="M." || $('#civilite_vendeur').val() =="Mme"){
//         $('#div_raison_sociale_vendeur').hide();
//         $('#div_nom_vendeur').show();
//         $('#div_prenom_vendeur').show();

//     }else{

//         $('#div_nom_vendeur').hide();
//         $('#div_prenom_vendeur').hide();
//         $('#div_raison_sociale_vendeur').show();
//     }

// });
// $('#civilite_acquereur').change(function(){
//     if($('#civilite_acquereur').val() =="M." || $('#civilite_acquereur').val() =="Mme"){
//         $('#div_raison_sociale_acquereur').hide();
//         $('#div_nom_acquereur').show();
//         $('#div_prenom_acquereur').show();

//     }else{

//         $('#div_nom_acquereur').hide();
//         $('#div_prenom_acquereur').hide();
//         $('#div_raison_sociale_acquereur').show();
//     }

// });

// Fin acquereur vendeur

//######Info partage 

$('#div_hors_reseau').hide();
$('#div_agent_reseau').hide();
$('.div_agent_hors_reseau').hide();
$('#div_pourcentage_agent').hide();
$('#div_je_porte_affaire').hide();

// lorsqu'on partage l'affaire
$("#partage").change(function(){
    if($('#partage').val() == "Oui"){
        $('#div_je_porte_affaire').show();
        $('#div_hors_reseau').show();
        $('#div_agent_reseau').show();
        $('#div_pourcentage_agent').show();
        

    }else{
        $('#div_je_porte_affaire').hide();

        $('#div_hors_reseau').hide();
        $('#div_agent_reseau').hide();
        $('.div_agent_hors_reseau').hide();
        $('#div_pourcentage_agent').hide();
        $('#div_total').show();

        $('#sous_div_mandat_partage').remove();
        $('#div_mandat_partage').hide();

        $('.sous_div_agence_externe1').remove();
        $('.sous_div_agence_externe2').remove();
    }
});

// lorsqu'on porte l'affaire

$('#je_porte_affaire').change(function(){
   if( $('#je_porte_affaire').is(':checked') ){
        //$('#div_agent_reseau').show();
        //$('#div_pourcentage_agent').show();
      //  $('#div_hors_reseau').show();
        $('#div_total').show();
        $('#sous_div_mandat_partage').remove();
        $('#div_mandat_partage').hide();

        $('#div_partage_non_porte_alert').hide();
        $('#div_partage_porte_alert').show();

   }else{
       /* $('#div_hors_reseau').hide();
        $('.div_agent_hors_reseau').hide();

        $('#div_agent_reseau').hide();
        $('#div_pourcentage_agent').hide();*/
        $('#div_partage_non_porte_alert').show();
        $('#div_partage_porte_alert').hide();
        if($('#hors_reseau').val() == "Oui"){
            $('#label_partage_name').html($('#nom_agent').val());

        }else{
            $('#label_partage_name').html($("#agent_id").children("option:selected").data('tokens'));

        }
        
        $('#div_mandat_partage').html(`
        <div id="sous_div_mandat_partage">                        
            
            <div class="form-group">
                <label class="col-lg-8 col-md-8 col-sm-8"  for="numero_mandat_porte_pas">Numéro Mandat <span class="text-danger">*</span></label>
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <input class="form-control" type="number" min="10000" max="99999" value="{{old('numero_mandat_porte_pas')}}" id="numero_mandat_porte_pas" name="numero_mandat_porte_pas" required>
                </div>
            </div>
            @if ($errors->has('numero_mandat_porte_pas'))
                <br>
                <div class="alert alert-warning ">
                    <strong>{{$errors->first('numero_mandat_porte_pas')}}</strong> 
                </div>
            @endif
        </div>
        `);
        $('#div_mandat_partage').show();
        $('#sous_div_mandat_partage').show();

        $('#div_total').hide();


   }
});

$("#agent_id").change(function(){
        
    $('#label_partage_name').html($("#agent_id").children("option:selected").data('tokens'));
})

$("#hors_reseau").change(function(){
    // Si l'affaire est partagée en interne
    if($('#hors_reseau').val() == "Non"){
        $('.div_agent_hors_reseau').hide();
        $('#div_agent_reseau').show();
        $('#label_partage_name').html($("#agent_id").children("option:selected").data('tokens'));

        $('.sous_div_agence_externe1').remove();
        $('.sous_div_agence_externe2').remove();
        
    // Si l'affaire est partagée avec une agence externe
    }else{
        $('.div_agent_hors_reseau').show();
        $('#div_agent_reseau').hide();
        $('#div_je_porte_affaire').hide();
        
        $('#label_partage_name').html($('#nom_agent').val());
        
        
        $('.div_agence_externe1').html(`
        
            <div class="col-lg-4 col-md-4 col-sm-4 sous_div_agence_externe1" >
                <div class="form-group row  div_agent_hors_reseau" >                                                
                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="qui_porte_externe">Qui porte l'affaire chez le notaire ? <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-md-8 col-sm-8 ">
                        <select class="js-select2 form-control" id="qui_porte_externe" name="qui_porte_externe" required>
                            <option value="1">STYL'IMMO et L'Agence</option>
                            <option value="2">L'Agence</option>
                            <option value="3">STYL'IMMO</option>
                        </select>
                    </div>                                                
                </div>
            </div>
     
        `);
        
        $('.div_agence_externe2').html(`
             


        <div class="col-lg-3 col-md-3 col-sm-3 sous_div_agence_externe2">                                            
                <div class="form-group div_agent_hors_reseau">
                    <label for="adresse_agence">Adresse du siège de l'agence <span class="text-danger">*</span> </label>
                    <input class="form-control" type="text" value="{{old('adresse_agence')}}" id="adresse_agence" required name="adresse_agence" >
                </div>                                            
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 sous_div_agence_externe2">                                            
                <div class="form-group div_agent_hors_reseau">
                    <label for="code_postal_agence">Code Postal de l'agence <span class="text-danger">*</span> </label>
                    <input class="form-control" type="text" value="{{old('code_postal_agence')}}" id="code_postal_agence" required name="code_postal_agence" >
                </div>                                            
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 sous_div_agence_externe2">                                            
                <div class="form-group div_agent_hors_reseau">
                    <label for="ville_acquereur">Ville de l'agence <span class="text-danger">*</span> </label>
                    <input class="form-control" type="text" value="{{old('ville_agence')}}" id="ville_agence" required name="ville_agence" >
                </div>                                            
        </div>
 
    `);
    
        
        
        

    }
});

//fin info partage


// gestion d'erreur pour champs requis


$('#je_porte_affaire').change(function(){
    if( $('#je_porte_affaire').is(':checked') ){
      
              
        $('#div_numero_mandat').html(`
        
            <div class="form-group">
                <label for="numero_mandat">Numéro Mandat <span class="text-danger">*</span></label>
                <input class="form-control" type="number" min="10000" max="99999" value="{{old('numero_mandat')}}" id="numero_mandat" name="numero_mandat" required>
            </div>
            @if ($errors->has('numero_mandat'))
                <br>
                <div class="alert alert-warning ">
                    <strong>{{$errors->first('numero_mandat')}}</strong> 
                </div>
            @endif
     
        `);
       
    }else{
 
        $('#description_bien').val(" ");
        $('#civilite_vendeur').val(" ");
        $('#civilite_acquereur').val(" ");
        $('#numero_mandat').remove();
        $('#date_mandat').val("2000-01-01");
        $('#net_vendeur').val(0)
        $('#frais_agence').val(0)
        $('#scp_notaire').val(" ");
        $('#ville_bien').val(" ");
    }
 });



</script>

<script>
        // $('#nom_vendeur').keyup(function(){
        //        $(this).val($(this).val().toUpperCase());
        // });
        $('#ville_vendeur').keyup(function(){
               $(this).val($(this).val().toUpperCase());
        });
       
        $('#nom_vendeur').on('focusout',function(){
             //   $(this).val( $(this).val().chartAt(0).toUpperCase());
             var nom = $(this).val(); 
             tab  = nom.split(" ");
             var noms = "";
             tab.forEach(element => {
       
                first = ""+element.substring(0,1);
                first=first.toUpperCase();
       
                second = element.substring(1,);
       
                noms+= first+second+" ";
             });
             $(this).val(noms);
             // console.log(tab);
             
        });


        // $('#nom_acquereur').keyup(function(){
        //        $(this).val($(this).val().toUpperCase());
        // });
        $('#ville_acquereur').keyup(function(){
               $(this).val($(this).val().toUpperCase());
        });
        $('#scp_notaire').keyup(function(){
               $(this).val($(this).val().toUpperCase());
        });
        
        $('#nom_acquereur').on('focusout',function(){
             //   $(this).val( $(this).val().chartAt(0).toUpperCase());
             var nom = $(this).val(); 
             tab  = nom.split(" ");
             var noms = "";
             tab.forEach(element => {
       
                first = ""+element.substring(0,1);
                first=first.toUpperCase();
       
                second = element.substring(1,);
       
                noms+= first+second+" ";
             });
             $(this).val(noms);
             // console.log(tab);
             
        });


        $('#nom_agent').keyup(function(){
               $(this).val($(this).val().toUpperCase());
        });
       
        $('#ville_bien').keyup(function(){
               $(this).val($(this).val().toUpperCase());
        });
       </script>

       {{-- Limite pour le textarea --}}

       <script>
       var maxLength = 180;
            $('textarea').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
            });
       </script>

{{-- SELON QU'on choisisse vente ou location --}}

<script>
$('#type_affaire').on('change',function(){


    if($('#type_affaire').val() == "Location"){

        $('#div_net_vendeur').hide();
        $('#net_vendeur').val(0);

    }else{
        $('#div_net_vendeur').show();
    }
})
</script>
{{-- Si le compromis signé est renseigné, rendrre la date de signature obligatoire --}}


<script>
    $('#label_pdf_compromis').hide();
 $("#pdf_compromis").change(function(e){
        if(e.target.value != ""){
            $('#date_signature').attr("required","required");
            $('#label_pdf_compromis').slideDown();
        }else{
            $('#date_signature').removeAttr("required");
            $('#label_pdf_compromis').slideUp();
        }
    });

</script>

@endsection
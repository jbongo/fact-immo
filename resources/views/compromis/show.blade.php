@extends('layouts.app')
@section('content')
@section ('page_title')
Détail de l'affaire @if(auth::user()->role =="admin") de {{$compromis->user->nom}} {{$compromis->user->prenom}} @endif
@endsection
<style>

.form-control{
    color: slategray;
}
</style>
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
                @if ($compromis->demande_facture == 0 && (  ($compromis->est_partage_agent == 1 && $compromis->je_porte_affaire == 1) ||  ($compromis->est_partage_agent == 0) )  )
                    @if($compromis->user_id == Auth::user()->id ||  auth::user()->role =="admin" )
                        <a class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" href="{{route('facture.demander_facture', Crypt::encrypt($compromis->id) )}}"><i class="ti-file"></i>Demander Facture stylimmo</a>
                    @endif
                @endif
                @if ($compromis->demande_facture < 2 ||  auth::user()->role =="admin" )
                    @if($compromis->user_id == Auth::user()->id ||  auth::user()->role =="admin" )
                        <a class="btn btn-success btn-flat btn-addon btn-sm m-b-10 m-l-5  " id="modifier_compromis"><i class="ti-pencil-alt"></i>Modifier l'affaire</a>
                    @endif
                @endif
            
            </div>

            <br><br><hr>
			<div class="card-body">
                
                <form class="form-valide3" action="{{ route('compromis.update',$compromis->id) }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <fieldset class="col-md-12">
                                <legend>Infos Partage</legend>
                                <div class="panel panel-warning">
                                    <div class="panel-body">                      
        
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="form-group row" id="parrain-id">
                                                        <label class="col-lg-8 col-form-label" for="parr-id">Partage avec agence /agent ?</label>
                                                        <input type="hidden" name="partage" value="{{ $compromis->est_partage_agent == 0 ? "Non":"Oui"}}">
                                                        <div class="col-lg-8">
                                                            {{-- <select class="col-lg-6 form-control" id="parr-id" name="partage"  >
                                                                <option value="{{ $compromis->est_partage_agent == 0 ? "Non":"Oui"}}">{{ $compromis->est_partage_agent == 0 ? "Non":"Oui"}}</option>
                                                                <option  value="Non" >Non</option>
                                                                <option  value="Oui" >Oui</option>
                                                            </select> --}}
                                                                
                                                                <span style="color:slategray">{{ $compromis->est_partage_agent == 0 ? "Non":"Oui"}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            
                                                @if ($compromis->est_partage_agent == 1)
                                                    
                                                
                                                <div id="div_partage_agent_oui">
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <div class="form-group row" id="div_hors_reseau">                                                
                                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="hors_reseau">Agence/Agent réseau ? <span class="text-danger">*</span></label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                                    {{-- <select class="js-select2 form-control" id="hors_reseau" name="hors_reseau" required>
                                                                        <option value="{{$compromis->partage_reseau ==  true ? "Oui" : "Non"}}">{{$compromis->partage_reseau ==  true ? "Oui" : "Non"}}</option>
                                                                        <option value="Non">Oui</option>
                                                                        <option value="Oui">Non</option>
                                                                    </select> --}}
                                                                <span style="color:slategray">{{$compromis->partage_reseau ==  true ? "Oui" : "Non"}}</span>

                                                                </div>                                                
                                                            </div>
                                                        </div>
                                                        @if ($compromis->partage_reseau == true && $compromis->agent_id !=null )
                                                            
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <div class="form-group row" id="div_agent_reseau">
                                                                <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="agent_id">Choisir agent / agence <span class="text-danger">*</span> </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <select class="selectpicker " id="agent_id" name="agent_id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                                        <option value="{{ $agence->id }}" data-tokens="{{ $agence->nom }} {{ $agence->prenom }}">{{ $agence->nom }} {{ $agence->prenom }}</option>                                                                    
                                                                        @foreach ($agents as $agent )
                                                                            <option value="{{ $agent->id }}" data-tokens="{{ $agent->nom }} {{ $agent->prenom }}">{{ $agent->nom }} {{ $agent->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @else 

                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <div class="form-group" id="div_agent_hors_reseau">
                                                                <label for="nom_agent">Nom Agence/Agent <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" value="{{old('nom_agent') ? old('nom_agent') : $compromis->nom_agent }}" id="nom_agent" name="nom_agent" required >
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                                <div class="form-group" id="div_pourcentage_agent">
                                                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="pourcentage_agent">Mon % de partage <span class="text-danger">*</span></label>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                                        <input class="form-control" type="number" min="0" max="100" value="{{old('pourcentage_agent') ? old('pourcentage_agent') : $compromis->pourcentage_agent}}" id="pourcentage_agent" name="pourcentage_agent" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                    
                                                            
                                                            <div class="col-lg-4 col-md-4 col-sm-4" id="div_je_porte_affaire">
                                                                <div class="form-group row">
                                                                    {{-- @php
                                                                    if ($compromis->je_porte_affaire == 1){
                                                                        $check = "checked" ;         
                                                                     } 
                                                                     else{
                                                                        $check = "unchecked" ;   
                                                                        }
                                                                    @endphp --}}
                                                                    <label class="col-lg-7 col-md-7 col-sm-7" for="je_porte_affaire">Je porte l'affaire</label> 
                                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                                        <input type="hidden" id="je_porte_affaire" name="je_porte_affaire" value="{{$compromis->je_porte_affaire ==  true ? "Oui" : "Non"}}">
                                                                        <span style="color:slategray">{{$compromis->je_porte_affaire ==  true ? "Oui" : "Non"}}</span>
                                                                    
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 col-sm-4" id="div_mandat_partage">
                                                                @if ($compromis->je_porte_affaire == 0)
                                                                    <div class="form-group">
                                                                        <label class="col-lg-8 col-md-8 col-sm-8" for="numero_mandat_porte_pas">Numéro Mandat <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                                            <input class="form-control" type="text" value="{{old('numero_mandat_porte_pas') ? old('numero_mandat_porte_pas') : $compromis->numero_mandat_porte_pas }}" id="numero_mandat_porte_pas" name="numero_mandat_porte_pas" required>
                                                                        </div>
                                                                    </div>
                                                                    @if ($errors->has('numero_mandat_porte_pas'))
                                                                        <br>
                                                                        <div class="alert alert-warning ">
                                                                            <strong>{{$errors->first('numero_mandat_porte_pas')}}</strong> 
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                    
    
                                                        </div>
            
                                                        
                                                   
{{-- xxxxxxxxxxxxxxxxxxxxxxxx --}}

                                                @endif
    
                                                
                                            </div>
        
                                            
                                    </div>
                                </div>
                            </fieldset>
                        </div>   
                    @if ($compromis->je_porte_affaire == 1)

                        <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group ">
                                        
                                        <label class="col-lg-7 col-md-7 col-sm-7" for="type_affaire">Type d'affaire <span class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <select class="js-select2 form-control" id="type_affaire" name="type_affaire" required>
                                                {{-- <option value="{{$compromis->type_affaire }}">{{$compromis->type_affaire }}</option> --}}
                                                @if($compromis->type_affaire == "Vente")
                                                <option value="Vente">Vente</option>
                                                <option value="Location">Location</option>
                                                @else 
                                                <option value="Location">Location</option>
                                                <option value="Vente">Vente</option>
                                                @endif
                                                
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
                                            <textarea class="form-control" maxlength="180" name="description_bien" id="description_bien" cols="50" rows="5" required>{{ $compromis->description_bien }}</textarea>
                                            <span id="rchars" style="color:#2805B8">180</span> <span style="color:#2805B8"> Caractères restants </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group ">
                                        <label class="col-lg-7 col-md-7 col-sm-7 " for="code_postal_bien">Code postal du bien  <span class="text-danger">*</span></label>
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                                            <input class="form-control" type="text" value="{{$compromis->code_postal_bien}}" id="code_postal_bien" name="code_postal_bien" required >                                        
                                        </div>
                                    </div>                
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group ">
                                        <label class="col-lg-7 col-md-7 col-sm-7 " for="ville_bien">Ville du bien <span class="text-danger">*</span></label>
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                                            <input class="form-control" type="text" style='color=#FFFF00' value="{{ $compromis->ville_bien }}" id="ville_bien" name="ville_bien" required >                                        
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
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-12 col-md-12 col-sm-12col-form-label" for="civilite_vendeur">Civilité/Forme juridique</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <select class=" form-control" id="civilite_vendeur" name="civilite_vendeur"  >
                                                        <option value="{{ $compromis->civilite_vendeur}}">{{ $compromis->civilite_vendeur}}</option>
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
                                            <div class="form-group " id="parrain-id">
                                                <label for="nom_vendeur">Nom(s) <span class="text-danger">*</span> <span style="color:red; font-size:12px">indiquer la raison sociale ou les noms et prénoms de tous les vendeurs (ex : Dupond Jean, Tamar Sarah)</span> </label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="nom_vendeur" style='color=red'  value="{{ $compromis->nom_vendeur}} "name="nom_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                       
        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse1_vendeur">Adresse </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1_vendeur" value="{{ $compromis->adresse1_vendeur}} " name="adresse1_vendeur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse2_vendeur">Complément d'adresse</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2_vendeur" value="{{ $compromis->adresse2_vendeur}} " name="adresse2_vendeur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="code_postal_vendeur">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal_vendeur" value="{{ $compromis->code_postal_vendeur}} " name="code_postal_vendeur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="ville_vendeur">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville_vendeur" value="{{ $compromis->ville_vendeur}} "name="ville_vendeur" >                                                    
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
                        <legend>Infos Locataire / Acquéreur</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-12 col-md-12 col-sm-12 col-form-label" for="civilite_acquereur">Civilité</label>
                                                <div class="col-lg-8 col-md-8 col-sm-8 ">
                                                    <select class=" form-control" id="parr-id" name="civilite_acquereur"  >
                                                        <option value="{{ $compromis->civilite_acquereur}}">{{ $compromis->civilite_acquereur}}</option>                                                        
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
                                                        <option value="Autre">Autre</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group " id="parrain-id">
                                                <label for="nom_acquereur" >Nom(s) <span class="text-danger">*</span><span style="color:red; font-size:12px">indiquer la raison sociale ou les noms et prénoms de tous les acquéreurs (ex : Dupond Jean, Tamar Sarah)</label>
                                                <div class="">
                                                    <input type="text" class="form-control" id="nom_acquereur"  value="{{ $compromis->nom_acquereur}}"name="nom_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse1_acquereur">Adresse</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1_acquereur" value="{{ $compromis->adresse1_acquereur}}" name="adresse1_acquereur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse2_acquereur">Complément adresse</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2_acquereur" value="{{ $compromis->adresse2_acquereur}}" name="adresse2_acquereur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="code_postal_acquereur">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal_acquereur" value="{{ $compromis->code_postal_acquereur}}" name="code_postal_acquereur" >                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="ville_acquereur">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville_acquereur" value="{{ $compromis->ville_acquereur}}" name="ville_acquereur" >                                                    
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
                            <legend>Infos Mandat</legend>
                            <div class="panel panel-warning">
                                <div class="panel-body">                      
    
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="numero_mandat">Numéro Mandat</label>  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="number" min="10000" max="99999" class="form-control" id="numero_mandat" value="{{ $compromis->numero_mandat}}" name="numero_mandat" required>
                                                    </div>
                                                    @if ($errors->has('numero_mandat'))
                                                    <br>
                                                    <div class="alert alert-warning ">
                                                       <strong>{{$errors->first('numero_mandat')}}</strong> 
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="date_mandat">Date Mandat</label>  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" id="date_mandat" @if($compromis->date_mandat != null)  value="{{ $compromis->date_mandat->format('Y-m-d')}}" @endif name="date_mandat" required>                                                    
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
                            <legend>Autre Infos</legend>
                            <div class="panel panel-warning">
                                <div class="panel-body">                      
    
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="" for="parr-id">Net Vendeur</label>  <span class="text-danger">*</span></label>
                                                    
                                                        <input type="number" class="form-control" id="net_vendeur" name="net_vendeur" value="{{ $compromis->net_vendeur}}" required>                                                    
                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label for="frais_agence">Frais d'agence</label> <span class="text-danger">*</span></label>
                                                    <input class="form-control" min="0" type="number" value="{{ $compromis->frais_agence}}" id="frais_agence" name="frais_agence" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="" for="charge_qui">Charge </label>  <span class="text-danger">*</span></label>
                                                    <div >
                                                        <select class="col-lg-6 form-control" id="charge_qui" name="charge"  required>
                                                            @php
                                                                if ($compromis->charge == "Vendeur"){
                                                                    $premier = "Vendeur";
                                                                    $deuxieme = "Acquereur";
                                                                }
                                                                else{
                                                                    $premier = "Acquereur";
                                                                    $deuxieme = "Vendeur";
                                                                }
                                                            @endphp
                                                    
                                                            <option  value="{{$premier}}" >{{$premier}}</option>
                                                            <option  value="{{$deuxieme}}" >{{$deuxieme}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="" for="parr-id">SCP Notaire</label> <span class="text-danger">*</span></label>
                                                  
                                                        <input type="text" class="form-control" id="scp_notaire" name="scp_notaire" value="{{ $compromis->scp_notaire}}" required>                                                    
                                                    
                                                </div>
                                            </div>
                                            

                                            {{-- @if ($compromis->date_vente != null) --}}
                                                
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_vente">Date exacte Vente </label> <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" @if($compromis->date_vente != null)  value="{{ $compromis->date_vente->format('Y-m-d')}}" @endif id="date_vente" name="date_vente"  required>
                                                </div>
                                            </div>
                                            {{-- @endif                 --}}

                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label for="date_signature">Date de signature du compromis  </label>
                                                    <input class="form-control" type="date"  @if($compromis->date_signature != null)  value="{{ $compromis->date_signature->format('Y-m-d')}}" @endif id="date_signature" name="date_signature"  >
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group ">
                                                    <label class=" col-lg-7 col-md-7 col-sm-7 " for="observation">Observations </span></label>
                                                    <div class=" col-lg-12 col-md-12 col-sm-12 ">
                                                        <textarea class="form-control"  name="observation" id="observation" cols="50" rows="5" required>{{ $compromis->description_bien }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label >Fichier pdf du compromis </label>
                                                    <input class="form-control" type="file" value="" id="pdf_compromis" name="pdf_compromis"  >
                                                    @if($compromis->pdf_compromis != null)
                                                        <a class="btn btn-danger btn-sm" href="{{route('compromis.telecharger_pdf_compromis', $compromis->id)}}" id="telecharger_pdf_compromis">Télécharger</a>
                                                    
                                                        <a class="btn btn-success btn-sm" id="modifier_pdf_compromis">Modifier</a>
                                                    @endif
                                                    @if ($errors->has('pdf_compromis'))
                                                        <br>
                                                        <div class="alert alert-warning ">
                                                            <strong>{{$errors->first('pdf_compromis')}}</strong> 
                                                        </div>
                                                    @endif
                                                    <div id="label_pdf_compromis" class="alert alert-warning" style="color: #1e003c;" role="alert">Le champs Date de signature du compromis devient obligatoire quand vous renseignez le fichier (compromis signé) </div>

                                                </div>
                                            </div>

                                        </div>
    
                                </div>
                            </div>
                        </fieldset>
                    </div>
                @endif
                    <div class="form-validation">
                        <div class="form-group row" style="text-align: center; margin-top: 50px;">
                            <div class="col-lg-8 ml-auto">
                                <button class="btn btn-default btn-flat btn-addon btn-lg m-b-10 m-l-5 enregistrer" style="position: fixed;bottom: 10px; z-index:1 ;" ><i class="ti-save"></i>Sauvegarder</button>
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
$('input').attr('readonly',true);
$('textarea').attr('readonly',true);
$('select').attr('readonly',true);
$('.enregistrer').hide();

$('#modifier_compromis').click(function(){
    $('input').attr('readonly',false);
    $('textarea').attr('readonly',false);
    $('select').attr('readonly',false);
    $('#modifier_compromis').slideUp(1000);
    $('.enregistrer').show();

});

</script>


<script>

    
  // Acquereur Vendeur
// $('#div_raison_sociale_vendeur').hide();
// $('#div_raison_sociale_acquereur').hide();
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

/*$('#div_hors_reseau').hide();
$('#div_agent_reseau').hide();
$('#div_agent_hors_reseau').hide();
$('#div_pourcentage_agent').hide();
*/
$("#partage").change(function(){
    if($('#partage').val() == "Oui"){
        $('#div_hors_reseau').show();
        $('#div_agent_reseau').show();
        $('#div_pourcentage_agent').show();

    }else{
        $('#div_hors_reseau').hide();
        $('#div_agent_reseau').hide();
        $('#div_agent_hors_reseau').hide();
        $('#div_pourcentage_agent').hide();
    }
});

$("#hors_reseau").change(function(){
    if($('#hors_reseau').val() == "Non"){
        $('#div_agent_hors_reseau').show();
        $('#div_agent_reseau').hide();

    }else{
        $('#div_agent_hors_reseau').hide();
        $('#div_agent_reseau').show();

    }
});
//fin info partage
</script> 

     {{-- Limite pour le textarea --}}

<script>
var maxLength = 180;
        $('textarea').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
        });
</script>

{{-- BOUTON TELECHARGER COMPROMIS --}}
<script>
   

    var pdf_compromis = "{{ $compromis->pdf_compromis}}";
    console.log(pdf_compromis);
    
    if(pdf_compromis != ""){
        $('#pdf_compromis').hide();
    }

$('#modifier_pdf_compromis').click(function (){
    $('#pdf_compromis').show();
    $('#modifier_pdf_compromis').hide();
    $('#telecharger_pdf_compromis').hide();

});

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
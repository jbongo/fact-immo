@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'un compromis
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
                <form class="form-valide3" action="{{ route('compromis.add') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="description_bien">Description du bien<span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" name="description_bien" id="description_bien" cols="60" rows="5" required></textarea>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="ville_bien">Ville du bien <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text"  id="ville_bien" name="ville_bien" required >                                        
                                    </div>
                                </div>                
                            </div>
                        </div>


                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Infos propriétaire / Vendeur</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">
                                                
                                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="civilite_vendeur">Civilité <span class="text-danger">*</span></label>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                        <select class="js-select2 form-control" id="civilite_vendeur" name="civilite_vendeur" required>
                                                            <option ></option>
                                                            <option value="Mr">Mr</option>
                                                            <option value="Mme">Mme</option>
                                                        </select>
                                                    </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="nom_vendeur">Nom </label>
                                                <input class="form-control" type="text" value="" id="nom_vendeur" name="nom_vendeur" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="prenom_vendeur">Prénom(s) </label>
                                                <input class="form-control" type="text" value="" id="prenom_vendeur" name="prenom_vendeur" >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse1_vendeur">Adresse 1 </label>
                                                    <input class="form-control" type="text" value="" id="adresse1_vendeur" name="adresse1_vendeur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse2">Adresse 2 </label>
                                                    <input class="form-control" type="text" value="" id="adresse2_vendeur" name="adresse2_vendeur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="codepostal_vendeur">Code Postal </label>
                                                    <input class="form-control" type="text" value="" id="codepostal_vendeur" name="codepostal_vendeur" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville_vendeur">Ville </label>
                                                    <input class="form-control" type="text" value="" id="ville_vendeur" name="ville_vendeur" >
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
                                                
                                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="civilite_acquereur">Civilité <span class="text-danger">*</span></label>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                        <select class="js-select2 form-control" id="civilite_acquereur" name="civilite_acquereur" required>
                                                            <option ></option>
                                                            <option value="Mr">Mr</option>
                                                            <option value="Mme">Mme</option>
                                                        </select>
                                                    </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="nom_acquereur">Nom </label>
                                                <input class="form-control" type="text" value="" id="nom_acquereur" name="nom_acquereur" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="prenom_acquereur">Prénom(s) </label>
                                                <input class="form-control" type="text" value="" id="prenom_acquereur" name="prenom_acquereur" >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse1_acquereur">Adresse 1 </label>
                                                    <input class="form-control" type="text" value="" id="adresse1_acquereur" name="adresse1_acquereur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse2_acquereur">Adresse 2 </label>
                                                    <input class="form-control" type="text" value="" id="adresse2_acquereur" name="adresse2_acquereur" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="codepostal2_acquereur">Code Postal </label>
                                                    <input class="form-control" type="text" value="" id="codepostal2_acquereur" name="codepostal2_acquereur" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville2_acquereur">Ville </label>
                                                    <input class="form-control" type="text" value="" id="ville2_acquereur" name="ville2_acquereur" >
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

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="numero_mandat">Numéro Mandat </label>
                                                <input class="form-control" type="text" value="" id="numero_mandat" name="numero_mandat" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="date_mandat">Date mandat </label>
                                                <input class="form-control" type="date" value="" id="date_mandat" name="date_mandat" >
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
                        <legend>Infos Partage</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">
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

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="nom_agent">Nom Agence/Agent </label>
                                                <input class="form-control" type="text" value="" id="nom_agent" name="nom_agent" >
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="pourcentage">Son % </label>
                                                <input class="form-control" type="number" value="" id="pourcentage" name="pourcentage" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="montant_deduis">Montant Déduis Ht ou Net </label>
                                                <input class="form-control" type="number" value="" id="montant_deduis" name="montant_deduis" >
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

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="net_vendeur">Net Vendeur </label>
                                                <input class="form-control" type="number" value="" id="net_vendeur" name="net_vendeur" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="frais_agence">Frais d'agence</label>
                                                <input class="form-control" min="0" type="number" value="" id="frais_agence" name="frais_agence" >
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="scp_notaire">SCP Notaire </label>
                                                <input class="form-control" type="texte" value="" id="scp_notaire" name="scp_notaire" >
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
                        <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 "><i class="ti-file"></i>Enregistrer</button>
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


@endsection
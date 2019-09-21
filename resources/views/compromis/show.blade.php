@extends('layouts.app')
@section('content')
@section ('page_title')
Compromis
@endsection
<style>

.form-control{
    color: red;
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
                @if ($compromis->demande_facture == 0)
                    <a class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5 submit" href="{{route('facture.demander_facture', Crypt::encrypt($compromis->id) )}}"><i class="ti-file"></i>Demander Facture stylimmo</a>
                @endif
                @if ($compromis->demande_facture != 3)
                <a class="btn btn-success btn-flat btn-addon btn-sm m-b-10 m-l-5  " id="modifier_compromis"><i class="ti-pencil-alt"></i>Modifier le compromis</a>
                @endif
            
            </div>

            <br><br><hr>
			<div class="card-body">
                
                <form class="form-valide3" action="{{ route('compromis.update',$compromis->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="description_bien">Description du bien<span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control"  style='color=#FFFF00' name="description_bien" id="description_bien"  cols="60" rows="5" required>{{ $compromis->description_bien }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="ville_bien">Ville du bien <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input class="form-control"  style='color=#FFFF00' type="text" value="{{ $compromis->ville_bien }}"  id="ville_bien" name="ville_bien" required >                                        
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
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="civilite_vendeur">Civilité</label>
                                                <div class="col-lg-8">
                                                    <select class="col-lg-6 form-control" id="civilite_vendeur" name="civilite_vendeur"  >
                                                        <option value="{{ $compromis->civilite_vendeur}}">{{ $compromis->civilite_vendeur}}</option>
                                                        <option  value="Mr" >Mr</option>
                                                        <option  value="Mme" >Mme</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="nom_vendeur">Nom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_vendeur" style='color=red'  value="{{ $compromis->nom_vendeur}} "name="nom_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="prenom_vendeur">Prénom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="prenom_vendeur" value="{{ $compromis->prenom_vendeur}} " name="prenom_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse1_vendeur">Adresse 1</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1_vendeur" value="{{ $compromis->adresse1_vendeur}} " name="adresse1_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse2_vendeur">Adresse 2</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2_vendeur" value="{{ $compromis->adresse2_vendeur}} " name="adresse2_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="code_postal_vendeur">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal_vendeur" value="{{ $compromis->code_postal_vendeur}} " name="code_postal_vendeur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="ville_vendeur">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville_vendeur" value="{{ $compromis->ville_vendeur}} "name="ville_vendeur" required>                                                    
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
                        <legend>Infos Locataire / Acquereur</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">                      

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="civilite_acquereur">Civilité</label>
                                                <div class="col-lg-8">
                                                    <select class="col-lg-6 form-control" id="parr-id" name="civilite_acquereur"  >
                                                        <option value="{{ $compromis->civilite_acquereur}}">{{ $compromis->civilite_acquereur}}</option>                                                        
                                                        <option  value="Mr" >Mr</option>
                                                        <option  value="Mme" >Mme</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="nom_acquereur">Nom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_acquereur"  value="{{ $compromis->nom_acquereur}}"name="nom_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="prenom_acquereur">Prénom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="prenom_acquereur" value="{{ $compromis->prenom_acquereur}}" name="prenom_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse1_acquereur">Adresse 1</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1_acquereur" value="{{ $compromis->adresse1_acquereur}}" name="adresse1_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="adresse2_acquereur">Adresse 2</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2_acquereur" value="{{ $compromis->adresse2_acquereur}}" name="adresse2_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="code_postal_acquereur">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal_acquereur" value="{{ $compromis->code_postal_acquereur}}" name="code_postal_acquereur" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="ville_acquereur">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville_acquereur" value="{{ $compromis->ville_acquereur}}" name="ville_acquereur" required>                                                    
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
                                                    <label class="col-lg-8 col-form-label" for="numero_mandat">Numéro Mandat</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="numero_mandat" value="{{ $compromis->numero_mandat}}" name="numero_mandat" required>
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
                                                    <label class="col-lg-8 col-form-label" for="date_mandat">Date Mandat</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" id="date_mandat" value="{{ $compromis->date_mandat}}" name="date_mandat" required>                                                    
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
                            <legend>Infos   Partage</legend>
                            <div class="panel panel-warning">
                                <div class="panel-body">                      
    
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Partage avec agence /agent ?</label>
                                                    <div class="col-lg-8">
                                                        <select class="col-lg-6 form-control" id="parr-id" name="partage"  >
                                                            <option value="{{ $compromis->est_partage == 0 ? "Non":"Oui"}}">{{ $compromis->est_partage == 0 ? "Non":"Oui"}}</option>
                                                            <option  value="Non" >Non</option>
                                                            <option  value="Oui" >Oui</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="nom_agent"nom_agent>Nom Agence / Agence</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="nom_agent" name="nom_agent" value="{{ $compromis->nom_agent}}" >                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="pourcentage_agent">Son pourcentage</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" class="form-control" id="pourcentage_agent" name="pourcentage_agent" value="{{ $compromis->pourcentage_agent}}" >                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="montant_deduis">Montant Déduis Ht ou Net </label>
                                                    <input class="form-control" type="number" value="{{ $compromis->montant_deduis_net}}" id="montant_deduis" name="montant_deduis" >
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
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Net Vendeur</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" class="form-control" id="net_vendeur" name="net_vendeur" value="{{ $compromis->net_vendeur}}" required>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="frais_agence">Frais d'agence</label>
                                                    <input class="form-control" min="0" type="number" value="{{ $compromis->frais_agence}}" id="frais_agence" name="frais_agence" >
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="charge_qui">Charge </label>
                                                    <div class="col-lg-8">
                                                        <select class="col-lg-6 form-control" id="charge_qui" name="charge"  >
                                                            <option value="{{ $compromis->charge}}">{{ $compromis->charge}}</option>
                                                            <option  value="Vendeur" >Vendeur</option>
                                                            <option  value="Acquereur" >Acquereur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">SCP Notaire</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="scp_notaire" name="scp_notaire" value="{{ $compromis->scp_notaire}}">                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            @if ($compromis->date_vente != null)
                                                
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_vente">Date exacte Vente </label>
                                                    <input class="form-control" type="date" value="{{ $compromis->date_vente}}" id="date_vente" name="date_vente" >
                                                </div>
                                            </div>
                                            @endif                
            
                                        </div>
    
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-validation">
                        <div class="form-group row" style="text-align: center; margin-top: 50px;">
                            <div class="col-lg-8 ml-auto">
                                <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 enregistrer"><i class="ti-save"></i>Enregistrer</button>
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





@endsection
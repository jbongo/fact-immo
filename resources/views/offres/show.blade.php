@extends('layouts.app')
@section('content')
@section ('page_title')
Offre
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
                    <a class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5 submit"><i class="ti-file"></i>Demander Facture stylimmo</a>
                    <a class="btn btn-success btn-flat btn-addon btn-sm m-b-10 m-l-5 submit"><i class="ti-pencil-alt"></i>Modifier l'offre</a>
            </div>


            <br><br><hr>
			<div class="card-body">
                
                <form class="form-valide3" action="{{ route('offre.add') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-select">Type d'offre <span class="text-danger">*</span></label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <select class="js-select2 form-control {{$errors->has('val-lastname') ? 'is-invalid' : ''}}" id="val-select" name="val-select" style="width: 100%;" data-placeholder="Choose one.." required>
                                                <option ></option>
                                                <option value="independant">Vente</option>
                                                <option value="auto-entrepreneur">Location</option>
                                           </select>
                                           @if ($errors->has('val-select'))
                                           <br>
                                           <div class="alert alert-warning ">
                                              <strong>{{$errors->first('val-lastname')}}</strong> 
                                           </div>
                                           @endif
                                        </div>
                                </div>
                                                       
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="date-entree">Désignation<span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" name="" id="" cols="60" rows="5" required></textarea>
                                        
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
                                                <label class="col-lg-8 col-form-label" for="parr-id">Civilité</label>
                                                <div class="col-lg-8">
                                                    <select class="col-lg-6 form-control" id="parr-id" name="civilite"  >
                                                        <option  value="Mr" >Mr</option>
                                                        <option  value="Mme" >Mme</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Nom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Prénom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Adresse 1</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1" name="adresse1" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Adresse 2</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2" name="adresse2" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal" name="code_postal" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville" name="ville" required>                                                    
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
                                                <label class="col-lg-8 col-form-label" for="parr-id">Civilité</label>
                                                <div class="col-lg-8">
                                                    <select class="col-lg-6 form-control" id="parr-id" name="civilite"  >
                                                        <option  value="Mr" >Mr</option>
                                                        <option  value="Mme" >Mme</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Nom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Prénom</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Adresse 1</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse1" name="adresse1" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Adresse 2</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="adresse2" name="adresse2" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Code Postal</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="code_postal" name="code_postal" required>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-8 col-form-label" for="parr-id">Ville</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="ville" name="ville" required>                                                    
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
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Numéro Mandat</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Date Mandat</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
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
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Partage avec agence /agent ?</label>
                                                    <div class="col-lg-8">
                                                        <select class="col-lg-6 form-control" id="parr-id" name="partage"  >
                                                            <option  value="Non" >Non</option>
                                                            <option  value="Oui" >Oui</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Nom Agence / Agence</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Son pourcentage</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" class="form-control" id="nom_vend" name="nom_vend" required>                                                    
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
                                                    <label class="col-lg-8 col-form-label" for="parr-id">Net Vendeur</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" class="form-control" id="net_vendeur" name="net_vendeur" required>                                                    
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="charge_qui">Charge </label>
                                                    <div class="col-lg-8">
                                                        <select class="col-lg-6 form-control" id="charge_qui" name="charge_qui"  >
                                                            <option  value="Vendeur" >Vendeur</option>
                                                            <option  value="Acquereur" >Acquereur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="form-group row" id="parrain-id">
                                                    <label class="col-lg-8 col-form-label" for="parr-id">SCP Notaire</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="scp_notaire" name="scp_notaire" required>                                                    
                                                    </div>
                                                </div>
                                            </div>
            
                                        </div>
    
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-validation">
                        <div class="form-group row" style="text-align: center; margin-top: 50px;">
                            <div class="col-lg-8 ml-auto">
                                <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"><i class="ti-save"></i>Enregistrer</button>
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
</script>





@endsection
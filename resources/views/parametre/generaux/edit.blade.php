@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Paramètres généraux 
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

            <div class="card-body">

                <div class="panel-body"> <hr>
               
                    <fieldset class="col-md-12">
                        <legend>Infos de l'entreprise</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form class="form-valide3" action="{{ route('parametre_generaux.update') }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="raison_sociale">Raison sociale<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"  value="{{$parametre->raison_sociale}}" id="raison_sociale" name="raison_sociale" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_siret">Numéro SIRET<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="{{$parametre->numero_siret}}" id="numero_siret" name="numero_siret" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_rcs">Numéro RCS<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="{{$parametre->numero_rcs}}" id="numero_rcs" name="numero_rcs" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_tva">Numéro TVA<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="{{$parametre->numero_tva}}" id="numero_tva" name="numero_tva" required>
                                                </div>
                                            </div>
                                           

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="adresse">Adresse<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="{{$parametre->adresse}}" id="adresse" name="adresse" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="code_postal">Code postal<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" min="0" class="form-control" value="{{$parametre->code_postal}}" id="code_postal" name="code_postal" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="ville">Ville<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" min="0" class="form-control" value="{{$parametre->ville}}" id="ville" name="ville" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
<br>
<br>
                {{-- ####### INFO TVA #######--}}
                <div class="panel-body" >
                    <fieldset class="col-md-12">
                        <legend>Infos TVA</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="tva_actuelle">TVA actuelle<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control"  value="{{$parametre->tva->tva_actuelle}}" id="tva_actuelle" name="tva_actuelle" required>
                                                </div>
                                            </div>
                                           
                                            {{-- @if($parametre->tva->tva_prochaine == null) --}}
                                            <div class="form-group row" style="text-align: center;">
                                                <div class="col-lg-8 ml-auto"> 
                                                    <a style="background-color:#ffc107; color:white" class="btn  btn-flat btn-addon btn-sm m-b-10 m-l-5  " title="Ajouter la prochaine TVA"  id="add_tva"><i class="ti-plus"></i>Ajouter TVA</a>
                                                </div>
                                            </div>
                                            {{-- @endif --}}
                                            {{-- @if($parametre->tva->tva_prochaine != null) --}}
                                            <div class="form-group row" id="div_tva_prochaine">
                                                <label class="col-lg-4 col-form-label" for="tva_prochaine">Prochaine TVA </label>
                                                <div class="col-lg-4">
                                                    <input type="number" style="background-color:#f3f3f3" class="form-control"  value="{{$parametre->tva->tva_prochaine}}" id="tva_prochaine" name="tva_prochaine" >
                                                </div>
                                            </div>
                                            {{-- @endif --}}
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="ca_imposable">CA pour être imposable<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" value="{{$parametre->ca_imposable}}" id="ca_imposable" name="ca_imposable" required>
                                                </div>
                                            </div>
                                           

                                        </div>

                                        {{-- @if($parametre->tva->tva_prochaine != null) --}}

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_debut_tva_actuelle">Date début TVA actuelle <span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="{{$parametre->tva->date_debut_tva_actuelle->format('Y-m-d')}}" id="date_debut_tva_actuelle" name="date_debut_tva_actuelle" required>
                                                </div>
                                            </div>
                                            
                                         {{-- @endif   --}}
                                        </div>
                                       
                                        <div class="col-lg-6 col-md-6 col-sm-6" >
                                            <p> &nbsp;</p> 
                                            {{-- <p> &nbsp;</p>  --}}
                                        </div>
                                  
                                        <div class="col-lg-6 col-md-6 col-sm-6" id="div_date_tva_prochaine">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_debut_tva_prochaine">Date début prochaine TVA  </label>
                                                <div class="col-lg-4">
                                                    <input type="date" style="background-color:#f3f3f3" class="form-control" value="{{$parametre->tva->date_debut_tva_prochaine->format('Y-m-d')}}" id="date_debut_tva_prochaine" name="date_debut_tva_prochaine" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                <div>

               
                </div>
            </div>

            <div class="form-group row" style="text-align: center; margin-top: 50px;">
                <div class="col-lg-8 ml-auto">
                    <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5  " id="sauvegarder"><i class="ti-save"></i>Sauvegarder</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
@stop 
@section('js-content') 

<script>

$('#add_tva').hide();

if("{{$parametre->tva->tva_prochaine}}" == null){

    $('#div_date_tva_prochaine').hide();
    $('#div_tva_prochaine').hide();
    $('#add_tva').show();


    $('#add_tva').click(function(){
        $('#div_date_tva_prochaine').show();
        $('#div_tva_prochaine').show(); 
    
        $('#add_tva').hide();

    });
}
</script>
@endsection
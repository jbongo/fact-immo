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
                                <form class="form-valide3" action="{{ route('parametre_generaux.store') }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="raison_sociale">Raison sociale<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control"  value="" id="raison_sociale" name="raison_sociale" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_siret">Numéro SIRET<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="" id="numero_siret" name="numero_siret" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_rcs">Numéro RCS<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="" id="numero_rcs" name="numero_rcs" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="numero_tva">Numéro TVA<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="" id="numero_tva" name="numero_tva" required>
                                                </div>
                                            </div>
                                           

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="adresse">Adresse<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="code_postal">Code postal<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" min="0" class="form-control" value="" id="code_postal" name="code_postal" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="ville">Ville<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="text" min="0" class="form-control" value="" id="ville" name="ville" required>
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
                                                    <input type="number" class="form-control"  value="" id="tva_actuelle" name="tva_actuelle" required>
                                                </div>
                                            </div>
                                           

                                            {{-- <div class="form-group row" style="text-align: center;">
                                                <div class="col-lg-8 ml-auto"> 
                                                    <button style="background-color:#ffc107; color:white" class="btn  btn-flat btn-addon btn-sm m-b-10 m-l-5  " title="Ajouter la prochaine TVA"  id="add_tva"><i class="ti-plus"></i>Ajouter TVA</button>
                                                </div>
                                            </div> --}}
                                            @if(1==1)
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="tva_prochaine">Prochaine TVA <span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" style="background-color:#f3f3f3" class="form-control"  value="" id="tva_prochaine" name="tva_prochaine" required>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="ca_imposable">CA pour être imposable<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" value="" id="ca_imposable" name="ca_imposable" required>
                                                </div>
                                            </div>
                                           

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_debut_tva_actuelle">Date début TVA actuelle <span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" value="" id="date_debut_tva_actuelle" name="date_debut_tva_actuelle" required>
                                                </div>
                                            </div>
                                            
                                           
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <p> &nbsp;</p> 
                                            <p> &nbsp;</p> 
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_debut_tva_prochaine">Date début prochaine TVA  <span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" style="background-color:#f3f3f3" class="form-control" value="" id="date_debut_tva_prochaine" name="date_debut_tva_prochaine" required>
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
                {{-- ####### INFO PARRAINAGE #######--}}
                <div class="panel-body" >
                    <fieldset class="col-md-12">
                        <legend>Infos Commission de parrainage</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                           
                                                            <th>Année</th>
                                                            <th>1er filleul</th>
                                                            <th>2<sup> ème</sup> filleul</th>
                                                            <th>3<sup> ème</sup> filleul</th>
                                                            <th>n<sup> ème</sup> filleul</th>
                                                            <th  style="background-color:#928E81" >&nbsp;</th>
                                                            <th>Seuil (CA)  parrain</th>
                                                            <th>Seuil (CA)  filleul</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th class="color-primary" scope="row">1</th>
                                                            <td><input type="number" style="background-color:#ecf0f9;" min="0" max="50" class="form-control" value="" id="p_1_1" name="p_1_1" required>                                                            </td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_1_2" name="p_1_2" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_1_3" name="p_1_3" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_1_n" name="p_1_n" required></td>
                                                            <td>&nbsp;</td>
                                                            <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control"  name="seuil_parr_1" required></td>
                                                            <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control"  name="seuil_fill_1" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="color-primary" scope="row">2</th>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_2_1" name="p_2_1" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_2_2" name="p_2_2" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_2_3" name="p_2_3" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_2_n" name="p_2_n" required></td>
                                                            <td>&nbsp;</td>
                                                            <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control"  name="seuil_parr_2" required></td>
                                                            <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control"  name="seuil_fill_2" required></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="color-primary" scope="row">3</th>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_3_1" name="p_3_1" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_3_2" name="p_3_2" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_3_3" name="p_3_3" required></td>
                                                            <td><input type="number" style="background-color:#ecf0f9" min="0" max="50" class="form-control" value="" id="p_3_n" name="p_3_n" required></td>
                                                            <td>&nbsp;</td>
                                                            <td><input type="number" style="background-color:#FFF8DC " min="0"  class="form-control"  name="seuil_parr_3" required></td>
                                                            <td><input type="number" style="background-color:#FFF8DC" min="0"  class="form-control"  name="seuil_fill_3" required></td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        
                                       
                                    </div>
                            </div>
                        </div>
                    </fieldset>
               

               
                </div>


                <br><br>
                {{-- ####### INFO PARRAINAGE #######--}}
                <div class="panel-body" >
                    <fieldset class="col-md-12">
                        <legend>Autres Paramètres</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="col-lg-6 col-md-6 col-sm-6" id="nb_jour_max_demande">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="nb_jour_max_demande">Nombre de jours maximum avant demande de facture </label>
                                                    <div class="col-lg-4">
                                                        <input type="number" style="background-color:#f3f3f3" class="form-control" value="" id="nb_jour_max_demande" name="nb_jour_max_demande" required >
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        
                                        
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                

                
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
@stop @section('js-content') 

<script>

</script>
@endsection
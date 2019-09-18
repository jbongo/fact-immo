@extends('layouts.app') 
@section('content') 
@section ('page_title') 
    Infos du contrat 
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

                <div class="panel-body">
                    <fieldset class="col-md-12">
                        <legend>Infos basiques</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form class="form-valide3" action="{{ route('contrat.add') }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="forfait_entree">Forfait d'entrée (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" min="1" value="225" id="forfait_entree" name="forfait_entree" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="est_starter">Démarrage en tant que Starter ?</label>
                                                <input type="checkbox" unchecked data-toggle="toggle" id="est_starter" name="est_starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="a_parrain">Le mandataire a t'il un parrain ?</label>
                                                <input type="checkbox" unchecked data-toggle="toggle" id="a_parrain" name="a_parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>

                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-4 col-form-label" for="parrain_id">Choisir le parrain</label>
                                                <div class="col-lg-8">
                                                    <select class="selectpicker col-lg-6" id="parrain_id" name="parrain_id" data-live-search="true" data-style="btn-warning btn-rounded">
                                                        @foreach ($parrains as $parrain )
                                                        <option value="{{ $parrain->id }}" data-tokens="{{ $parrain->nom }} {{ $parrain->prenom }}">{{ $parrain->nom }} {{ $parrain->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_entree">Date d'entrée<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" id="date_entree" name="date_entree" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date_debut">Date de début d'activité<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
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
                        <legend>Commision direct</legend>
                        <div class="panel panel-warning">
                            <div class="panel-body">

                                {{-- PACK STARTER --}}
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
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="pourcentage_depart_starter">Pourcentage de départ du mandataire<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="pourcentage_depart_starter" name="pourcentage_depart_starter" min="1" max="100" hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group row" id="max-starter-parrent">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="duree_max_starter">Durée maximum du pack Starter<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_max_starter" name="duree_max_starter" min="1" max="48" value="7" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" for="duree_gratuite">Durée de la gratuitée (mois)<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_gratuite" name="duree_gratuite_starter" min="0" max="48" value="4" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="check_palier_starter">Paliers<span class="text-danger">*</span></label>
                                            <div class="col-lg-2">
                                                <input type="checkbox" unchecked data-toggle="toggle" id="check_palier_starter" name="check_palier_starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12" id="palier_starter">
                                            <div class="panel panel-pink m-t-15">
                                                <div class="panel-heading"><strong>Paliers Starter</strong></div>
                                                <div class="panel-body">
                                                    <div class="input_fields_wrap_starter">
                                                        <button class="btn btn-warning add_field_button_starter" style="margin-left: 53px;">Ajouter un niveau</button>
                                                        <div class="form-inline field1">
                                                            <div class="form-group">
                                                                <label for="level_starter1">Niveau: </label>
                                                                <input class="form-control" type="text" value="1" id="level_starter1" name="level_starter1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="percent_starter1">% en + : </label>
                                                                <input class="form-control" type="number" min="0" max="0" step="0.10" value="0" id="percent_starter1" name="percent_starter1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_min_starter1">CA min (€): </label>
                                                                <input class="form-control" type="number" value="0" id="ca_min_starter1" name="ca_min_starter1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_max_starter1">CA max (€): </label>
                                                                <input class="form-control" type="number" min="0" value="50000" id="ca_max_starter1" name="ca_max_starter1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
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
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="pourcentage_depart_expert">Pourcentage de départ du mandataire<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="pourcentage_depart_expert" name="pourcentage_depart_expert" min="1" max="100" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                       
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" for="duree_gratuite_expert">Durée de la gratuitée (mois)<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number" class="form-control" id="duree_gratuite_expert" name="duree_gratuite_expert" min="0" max="48" value="4" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="check_palier_expert">Paliers<span class="text-danger">*</span></label>
                                            <div class="col-lg-2">
                                                <input type="checkbox" unchecked data-toggle="toggle" id="check_palier_expert" name="check_palier_expert" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12" id="palier_expert">
                                            <div class="panel panel-pink m-t-15">
                                                <div class="panel-heading"><strong>Paliers Expert</strong></div>
                                                <div class="panel-body">
                                                    <div class="input_fields_wrap_expert">
                                                        <button class="btn btn-warning add_field_button_expert" style="margin-left: 53px;">Ajouter un niveau</button>
                                                        <div class="form-inline field1">
                                                            <div class="form-group">
                                                                <label for="level_expert1">Niveau: </label>
                                                                <input class="form-control" type="text" value="1" id="level_expert1" name="level_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="percent_expert1">Pourcentage en +: </label>
                                                                <input class="form-control" type="number" min="0" max="0" step="0.10" value="0" id="percent_expert1" name="percent_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_min_expert1">CA min (€): </label>
                                                                <input class="form-control" type="number" value="0" id="ca_min_expert1" name="ca_min_expert1" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ca_max_expert1">CA max (€): </label>
                                                                <input class="form-control" type="number" min="0" value="50000" id="ca_max_expert1" name="ca_max_expert1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                        <div class="col-lg-12" id="expert-par">
                                            <div class="panel panel-default m-t-15">
                                                <div class="panel-heading-default"><strong>Paramètres du pack expert</strong></div>
                                                <div class="panel-body">
                                                    <strong>Pour garder le pourcentage de départ definis en haut à l'année N voici les conditions à réaliser sur l'année N-1:
                                                    <br>
                                                    <br>
                                                    </strong>

                                                    <div class="row">
                                                        <div class="col-lg-6-col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="nombre_vente_min">Nombre de vente minimum</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="4" id="nombre_vente_min" name="nombre_vente_min" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="nombre_mini_filleul">Nombre minimum de filleuls parrainés</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="4" id="nombre_mini_filleul" name="nombre_mini_filleul" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6-col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="chiffre_affaire">Chiffre d'affaire(€) </label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="27000" id="chiffre_affaire" name="chiffre_affaire" required>
                                                                </div>
                                                            </div>
                                                            <strong>Si ces conditions ne sont pas réunies alors:
                                                            <br>
                                                            <br>
                                                            </strong>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="a_soustraitre">A soustraire (%)</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="10" max="15" step="0.10" id="a_soustraitre" name="a_soustraitre" required>
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
                                                <input type="number" class="form-control" id="prime_max_forfait" name="prime_max_forfait" min="1" value="200" required>
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
                                            <select class="col-lg-4 col-md-4 col-sm-4 form-control" id="pack_pub" name="pack_pub">
                                                {{-- @foreach ($packs_pub as $pack_pub ) --}}
                                                <option value="1">Pack 10</option>
                                                <option value="2">Pack 20</option>
                                                <option value="3">Pack 30</option>
                                                <option value="4">Pack 40</option>
                                                <option value="5">Pack 50</option>
                                                {{-- @endforeach --}}
                                            </select>
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
                    <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5  " id="terminer"><i class="ti-save"></i>Terminer</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
@stop @section('js-content') 
{{-- ###### Parrainage --}}
<script>
    
    $('#parrain-id').hide();
    $('#parrainage_div').hide();

    $('#a_parrain').change(function(e) {
        e.preventDefault();
        if($("#a_parrain").prop('checked')){
            $('#parrain-id').slideDown();
            $('#parrainage_div').slideDown();
        }else{
            $('#parrain-id').slideUp();
            $('#parrainage_div').slideUp();
            
        }
        

    });
</script>
{{-- ###### Fin parrain --}}




{{-- ##### Pack Starter  --}}

<script>
    $('#palier_starter').hide();
    $('#pack_starter').hide();

    
    $("#est_starter").change(function(e) {
        e.preventDefault();
        if($("#est_starter").prop('checked')){
            $('#pack_starter').slideDown();
        }else{
            $('#pack_starter').slideUp();            
        }

    });
    $("#check_palier_starter").change(function(e) {
        e.preventDefault();
        if($("#check_palier_starter").prop('checked')){
            $('#palier_starter').slideDown();
        }else{
            $('#palier_starter').slideUp();            
        }

    });
</script>



<script>
    var x = 1;
    $(document).ready(function() {
        var max_fields = 15;
        var wrapper = $(".input_fields_wrap_starter");
        var add_button = $(".add_field_button_starter");

      
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                var ca_min_starter = parseInt($("#ca_max_starter" + x + '').change().val()) + 1;
            
                
                var percent_diff = (95  - (parseFloat($("#pourcentage_depart_starter").change().val() ))) ;
                var i = 1;
                while (i <= x) {
                    let tmp = parseFloat($("#percent_starter" + i + '').change().val() ) ;
                    percent_diff = (percent_diff  - tmp ) ;
                    i++;
                }
                if (x > 1 && percent_diff > 0)
                    $("#pal_starter" + x + '').hide();
                if (percent_diff > 0)
                    x++;
                if (percent_diff < 0) {
                    percent_diff = 0;

                }
                var val_chiffre = parseInt(ca_min_starter) + 19999;
                
                if (percent_diff > 5)
                    $(wrapper).append('<div class = "form-inline field' + x + '"><div class="form-group"><label for="level_starter' + x + '">Niveau: </label> <input class="form-control" type="text" value="' + x + '" id="level_starter' + x + '" name="level_starter' + x + '"/ readonly></div> <div class="form-group"><label for="percent_starter' + x + '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_starter' + x + '" name="percent_starter' + x + '"/> </div> <div class="form-group"><label for="ca_min_starter' + x + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_starter + '" id="ca_min_starter' + x + '" name="ca_min_starter' + x + '" readonly></div> <div class="form-group"><label for="ca_max_starter' + x + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_starter + '" value="' + val_chiffre + '" id="ca_max_starter' + x + '" name="ca_max_starter' + x + '"/></div>  <button href="#" id="pal_starter' + x + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else if (percent_diff <= 5 && percent_diff > 0)
                    $(wrapper).append('<div class = "form-inline field' + x + '"><div class="form-group"><label for="level_starter' + x + '">Niveau: </label> <input class="form-control" type="text" value="' + x + '" id="level_starter' + x + '" name="level_starter' + x + '"/ readonly></div> <div class="form-group"><label for="percent_starter' + x + '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_starter' + x + '" name="percent_starter' + x + '"/> </div> <div class="form-group"><label for="ca_min_starter' + x + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_starter + '" id="ca_min_starter' + x + '" name="ca_min_starter' + x + '" readonly></div> <div class="form-group"><label for="ca_max_starter' + x + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_starter + '" value="' + val_chiffre + '" id="ca_max_starter' + x + '" name="ca_max_starter' + x + '"/></div>  <button href="#" id="pal_starter' + x + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else {
                    swal(
                        'Ajout impossible!',
                        'Le maximum de 95% en pourcentage est atteint, vous ne pouvez pas ajouter d\'avantages de paliers!',
                        'error'
                    );
                }
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            if (x > 2) $("#pal_starter" + (x - 1) + '').show();
            $(this).parent('div').remove();
            x--;
        })
    });

</script>

{{--########### Fin pack starter --}}




{{-- ##### Pack Expert  --}}

<script>
    
    $('#palier_expert').hide();
    // $('#pack_starter').hide();

    
    
    $("#check_palier_expert").change(function(e) {
        e.preventDefault();
        if($("#check_palier_expert").prop('checked')){
            $('#palier_expert').slideDown();
        }else{
            $('#palier_expert').slideUp();            
        }

    });
</script>
    
    
<script>
    var y = 1;
    $(document).ready(function() {
        var max_fields = 15;
        var wrapper = $(".input_fields_wrap_expert");
        var add_button = $(".add_field_button_expert");

        
        $(add_button).click(function(e) {
            e.preventDefault();
            if (y < max_fields) {
                var ca_min_expert = parseInt($("#ca_max_expert" + y + '').change().val()) + 1;
            
                console.log(ca_min_expert);
                
                var percent_diff = (95  - (parseFloat($("#pourcentage_depart_expert").change().val() ))) ;
                var i = 1;
                while (i <= y) {
                    let tmp = parseFloat($("#percent_expert" + i + '').change().val() ) ;
                    percent_diff = (percent_diff  - tmp ) ;
                    i++;
                }
                if (y > 1 && percent_diff > 0)
                    $("#pal_expert" + y + '').hide();
                if (percent_diff > 0)
                    y++;
                if (percent_diff < 0) {
                    percent_diff = 0;

                }
                var val_chiffre = parseInt(ca_min_expert) + 19999;
                
                if (percent_diff > 5)
                    $(wrapper).append('<div class = "form-inline field' + y + '"><div class="form-group"><label for="level_expert' + y + '">Niveau: </label> <input class="form-control" type="text" value="' + y + '" id="level_expert' + y + '" name="level_expert' + y + '"/ readonly></div> <div class="form-group"><label for="percent_expert' + y + '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_expert' + y + '" name="percent_expert' + y + '"/> </div> <div class="form-group"><label for="ca_min_expert' + y + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_expert + '" id="ca_min_expert' + y + '" name="ca_min_expert' + y + '" readonly></div> <div class="form-group"><label for="ca_max_expert' + y + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_expert + '" value="' + val_chiffre + '" id="ca_max_expert' + y + '" name="ca_max_expert' + y + '"/></div>  <button href="#" id="pal_expert' + y + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else if (percent_diff <= 5 && percent_diff > 0)
                    $(wrapper).append('<div class = "form-inline field' + y + '"><div class="form-group"><label for="level_expert' + y + '">Niveau: </label> <input class="form-control" type="text" value="' + y + '" id="level_expert' + y + '" name="level_expert' + y + '"/ readonly></div> <div class="form-group"><label for="percent_expert' + y + '">Pourcentage en + : </label> <input class="form-control" type="number" step="0.10" min="0" max="' + percent_diff + '" value="' + percent_diff + '" id="percent_expert' + y + '" name="percent_expert' + y + '"/> </div> <div class="form-group"><label for="ca_min_expert' + y + '">CA min (€): </label> <input class="form-control" type="number" value="' + ca_min_expert + '" id="ca_min_expert' + y + '" name="ca_min_expert' + y + '" readonly></div> <div class="form-group"><label for="ca_max_expert' + y + '">CA max (€): </label> <input class="form-control" type="number" min="' + ca_min_expert + '" value="' + val_chiffre + '" id="ca_max_expert' + y + '" name="ca_max_expert' + y + '"/></div>  <button href="#" id="pal_expert' + y + '" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                else {
                    swal(
                        'Ajout impossible!',
                        'Le maximum de 95% en pourcentage est atteint, vous ne pouvez pas ajouter d\'avantages de paliers!',
                        'error'
                    );
                }
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            if (y > 2) $("#pal_expert" + (y - 1) + '').show();
            $(this).parent('div').remove();
            y--;
        })
    });
</script>

{{-- Fin pack Expert --}}




{{-- Envoi des données en ajax pour le stockage --}}
<script>

    $('.form-valide3').submit(function(e) {
        e.preventDefault();
        var form = $(".form-valide3");

            var check_palier_starter = $('#check_palier_starter').is(':checked') ? "on" : "off";
            var palierdata = $('#palier_starter input').serialize();

        data = {
            "user_id": "{{$user_id}}",
            "forfait_entree" : $('#forfait_entree').val(),
            "date_entree" : $('#date_entree').val(),
            "date_debut" : $('#date_debut').val(),
            "est_starter" : $('#est_starter').val(),
            "a_parrain" : $('#a_parrain').val(),
            "parrain_id" : $('#parrain_id').val(),

            "pourcentage_depart_starter" : $('#pourcentage_depart_starter').val(),
            "duree_max_starter" : $('#duree_max_starter').val(),
            "duree_gratuite" : $('#duree_gratuite').val(),
            "check_palier_starter" : check_palier_starter,
            "palier_starter" : $('#palier_starter input').serialize(),

            "pourcentage_depart_expert" : $('#pourcentage_depart_expert').val(),
            "duree_gratuite_expert" : $('#duree_gratuite_expert').val(),
            "check_palier_expert" : $('#check_palier_expert').val(),
            "palier_expert" : $('#palier_expert input').serialize(),
            "nombre_vente_min" : $('#nombre_vente_min').val(),
            "chiffre_affaire" : $('#chiffre_affaire').val(),
            "nombre_mini_filleul" : $('#nombre_mini_filleul').val(),
            "a_soustraitre" : $('#a_soustraitre').val(),
            "prime_max_forfait_parrain" : $('#prime_max_forfait').val(),
            "pack_pub" : $('#pack_pub').val(),

        }
          
        console.log(data);
        
            $.ajax({
                type: "POST",
                url: "{{route('contrat.add')}}",
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
                data: data,
                success: function(data) {
                    console.log(data);
                    
                    swal(
                            'Ajouté',
                            'Le model  est ajouté avec succées!',
                            'success'
                        )
                        .then(function() {
                            window.location.href = "";
                        })
                },
                error: function(data) {
                    console.log(data);
                    
                    swal(
                        'Echec',
                        'Le model  n\'a pas été ajouté!',
                        'danger'
                    );
                }
            });
    });
</script>
@endsection
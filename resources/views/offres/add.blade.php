@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'une offre
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
                <form class="form-valide3" action="" method="post">
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
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="forfait">Forfait d'entrée (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="number" class="form-control" min="1" value="225" id="forfait" name="forfait" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="bool-starter">Démarrage en tant que Starter ?</label>
                                                <input type="checkbox" unchecked data-toggle="toggle" id="bool-starter" name="bool-starter" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="parrain">Le mandataire a t'il un parrain ?</label>
                                                <input type="checkbox" unchecked data-toggle="toggle" id="parrain" name="parrain" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                            </div>                                        
                                            
                                            <div class="form-group row" id="parrain-id">
                                                <label class="col-lg-4 col-form-label" for="parr-id">Choisir le parrain</label>
                                                <div class="col-lg-8">
                                                    <select class="selectpicker col-lg-6" id="parr-id" name="parr-id" data-live-search="true" data-style="btn-warning btn-rounded" >
                                                        <option  value="szszsz" data-tokens="szszsz">Alain PoPar</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date-entree">Date d'entrée<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" id="date-entree" name="date-entree" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="date-debut">Date de début d'activité<span class="text-danger">*</span></label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" id="date-debut" name="date-debut" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </fieldset>
                </div>


				<div class="panel-body">
					<fieldset class="col-md-12">
						<legend>Commision direct</legend>
						<div class="panel panel-warning">
							<div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="plan-type">Type du plan <span class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                    <select class="js-select2 form-control" id="plan-type" name="plan-type" required>
                                                        <option ></option>
                                                        <option value="Starter">Starter</option>
                                                        <option value="Expert">Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="max-starter">Pourcentage de départ du mandataire<span class="text-danger">*</span></label>     
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number"  class="form-control"  id="max-starter" name="range_01" min="1" max="100"  required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group row" id="max-starter-parrent">
                                            <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="max-starter">Durée maximum du pack Starter<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number"  class="form-control"  id="max-starter" name="max-starter" min="1" max="48" value="7" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" for="free-duration">Durée de la gratuitée (mois)<span class="text-danger">*</span></label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                <input type="number"  class="form-control"  id="free-duration" name="free-duration" min="0" max="48" value="4" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="check-palier">Paliers<span class="text-danger">*</span></label>
                                                <div class="col-lg-2">
                                                    <input type="checkbox" unchecked data-toggle="toggle" id="check-palier" name="check-palier" data-off="Non" data-on="Oui" data-onstyle="success" data-offstyle="danger">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
                                                <div class="panel panel-pink m-t-15">
                                                    <div class="panel-heading"><strong>Paliers</strong></div>
                                                    <div class="panel-body">
                                                        <div class="input_fields_wrap">
                                                            <button class="btn btn-warning add_field_button" style="margin-left: 53px;">Ajouter un niveau</button>
                                                            <div class="form-inline field1">
                                                                <div class="form-group">
                                                                    <label for="level1">Niveau: </label>
                                                                    <input class="form-control" type="text" value="1" id="level1" name="level1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="percent1">Pourcentage en + (%): </label>
                                                                    <input class="form-control" type="number" min="0" max="0" step="0.10" value="0" id="percent1" name="percent1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="min1">Chiffre d'affaire minimum (€): </label>
                                                                    <input class="form-control" type="number" value="0" id="min1" name="min1" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="max1">Chiffre d'affaire maximum (€): </label> 
                                                                    <input class="form-control" type="number" min="0" value="50000" id="max1" name="max1"/>
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
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="sales">Nombre de vente minimum</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="4" id="min-sales" name="min-sales" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label"  for="min-filleul">Nombre minimum de filleuls parrainés</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="4" id="min-filleul" name="min-filleul" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6-col-md-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="min-exp-ch-affaire">Chiffre d'affaire(€) </label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="27000" id="min-exp-ch-affaire" name="min-exp-ch-affaire" required>
                                                                </div>
                                                            </div>
                                                            <strong>Si ces conditions ne sont pas réunies alors:
                                                            <br>
                                                            <br>
                                                            </strong>
                                                            <div class="form-group row">
                                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="sub-percent-expert">A soustraire (%)</label> 
                                                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                                                    <input class="form-control" type="number" min="0" value="10" max="15" step="0.10" id="sub-percent-exper" name="sub-percent-exper" required>
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
						</div>
					</fieldset>
				</div>
                <br>
                

				<div class="panel-body">
					<fieldset class="col-md-12">
						<legend>Parrainage</legend>
						<div class="panel panel-warning">
							<div class="panel-body">
                                <form class="form-valide3" action="" method="post">
                                    {{ csrf_field() }}
                                   
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row" id="max-starter-parrent">
                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label col-form-label" for="max-forfait">Prime forfitaire si le parrain est à 100% (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <input type="number"  class="form-control"  id="max-forfait" name="max-forfait" min="1" value="200" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row" id="yr00">
                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="annee1">Pourcentage de la premiere année<span class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <input type="number"  class="form-control"  id="annee1" name="annee1" min="0" max="100" step="0.10" value="5" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12" id="palier">
                                            <div class="panel panel-default m-t-15">
                                                <div class="panel-heading-default"><strong>Rémunération par année</strong></div>
                                                <div class="panel-body">
                                                    <div class="input_fields_wrap">
                                                    <div class="form-inline field1">
                                                        <div class="form-group">
                                                            <label for="year1">Année </label>
                                                            <input class="form-control" type="text" value="1" id="year1" name="year1" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="min-percent1">Pourcentage minimum(%) </label>
                                                            <input class="form-control" type="number" min="0" max="100" step="0.10" value="2.5" id="min-percent1" name="min-percent1" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="max-percent1">Pourcentage maximum(%) </label>
                                                            <input class="form-control" type="number" min="0" max="100" step="0.10" value="5" id="max-percent1" name="max-percent1" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="chiffre1">Chiffre d'affaire requis pour maximum (€)</label>
                                                            <input class="form-control" type="number" min="0" value="27500" id="chiffre1" name="chiffre1" required>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
							</div>
						</div>
					</fieldset>
				</div>
                <br>
                

				<div class="panel-body">
					<fieldset class="col-md-12">
						<legend>Tarif et abonnement</legend>
						<div class="panel panel-warning">
							<div class="panel-body">
                                <form class="form-valide3" action="" method="post">
                                    {{ csrf_field() }}


                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="price">Tarifs mensuel (€)<span class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <input type="number"  class="form-control"  id="price" name="price" min="0" value="7" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-md-6 col-sm-6 col-form-label" for="annonces">Nombre d'annonces<span class="text-danger">*</span></label>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <input type="number"  class="form-control"  id="annonces" name="annonces" min="0" value="7" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
							</div>
						</div>
					</fieldset>
				</div>
            </div>
            


			<div class="form-validation">
				<form class="form-valide3" action="" method="post">
					{{ csrf_field() }}

					<div class="form-group row" style="text-align: center; margin-top: 50px;">
						<div class="col-lg-8 ml-auto">
							<button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"><i class="ti-file"></i>Terminer</button>
						</div>
					</div>
				</form>
            </div>
            

		</div>
	</div>
</div>
</div>
@stop
@section('js-content')


{{-- INFOS DE BASE --}}
<script>
$('#parrain-id').hide();
$('#parrain').change(function(e){
    e.preventDefault();
    $("#parrain").prop('checked') ? $('#parrain-id').slideDown()  : $('#parrain-id').slideUp() ;
    
});
</script>
{{-- FIN INFOS DE BASE --}}


<script>
    $("#check-palier").change(function(e){
        e.preventDefault();
        console.log($("#check-palier").prop('checked'));
        
    })
	$(document).ready(function() {
	    // $('#parrain').is(':unchecked') ? $('#parrain-id').hide() : $('#parrain-id').show();
	    // $('#parrain').change(function(e){
	    //     e.preventDefault();
	    //     $('#parrain').is(':unchecked') ? $('#parrain-id').hide() : $('#parrain-id').show();
	    // });
	
	    // $('#refund').is(':unchecked') ? $('#durex1').hide() : $('#durex1').show();
	    // $('#refund').change(function(e){
	    //     e.preventDefault();
	    //     $('#refund').is(':unchecked') ? $('#durex1').hide() : $('#durex1').show();
	    // });
	
	    // $('#bool-starter').is(':unchecked') ? $('#glob').hide() : $('#glob').show();
	    // $('#bool-starter').change(function(e){
	    //     e.preventDefault();
	    //     $('#bool-starter').is(':unchecked') ? $('#glob').hide() : $('#glob').show();
	    // });
	});
</script>



<!--enable palier-->
<script>
        $(document).ready(function() {
         $('#palier').hide();
         $('#plan-type').change(function(){
     
                 if($('#plan-type').val() === 'Starter')
                     {
                         $('#expert-par').hide();
                         $('#max-starter-parrent').show();
                     }
                     if($('#plan-type').val() === 'Expert')
                     {
                         $('#expert-par').show();
                         $('#max-starter-parrent').hide();
                     }
                     $('#check-palier').change(function(e){
                     e.preventDefault();
                     $("#check-palier").prop('checked') ? $('#palier').show() :  $('#palier').hide();
                     
                     });
     
                     $('#plan-type').change(function(){
                     if($('#plan-type').val() === 'Starter')
                         {
                             $('#expert-par').hide();
                             $('#max-starter-parrent').show();
                         }
                     else 
                         {
                             $('#expert-par').show() ;
                             $('#max-starter-parrent').hide();
                         }
                     
                     });
     
         });
         
        });
     </script>
     <!--paliers-->
     <script>
        var x = 1;
        $(document).ready(function() {
        var max_fields      = 15;
        var wrapper         = $(".input_fields_wrap");
        var add_button      = $(".add_field_button"); 
     
        $('#check-palier').change(function(e){
         e.preventDefault();
         $("#check-palier").prop('checked') ? $('#palier').slideDown()  : $('#palier').slideUp() ;
         
        });


        $(add_button).click(function(e){
            e.preventDefault();      
            if(x < max_fields){
                var min_chiffre = parseInt($("#max"+x+'').change().val()) + 1;
                var percent_diff = ((95 * 10) - (parseFloat($("#range_01").change().val() * 10))) / 10;
                var i = 1;           
                while (i <= x)
                {
                    let tmp = parseFloat($("#percent"+i+'').change().val() * 10) / 10;
                    percent_diff = (percent_diff * 10 - tmp * 10) / 10;
                    i++;
                }
                if(x > 1 && percent_diff > 0) 
                     $("#pal"+x+'').hide();
                if(percent_diff > 0)
                     x++;
                if(percent_diff < 0)
                 {
                     percent_diff = 0;
             
                 }
                 var val_chiffre = parseInt(min_chiffre) + 19999;
                 if (percent_diff > 5)
                     $(wrapper).append('<div class = "form-inline field'+x+'"><div class="form-group"><label for="level'+x+'">Niveau: </label> <input class="form-control" type="text" value="'+x+'" id="level'+x+'" name="level'+x+'"/ readonly></div> <div class="form-group"><label for="percent'+x+'">Pourcentage en + (%): </label> <input class="form-control" type="number" step="0.10" min="0" max="'+percent_diff+'" value="'+percent_diff+'" id="percent'+x+'" name="percent'+x+'"/> </div> <div class="form-group"><label for="min'+x+'">Chiffre d\'affaire minimum (€): </label> <input class="form-control" type="number" value="'+min_chiffre+'" id="min'+x+'" name="min'+x+'" readonly></div> <div class="form-group"><label for="max'+x+'">Chiffre d\'affaire maximum (€): </label> <input class="form-control" type="number" min="'+min_chiffre+'" value="'+val_chiffre+'" id="max'+x+'" name="max'+x+'"/></div>  <button href="#" id="pal'+x+'" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                 else if(percent_diff <= 5 && percent_diff > 0)
                     $(wrapper).append('<div class = "form-inline field'+x+'"><div class="form-group"><label for="level'+x+'">Niveau: </label> <input class="form-control" type="text" value="'+x+'" id="level'+x+'" name="level'+x+'"/ readonly></div> <div class="form-group"><label for="percent'+x+'">Pourcentage en + (%): </label> <input class="form-control" type="number" step="0.10" min="0" max="'+percent_diff+'" value="'+percent_diff+'" id="percent'+x+'" name="percent'+x+'"/> </div> <div class="form-group"><label for="min'+x+'">Chiffre d\'affaire minimum (€): </label> <input class="form-control" type="number" value="'+min_chiffre+'" id="min'+x+'" name="min'+x+'" readonly></div> <div class="form-group"><label for="max'+x+'">Chiffre d\'affaire maximum (€): </label> <input class="form-control" type="number" min="'+min_chiffre+'" value="'+val_chiffre+'" id="max'+x+'" name="max'+x+'"/></div>  <button href="#" id="pal'+x+'" class="btn btn-danger remove_field">Enlever</button></br></div>'); //add input box
                 else
                 {
                     swal(
                     'Ajout impossible!',
                     'Le maximum de 95% en pourcentage est atteint, vous ne pouvez pas ajouter d\'avantages de paliers!',
                     'error'
                     ); 
                 }
            }  
        });
        
        $(wrapper).on("click",".remove_field", function(e){ 
            e.preventDefault(); 
            if(x > 2) $("#pal"+(x-1)+'').show();
            $(this).parent('div').remove(); 
            x--;
        })
     });
     </script>
     <!--validate and ajax push-->
     <script>
        $('.submit').click(function(e){ 
              e.preventDefault();
              var form = $(".form-valide3");
              
               form.validate({
                   errorClass: "invalid-feedback animated fadeInDown",
                   errorElement: "div",
                   errorPlacement: function(e, a) {
                       jQuery(a).parents(".form-group > div").append(e)
                   },
                   highlight: function(e) {
                       jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
                   },
                   success: function(e) {
                       jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove();
                   },
                   rules: {
                   ".plan-type": {
                       required: !0
                   },
                   ".plan-name": {
                        required: !0
                   }
               },
               messages: {
                   ".plan-type": "Veillez choisir un type !",
                   ".plan-name": "Veillez saisir un nom !"
               }
           });
           $('.plan-type').on("select2:close", function (e) {  
             $(this).valid(); 
         });
           if (form.valid() === true){
             var check = $('#check-palier').is(':unchecked') ? "off" : "on";
             var level = $('#palier input').serialize();
             var planname = $('#plan-name').val();
               $.ajax({
                   type: "POST",
                   url: "",
                   beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                         xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                     }
                     },
                   data: {
                       plantype: $('#plan-type').val(), planname: $('#plan-name').val(), range01: $('#range_01').val(),
                       checkpalier: check, palierdata: level,
                       maxstarter: $('#max-starter').val(), freeduration: $('#free-duration').val(), minsales: $('#min-sales').val(),
                       minfilleul: $('#min-filleul').val(), minexpchaffaire: $('#min-exp-ch-affaire').val(),
                       subpercentexper: $('#sub-percent-exper').val()
                       },
                   success: function(data){
                     swal(
                     'Ajouté',
                     'Le model '+planname+' est ajouté avec succées!',
                     'success'
                     )
                     .then(function(){
                         window.location.href = "";
                     })
                   },
                   error: function(data){
                     swal(
                     'Echec',
                     'Le model '+planname+' n\'a pas été ajouté!',
                     'danger'
                     );
                   }
               });
           }
        });
     </script>
@endsection
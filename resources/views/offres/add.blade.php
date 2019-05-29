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

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group row">
                                                
                                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="civilite">Civilité <span class="text-danger">*</span></label>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                        <select class="js-select2 form-control" id="civilite" name="civilite" required>
                                                            <option ></option>
                                                            <option value="Mr">Mr</option>
                                                            <option value="Mme">Mme</option>
                                                        </select>
                                                    </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="level1">Nom </label>
                                                <input class="form-control" type="text" value="" id="level1" name="nom" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="level1">Prénom(s) </label>
                                                <input class="form-control" type="text" value="" id="level1" name="prenom" >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse1">Adresse 1 </label>
                                                    <input class="form-control" type="text" value="" id="adresse1" name="adresse1" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse2">Adresse 2 </label>
                                                    <input class="form-control" type="text" value="" id="adresse2" name="adresse2" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="codepostal">Code Postal </label>
                                                    <input class="form-control" type="text" value="" id="codepostal" name="codepostal" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville">Ville </label>
                                                    <input class="form-control" type="text" value="" id="ville" name="ville" >
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
                                                
                                                    <label class="col-lg-8 col-md-8 col-sm-8 col-form-label" for="civilite">Civilité <span class="text-danger">*</span></label>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                                                        <select class="js-select2 form-control" id="civilite" name="civilite2" required>
                                                            <option ></option>
                                                            <option value="Mr">Mr</option>
                                                            <option value="Mme">Mme</option>
                                                        </select>
                                                    </div>
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="nom2">Nom </label>
                                                <input class="form-control" type="text" value="" id="nom2" name="nom2" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="prenom2">Prénom(s) </label>
                                                <input class="form-control" type="text" value="" id="prenom2" name="prenom2" >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse12">Adresse 1 </label>
                                                    <input class="form-control" type="text" value="" id="adresse12" name="adresse12" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="adresse22">Adresse 2 </label>
                                                    <input class="form-control" type="text" value="" id="adresse22" name="adresse22" >
                                                </div>                                            
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="codepostal2">Code Postal </label>
                                                    <input class="form-control" type="text" value="" id="codepostal2" name="codepostal2" >
                                                </div>                                            
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                            
                                                <div class="form-group">
                                                    <label for="ville2">Ville </label>
                                                    <input class="form-control" type="text" value="" id="ville2" name="ville2" >
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
                                                <label for="nummandat">Numéro Mandat </label>
                                                <input class="form-control" type="text" value="" id="nummandat" name="nummandat" >
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="datemandat">Date mandat </label>
                                                <input class="form-control" type="date" value="" id="datemandat" name="datemandat" >
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
                                                        <option ></option>
                                                        <option value="Non">Non</option>
                                                        <option value="Oui">Oui</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="nomagent">Nom Agence/Agent </label>
                                                <input class="form-control" type="text" value="" id="nomagent" name="nomagent" >
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
                                                <label for="montantdeduis">Montant Déduis Ht ou Net </label>
                                                <input class="form-control" type="number" value="" id="montantdeduis" name="montantdeduis" >
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
                                                        <option ></option>
                                                        <option value="Vendeur">Vendeur</option>
                                                        <option value="Acquéreur">Acquéreur</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="netvendeur">Net Vendeur </label>
                                                <input class="form-control" type="number" value="" id="netvendeur" name="netvendeur" >
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="scpnotaire">SCP Notaire </label>
                                                <input class="form-control" type="texte" value="" id="scpnotaire" name="scpnotaire" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label for="datevente">Date exacte Vente </label>
                                                <input class="form-control" type="date" value="" id="datevente" name="datevente" >
                                            </div>
                                        </div>

                                    </div>
                                    
                            </div>
                        </div>
                    </fieldset>
                </div>				
                <br>




            </div>
            
        </form>

			<div class="form-validation">
				<form class="form-valide3" action="" method="post">
					{{ csrf_field() }}

					<div class="form-group row" style="text-align: center; margin-top: 50px;">
						<div class="col-lg-8 ml-auto">
							<button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5 submit"><i class="ti-file"></i>Enregistrer</button>
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
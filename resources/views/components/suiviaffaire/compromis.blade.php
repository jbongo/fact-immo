@php
   $dispo = 0;
   $all = 0;
   if(unserialize($affaire->documents_mandant) != false){
      $data = unserialize($affaire->documents_mandant);
      foreach ($data as $one) {
         if($one["compromis"] === 1){
            $all += 1;
            if($one["statut"] === "Disponible")
               $dispo += 1;
         }
      }
   }
   if(unserialize($affaire->documents_acquereur) != false){
      $data = unserialize($affaire->documents_acquereur);
      foreach ($data as $one) {
         if($one["compromis"] === 1){
            $all += 1;
            if($one["statut"] === "Disponible")
               $dispo += 1;
         }
      }
   }
   if($all > 0){
      $percent = intval(($dispo / $all) * 100);
      $bar = $percent - ($percent % 10);
   }
   else{
      $percent = 100;
      $bar = 100;
   }
@endphp
<div class="modal fade" id="gestion_compromis" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><strong>Gestion du compromis</strong></h5>
         </div>
         <div class="modal-body tet18">
            <ul class="nav nav-pills nav-tabs" id="zobi">
               <li class="cpr111 active"><a data-toggle="pill" href="#home_cmpr"><i class="ti-wallet"></i> <strong>@lang('Liste des documents')</strong></a></li>
               @if($affaire->compromis === 1)
                  <li class="cpr222"><a data-toggle="pill" href="#nrvcmpr1"><i class="ti-key"></i> <strong>@lang('Conditions suspensives')</strong></a></li>
               @endif
               <li class="cpr333"><a data-toggle="pill" href="#nrvcmpr2"><i class="ti-files"></i> <strong>@lang('Détails du rendez-vous')</strong></a></li>
            </ul>
            <br><br>
            <div class="tab-content cmpr9999">
               <div id="home_cmpr" class="tab-pane fade in active stuff1cmpr">
                  @include('components.suiviaffaire.compromis_components.documents')
               </div>
               @if($affaire->compromis === 1)
               <div id="nrvcmpr1" class="tab-pane fade stuff2cmpr">
                  @include('components.suiviaffaire.compromis_components.conditions')
               </div>
               @endif
               <div id="nrvcmpr2" class="tab-pane fade stuff3cmpr">
                  @if($affaire->notaires === NULL)
                  <div class="panel lobipanel-basic panel-danger">
                        <div class="panel-heading">
                            <div class="panel-title"><strong>Notaires non définis !</strong></div>
                        </div>
                        <div class="panel-body">
                            Vous devez définir les notaires pour le compromis et l'acte au préalable avant de pouvoire fixer le rendez-vous pour la signature du compromis.
                        </div>
                    </div>
                  @else
                  @if($affaire->rendez_vous_compromis === NULL)
                     @include('components.suiviaffaire.compromis_components.form')
                  @else
                     @include('components.suiviaffaire.compromis_components.info')
                  @endif
                  @endif
               </div>
            </div>
            <br><br>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
         </div>
      </div>
   </div>
</div>

@section('js_compromis')
<!--compromis-->
@if($affaire->compromis === 1)
<script>
   $(document).ready(function() {
      var date = new Date().toISOString().split("T")[0];
      document.getElementById("fin_condition").setAttribute("min", date);
      $('#show_form_compromis').on('click', function(b){
         b.preventDefault();
         $('.form_conditions_suspensives').removeAttr('hidden');
      });
      $('.submitcondition').on('click', function(f){
            f.preventDefault();
            var form = $(".form-condition_compromis");
            if (form.valid() === true){
               $.ajax({
           type: "POST",
           url: ("{{route('suiviaffaire.offre.condition.add', ($compromis_actif != NULL) ? CryptId($compromis_actif->id) : 'undefined')}}"),
           beforeSend: function(xhr, type) {
             if (!type.crossDomain) {
                 xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                 $('.pace').removeClass('pace-inactive');
             }
             },
           data: {
               intitule: $('#intitule').val(), date_fin: $('#fin_condition').val()
               },
           success: function(data){
              $('.pace').addClass('pace-inactive');
              $(".lst_conditions").load(location.href + " .lst_conditions");
              $('#intitule').val("");
              $('#fin_condition').val("");
              $('.form_conditions_suspensives').attr('hidden', true);
           },
           error: function(data){
              $('.pace').addClass('pace-inactive');
             swal(
             'Echec',
             'Une erreur est survenue vérifiez votre saisie.',
             'error'
             );
           }
       });
            }
         });
   });
   $('a.confirm_condition').on('click', function(b){
b.preventDefault();       
let that = $(this);
var route = that.attr('href');
var warning = 'Valider uniquement si la condition suspensive est accomplie, continuer ?';
var div = ".lst_conditions";
processAjaxSwalDivRefresh(route, warning, div);
});
$('a.reject_condition').on('click', function(b){
b.preventDefault();       
let that = $(this);
var route = that.attr('href');
var warning = 'Valider uniquement si la condition suspensive ne peut pas étre accomplie et ainsi annuler le compromis, continuer ?';
var div = ".lst_conditions";
processAjaxSwalDivRefresh(route, warning, div);
});
     </script>
     @endif
  <!--fin compromis-->
   <!--js rendez-vous-->
   <script>
      $(document).ready(function(){
         var date = new Date().toISOString().split("T")[0];
         if(document.getElementById("date_compromis"))
            document.getElementById("date_compromis").setAttribute("min", date);
      })

         var current_fs, next_fs, previous_fs; 
         var left, opacity, scale; 
         var animating;
         var sentinel = true;
         var form = $(".form-valide2-compromis");
         $(".next").on('click', function(){
         
         //validation
             form.validate({
                     errorClass: "invalid-feedback animated fadeInDown",
                     errorElement: "div",
                     errorPlacement: function(e, a) {
                         jQuery(a).parents(".form-group > div").append(e)
                     },
                     highlight: function(e) {
                         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                     },
                     success: function(e) {
                         jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                     },
                 rules: {
                     "notaire_compromis": {
                             required: !0
                     },
                     "adresse_cmp": {
                             required: !0
                     },
                     "code_postal_cmp": {
                             required: !0
                     },
                     "ville_cmp": {
                             required: !0
                     },
                     "date_compromis": {
                             required: !0
                     },
                     "heure_compromis": {
                          required: !0
                     }
                 },
                 messages: {
                     "notaire_compromis": "Il faut choisir une entité notaire!",
                     "adresse_cmp": "Vous devez saisir correctement l'adresse!",
                     "code_postal_cmp": "Vous devez saisir correctement le code postal!",
                     "ville_cmp": "Vous devez saisir correctement la ville!",
                     "date_compromis": "Vous devez saisir correctement la date!",
                     "heure_compromis": "Vous devez saisir correctement l'heure!"
                 }
             });
             
         if (form.valid() == true){
            /*ajax notaire entite*/
            if(sentinel == true){
               $.ajax({
                  url: '/contact/entite/json_get/'+$('#notaire_compromis').val(),
                  type: 'GET',
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                     let stuff = JSON.parse(data);
                     $('.pace').addClass('pace-inactive');
                     sentinel = false;
                     $('#adresse_cmp').val(stuff['adresse']);
                     $('#code_postal_cmp').val(stuff['code_postal']);
                     $('#ville_cmp').val(stuff['ville']);
                  },
                  error: function(data){
                     $('.pace').addClass('pace-inactive');
                     swal(
                     'Echec',
                     'Une erreur est survenue vérifiez votre saisie.',
                     'error'
                     );
                  }
               })
             }
             /*fin ajax*/
             console.log(sentinel);
         if(animating) return false;
             animating = true;
         
         current_fs = $(this).parent();
         next_fs = $(this).parent().next();
         $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
         next_fs.show(); 
         current_fs.animate({opacity: 0}, {
             step: function(now, mx) {
                 scale = 1 - (1 - now) * 0.2;
                 left = (now * 50)+"%";
                 opacity = 1 - now;
                 current_fs.css({
             'transform': 'scale('+scale+')',
           });
                 next_fs.css({'left': left, 'opacity': opacity});
             }, 
             duration: 0, 
             complete: function(){
                 current_fs.hide();
                 animating = false;
             }, 
             easing: 'easeInOutBack'
         });
         }
         });
         
         $(".previous").on('click', function(){
         if(animating) return false;
         animating = true;
         
         current_fs = $(this).parent();
         previous_fs = $(this).parent().prev();
         $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
         previous_fs.show();
         current_fs.hide();
         current_fs.animate({opacity: 0}, {
             step: function(now, mx) {
                 scale = 0.8 + (1 - now) * 0.2;
                 left = ((1-now) * 50)+"%";
                 opacity = 1 - now;
                 current_fs.css({'left': left});
                 previous_fs.css({'transform': 'scale('+scale+')','opacity': opacity});
             }, 
             duration: 0, 
             complete: function(){
                 current_fs.hide();
                 animating = false;
             }, 
             seasing: 'easeInOutBack'
         });
         });
         $("#submit_compromis").on('click', function(rtf){
            rtf.preventDefault();
            if (form.valid() == true){
               console.log("toto");
               $.ajax({
                  url: ("{{route('suiviaffaire.rdv' ,[CryptId($affaire->id), CryptId('rendez_vous_compromis')])}}"),
                  type: 'POST',
                  data:{
                     notaire: $('#notaire_compromis').val(),
                     adresse: $('#adresse_cmp').val(),
                     complement_adresse: $('#cmpl_adresse_cmp').val(),
                     code_postal: $('#code_postal_cmp').val(),
                     ville: $('#ville_cmp').val(),
                     date: $('#date_compromis').val(),
                     heure: $('#heure_compromis').val()
                  }, 
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                        var ret = $(".cmpr9999").load(location.href + " .cmpr9999");
                        $('.pace').addClass('pace-inactive');
                     swal(
                     'Effectué',
                     'Le rendez-vous a été plannifié !',
                     'success'
                     ).then(function () {
                        $('#form_edit_compromis').hide();
                           $('.stuff1cmpr').removeClass("in active");
                        $('.stuff3cmpr').addClass("in active");
                        $('.cpr111').removeClass("active");
                        $('.cpr333').addClass("active");
                        });
                  },
                  error: function(data){
                     $('.pace').addClass('pace-inactive');
                     swal(
                     'Echec',
                     'Une erreur est survenue vérifiez votre saisie.',
                     'error'
                     );
                  }
               })
            }
         });
      </script>
      @if($affaire->rendez_vous_compromis != NULL)
      <script>
         $(document).ready(function() {
            $('#form_edit_compromis').hide();
         });
         $(".edit_compromis_rdv").on('click', function(t){
            t.preventDefault();
            $('#form_edit_compromis').show();
            $('#global_infos_compromis').hide();
         });
         $(".update_compromis").on('click', function(orion){
            orion.preventDefault();
            var form = $(".form-update-compromis");
            form.validate({
                     errorClass: "invalid-feedback animated fadeInDown",
                     errorElement: "div",
                     errorPlacement: function(e, a) {
                         jQuery(a).parents(".form-group > div").append(e)
                     },
                     highlight: function(e) {
                         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                     },
                     success: function(e) {
                         jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                     },
                     rules: {
                     "edit_adresse_cmp": {
                             required: !0
                     },
                     "edit_code_postal_cmp": {
                             required: !0
                     },
                     "edit_ville_cmp": {
                             required: !0
                     },
                     "edit_date_compromis": {
                             required: !0
                     },
                     "edit_heure_compromis": {
                          required: !0
                     }
                 },
                 messages: {
                     "edit_adresse_cmp": "Vous devez saisir correctement l'adresse!",
                     "edit_code_postal_cmp": "Vous devez saisir correctement le code postal!",
                     "edit_ville_cmp": "Vous devez saisir correctement la ville!",
                     "edit_date_compromis": "Vous devez saisir correctement la date!",
                     "edit_heure_compromis": "Vous devez saisir correctement l'heure!"
                 }
                  });
            if (form.valid() === true){
               $.ajax({
                  url: ("{{route('suiviaffaire.rdv.update' ,[CryptId($affaire->id), CryptId('rendez_vous_compromis')])}}"),
                  type: 'POST',
                  data:{
                     adresse: $('#edit_adresse_cmp').val(),
                     complement_adresse: $('edit_#cmpl_adresse_cmp').val(),
                     code_postal: $('#edit_code_postal_cmp').val(),
                     ville: $('#edit_ville_cmp').val(),
                     date: $('#edit_date_compromis').val(),
                     heure: $('#edit_heure_compromis').val()
                  }, 
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                     var ret = $("#global_infos_compromis").load(location.href + " #global_infos_compromis");
                        $('.pace').addClass('pace-inactive');
                     swal(
                     'Effectué',
                     'Le rendez-vous a été plannifié !',
                     'success'
                     ).then(function () {
                        $('#form_edit_compromis').hide();
                        $('#global_infos_compromis').show();
                        });
                  },
                  error: function(data){
                     $('.pace').addClass('pace-inactive');
                     console.log(data);
                     swal(
                     'Echec',
                     'Une erreur est survenue vérifiez votre saisie.',
                     'error'
                     );
                  }
               })
            }
         });
         $('a.confirm_compromis').click(function(b) {
            b.preventDefault();       
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si le compromis est signé, confirmez ?';
            processAjaxSwal(route, warning, reload);
         });
         $('a.cancel_compromis').click(function(b) {
            b.preventDefault();       
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement pour annuler le rendez-vous, confirmez ?';
            processAjaxSwal(route, warning, reload);
         });
         </script>
         @endif
   <!--fin js-->
@endsection
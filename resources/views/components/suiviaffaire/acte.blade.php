@php
   $dispo = 0;
   $all = 0;
   if(unserialize($affaire->documents_mandant) != false){
      $data = unserialize($affaire->documents_mandant);
      foreach ($data as $one) {
         if($one["acte"] === 1){
            $all += 1;
            if($one["statut"] === "Disponible")
               $dispo += 1;
         }
      }
   }
   if(unserialize($affaire->documents_acquereur) != false){
      $data = unserialize($affaire->documents_acquereur);
      foreach ($data as $one) {
         if($one["acte"] === 1){
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
<div class="modal fade" id="gestion_acte" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><strong>Gestion acte de vente</strong></h5>
         </div>
         <div class="modal-body act18">
            <ul class="nav nav-pills nav-tabs">
               <li class="act111 active"><a data-toggle="pill" href="#home_act"><i class="ti-folder"></i> <strong>@lang('Liste des documents')</strong></a></li>
               <li class="act222"><a data-toggle="pill" href="#nrvact1"><i class="ti-calendar"></i> <strong>@lang('Détails du rendez-vous')</strong></a></li>
            </ul>
            <br><br>
            <div class="tab-content act9999">
               <div id="home_act" class="tab-pane fade in active stuff1act">
                  @include('components.suiviaffaire.acte_components.documents')
               </div>
               <div id="nrvact1" class="tab-pane fade stuff2act">
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
                @if($affaire->rendez_vous_acte === NULL)
                    @include('components.suiviaffaire.acte_components.form')
                @else
                    @include('components.suiviaffaire.acte_components.info')
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

@section('js_acte')
<!--acte-->
   <!--js rendez-vous-->
   <script>
      $(document).ready(function(){
         var date = new Date().toISOString().split("T")[0];
         if(document.getElementById("date_acte"))
            document.getElementById("date_acte").setAttribute("min", date);
      })

         var current_fs, next_fs, previous_fs; 
         var left, opacity, scale; 
         var animating;
         var sentinel = true;
         var form = $(".form-valide2-acte");
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
                     "notaire_acte": {
                             required: !0
                     },
                     "adresse_acte": {
                             required: !0
                     },
                     "code_postal_acte": {
                             required: !0
                     },
                     "ville_acte": {
                             required: !0
                     },
                     "date_acte": {
                             required: !0
                     },
                     "heure_acte": {
                          required: !0
                     }
                 },
                 messages: {
                     "notaire_acte": "Il faut choisir une entité notaire!",
                     "adresse_acte": "Vous devez saisir correctement l'adresse!",
                     "code_postal_acte": "Vous devez saisir correctement le code postal!",
                     "ville_acte": "Vous devez saisir correctement la ville!",
                     "date_acte": "Vous devez saisir correctement la date!",
                     "heure_acte": "Vous devez saisir correctement l'heure!"
                 }
             });
             
         if (form.valid() == true){
            /*ajax notaire entite*/
            if(sentinel == true){
               $.ajax({
                  url: '/contact/entite/json_get/'+$('#notaire_acte').val(),
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
                     $('#adresse_acte').val(stuff['adresse']);
                     $('#code_postal_acte').val(stuff['code_postal']);
                     $('#ville_acte').val(stuff['ville']);
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
         $("#submit_acte").on('click', function(rtf){
            rtf.preventDefault();
            if (form.valid() == true){
               console.log("toto");
               $.ajax({
                  url: ("{{route('suiviaffaire.rdv' ,[CryptId($affaire->id), CryptId('rendez_vous_acte')])}}"),
                  type: 'POST',
                  data:{
                     notaire: $('#notaire_acte').val(),
                     adresse: $('#adresse_acte').val(),
                     complement_adresse: $('#cmpl_adresse_acte').val(),
                     code_postal: $('#code_postal_acte').val(),
                     ville: $('#ville_acte').val(),
                     date: $('#date_acte').val(),
                     heure: $('#heure_acte').val()
                  }, 
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                        var ret = $(".act9999").load(location.href + " .act9999");
                        $('.pace').addClass('pace-inactive');
                     swal(
                     'Effectué',
                     'Le rendez-vous a été plannifié !',
                     'success'
                     ).then(function () {
                           $('.stuff1act').removeClass("in active");
                        $('.stuff2act').addClass("in active");
                        $('.act111').removeClass("active");
                        $('.act222').addClass("active");
                        $('#form_edit_acte').hide();
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
      @if($affaire->rendez_vous_acte != NULL)
      <script>
         $(document).ready(function() {
            $('#form_edit_acte').hide();
         });
         $(".edit_acte_rdv").on('click', function(t){
            t.preventDefault();
            $('#form_edit_acte').show();
            $('#global_infos_acte').hide();
         });
         $(".update_acte").on('click', function(orion){
            orion.preventDefault();
            var form = $(".form-update-acte");
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
                     "edit_adresse_act": {
                             required: !0
                     },
                     "edit_code_postal_act": {
                             required: !0
                     },
                     "edit_ville_act": {
                             required: !0
                     },
                     "edit_date_acte": {
                             required: !0
                     },
                     "edit_heure_acte": {
                          required: !0
                     }
                 },
                 messages: {
                     "edit_adresse_act": "Vous devez saisir correctement l'adresse!",
                     "edit_code_postal_act": "Vous devez saisir correctement le code postal!",
                     "edit_ville_act": "Vous devez saisir correctement la ville!",
                     "edit_date_acte": "Vous devez saisir correctement la date!",
                     "edit_heure_acte": "Vous devez saisir correctement l'heure!"
                 }
                  });
            if (form.valid() === true){
               $.ajax({
                  url: ("{{route('suiviaffaire.rdv.update' ,[CryptId($affaire->id), CryptId('rendez_vous_acte')])}}"),
                  type: 'POST',
                  data:{
                     adresse: $('#edit_adresse_act').val(),
                     complement_adresse: $('edit_#cmpl_adresse_act').val(),
                     code_postal: $('#edit_code_postal_act').val(),
                     ville: $('#edit_ville_act').val(),
                     date: $('#edit_date_acte').val(),
                     heure: $('#edit_heure_acte').val()
                  }, 
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                        var ret = $("#global_infos_acte").load(location.href + " #global_infos_acte");
                        $('.pace').addClass('pace-inactive');
                     swal(
                     'Effectué',
                     'Le rendez-vous a été modifié !',
                     'success'
                     ).then(function () {
                        $('#form_edit_acte').hide();
                        $('#global_infos_acte').show();
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
         $('a.confirm_acte').click(function(b) {
            b.preventDefault();       
            let that = $(this);
            var route = that.attr('href');
            var reload = 1;
            var warning = 'Valider uniquement si le compromis est signé, confirmez ?';
            processAjaxSwal(route, warning, reload);
         });
         $('a.cancel_acte').click(function(b) {
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
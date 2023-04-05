<div class="modal fade" id="documents_mandant_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel"><strong>Ajouter une offre</strong></h5>
              </div>
              <div class="modal-body">
                    <div class="panel lobipanel-basic panel-warning">
                            <div class="panel-heading">
                               <div class="panel-title">INSTRUCTIONS</div>
                            </div>
                            <div class="panel-body">
                               Définnir la liste des documents justificatifs que le vendeur doit réunir pour la signature du compromis et de l'acte en fonction de sa situation, cette liste lui
                               sera envoyée par email vous pouvez valider en suite le document dès la confirmation sa disponibilité par le mandant ou le cas echean, sa réception, vous pouvez ajouter jusqu'à 10 documents à la fois.
                            </div>
                         </div>
                 <div class="form-validation">
                    <form class="form-appel form-horizontal doc_mdn_push" action="#" method="post">
                     @csrf
                     <button id="add_field_documents_mandant" class="btn btn-pink btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>Ajouter une ligne</button>
                     <div class="input_fields_wrap_groupe_mandant">
                     <div class="form-group row">
                            <label class="col-sm-4 control-label" for="doc">Intitulé du document <span class="text-danger">*</span></label>
                            <div class="col-lg-3">
                               <input type="text" id="doc" class="form-control" value="" name="doc" required>
                            </div>
                         </div>
                    </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                          <button type="submit" id="dcm_mdn_check" class="btn btn-primary submitappel">valider</button>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
     </div>
@section('js_add_documents_mandant')
 <!--document mandant-->
 <script>
   $(document).ready(function() {
  var x = 2;
  var max_fields      = 10;
  var wrapper         = $(".input_fields_wrap_groupe_mandant");
  var add_button      = $("#add_field_documents_mandant");
  $(add_button).click(function(e){
      e.preventDefault();
      if(x < max_fields){
          $(wrapper).append('<div class="form-group row '+x+'"> <label class="col-sm-4 control-label" for="doc'+x+'">Intitulé du document <span class="text-danger">*</span></label> <div class="col-lg-3"> <input type="text" id="doc'+x+'" class="form-control" value="" name="doc'+x+'" required> </div> </div>'); //add input box
          x++;
      }  
  });

  $('#dcm_mdn_check').click(function(e){
    e.preventDefault();
    var form = $(".doc_mdn_push");
 if (form.valid() === true){
   var data = $('.input_fields_wrap_groupe_mandant input').serialize();
   $('#documents_mandant_add').modal('toggle');
     $.ajax({
         type: "POST",
         url: ("{{route('suiviaffaire.document.add', ['documents_mandant', CryptId($affaire->id)])}}"),
         beforeSend: function(xhr, type) {
           if (!type.crossDomain) {
               xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
           }
           },
         data: {
             documents: data
             },
         success: function(data){
           swal(
           'Effectué',
           'Les documents ont été ajoutés',
           'success'
           )
           .then(function () {
                         location.reload();
             })
         },
         error: function(data){
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
   </script>
<!--fin document mandant-->
@endsection
@if($affaire->statut === "offre" || $affaire->statut === "debut")
<a href="#" data-toggle="modal"  data-target="#visite_add" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
@endif
<div class="table-responsive" style="overflow-x: inherit !important;">
   <table  id="visite_list" class="table table-hover table-striped student-data-table  m-t-20 ">
      <thead>
         <tr>
            <th>@lang('Date de visite')</th>
            <th>@lang('Etat')</th>
            <th>@lang('Visiteur')</th>
            <th>@lang('Bon de visite')</th>
            <th>@lang('Action')</th>
         </tr>
      </thead>
      <tbody>
         @foreach($affaire->visites as $one)
         <tr>
            @if($one->visitable_type === "App\Models\Entite")
            @php $route = route('contact.entite.show', CryptId($one->visitable_id)) @endphp
            @else
            @php $route = route('contact.individu.show', CryptId($one->visitable_id)) @endphp
            @endif
            <td>
               {{date('d/m/Y',strtotime($one->date_visite))}}
            </td>
            <td>
               @if($one->etat === "Préparation")
               <span class="badge badge-warning">{{$one->etat}}</span>
               @elseif($one->etat === "Effectuée")
               <span class="badge badge-success">{{$one->etat}}</span>
               @else
               <span class="badge badge-danger">{{$one->etat}}</span>
               @endif
            </td>
            <td>
               <span><a href="{{$route}}" data-toggle="tooltip" title="Voir le visiteur"><i class="large material-icons color-info">visibility</i></a> </span>
            </td>
            <td>
               <span><a href="{{route('suiviaffaire.visite.download', CryptId($one->id))}}" data-toggle="tooltip" title="Télécharger le bon de visite"><i class="large material-icons color-pink">cloud_download</i></a> </span>
            </td>
            <td>
               @if($one->etat === "Préparation")
               <span><a class="confirm_visite" href="{{route('suiviaffaire.visite.confirm', [CryptId($one->id), "Effectuée"])}}" data-toggle="tooltip" title="Confirmer la visite"><i class="large material-icons color-success">check</i></a> </span>
               <span><a class="cancel_visite" href="{{route('suiviaffaire.visite.confirm', [CryptId($one->id), "Annulée"])}}" data-toggle="tooltip" title="Annuler la visite"><i class="large material-icons color-warning">close</i></a> </span>
               <span><a class="delete_visite" href="{{route('suiviaffaire.visite.delete', CryptId($one->id))}}" data-toggle="tooltip" title="Supprimer la visite"><i class="large material-icons color-danger">delete</i></a> </span>
               @else
               <span><a href="#" data-toggle="tooltip" title="Voir le compte rendu" onclick="Swal.fire({html: '<p>{{$one->compte_rendu}}</p>'})"><i class="large material-icons color-dark">speaker_notes</i></a> </span>
               @endif
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
@section('js_visites')
<script>
   const funcAjaxFireWithSwal = async(route, label) => {
        const { value: text } = await Swal.fire({
           type: 'warning',
           title: label,
           input: 'textarea',
           buttonsStyling: false,
           cancelButtonClass: 'btn btn-danger btn-rounded',
           cancelButtonText: '@lang('Annuler')',
           confirmButtonClass: 'btn btn-success btn-rounded',
           inputPlaceholder: 'Saisir un compte rendu...',
           inputAttributes: {
              'aria-label': 'Saisir un compte rendu',
              required: true
           },
           inputValidator: (result) => {
              return !result && 'Vous devez sasir le compte rendu !'
           },
           showCancelButton: true
      })
      if (text) {
         $.ajax({
                  url: route,
                  type: 'POST',
                  data:{
                     compte_rendu: text,
                  }, 
                  beforeSend: function(xhr, type) {
                     if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        $('.pace').removeClass('pace-inactive');
                     }
                  },
                  success: function(data){
                     $('.pace').addClass('pace-inactive');
                     console.log(data);
                     swal(
                     'Effectué',
                     'Le compte rendu a été ajouté !',
                     'success'
                     );
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
   }
   $(document).ready(function(){
     if(($('#visitable_type').val() === "Entite")){
        $('#vst2').hide();
        $('#visitable_id2').removeAttr('required');
        $('#vst1').show();
        $('#visitable_id1').attr('required');
     }
     else{
        $('#vst1').hide();
        $('#visitable_id1').removeAttr('required');
        $('#vst2').show();
        $('#visitable_id2').attr('required');
     }
   });
   $('#visitable_type').change(function(e){
      if(($('#visitable_type').val() === "Entite")){
        $('#vst2').hide();
        $('#visitable_id2').removeAttr('required');
        $('#vst1').show();
        $('#visitable_id1').attr('required');
     }
     else{
        $('#vst1').hide();
        $('#visitable_id1').removeAttr('required');
        $('#vst2').show();
        $('#visitable_id2').attr('required');
     }
     });
     $('a.confirm_visite').click(function(b) {
        b.preventDefault();
        let that = $(this);
        var route = that.attr('href');
        var label = 'Valider uniquement si la visite a eu lieu, le compte rendu est obligatoire.';
        funcAjaxFireWithSwal(route, label);
   })
   $('a.cancel_visite').click(function(b) {
      b.preventDefault();
      let that = $(this);
      var route = that.attr('href');
      var label = 'Valider uniquement si la visite est annulée, le compte rendu est obligatoire.';
      funcAjaxFireWithSwal(route, label);
   })
   $('a.delete_visite').click(function(b) {
   b.preventDefault();       
   let that = $(this);
   var route = that.attr('href');
   var reload = 1;
   var warning = 'La visite sera définitivement supprimée, continuer ?';
   processAjaxSwal(route, warning, reload);
   })
</script>
@endsection
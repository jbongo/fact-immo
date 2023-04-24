@extends('layouts.dashboard')
@extends('components.navbar')
@extends('components.header')
@section ('page_title')
Informations du contact

@endsection
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="col-lg-6">
               <div class="panel panel-info lobipanel-basic">
                  <div class="panel-heading">Fiche entité.</div>
                  <div class="panel-body">
                     <div class="card alert">
                        <div class="card-body">
                           <div class="user-profile">
                              <div class="row">
                                 <div class="col-lg-4">
                                    <div class="col-lg-12">
                                       <div class="user-photo m-b-30">
                                          <img class="img-responsive" style="object-fit: cover; width: 225px; height: 225px; border: 5px solid #8ba2ad; border-style: solid; border-radius: 20px; padding: 3px;" src="{{asset('/images/common/'."justice.png")}}" alt="">
                                       </div>
                                    </div>
                                    <div class="user-work">
                                       <h4 style="color: #32ade1;text-decoration: underline;">Statistiques</h4>
                                       <div class="work-content">
                                          <p><strong>Individus associés: </strong><span class="badge badge-success">0</span> </p>
                                       </div>
                                    </div>
                                    <div class="user-skill">
                                       <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                                       <a type="button" href="{{route('contact.edit', Crypt::encrypt($contact->id))}}" class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                       <a type="button" data-toggle="modal" data-target="#entite_attache_individu" class="btn btn-info btn-rounded btn-addon btn-xs m-b-10"><i class="ti-key"></i>Associer des individus</a>
                                       {{-- <a type="button" data-toggle="modal" data-target="#planifiate_usr" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10"><i class="ti-email"></i>Envoyer un email</a> --}}
                                    </div>
                                 </div>
                                 <div class="col-lg-8">
                                    <div class="user-profile-name" style="color: #d68300;">{{$contact->entite->raison_sociale}}</div>
                                    <div class="user-Location"><i class="ti-location-pin"></i> {{$contact->entite->ville}}</div>
                                    <div class="card p-0">
                                       <div class="media bg-primary">
                                          <div class="p-20 bg-info-dark media-left media-middle">
                                             <i class="ti-id-badge f-s-48 color-white"></i>
                                          </div>
                                          <div class="p-20 media-body">
                                             <h4 class="colcolor-white" style="color: white;"><strong>{{strtoupper ($contact->entite->type)}}</strong></h4>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="custom-tab user-profile-tab">
                                       <ul class="nav nav-tabs" role="tablist">
                                          <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                                       </ul>
                                       <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane active" id="1">
                                             <div class="contact-information">
                                                <div class="phone-content">
                                                   <span class="contact-title"><strong>Téléphone:</strong></span>
                                                   <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$contact->entite->telephone}}</span>
                                                </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Adresse:</strong></span>
                                                   <span class="mail-address">{{$contact->entite->adresse}}</span>
                                                </div>
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Code postal:</strong></span>
                                                   <span class="contact-website">{{$contact->entite->code_postal}}</span>
                                                </div>
                                                <div class="website-content">
                                                   <span class="contact-title"><strong>Ville:</strong></span>
                                                   <span class="contact-website">{{$contact->entite->ville}}</span>
                                                </div>
                                                <div class="email-content">
                                                   <span class="contact-title"><strong>Email:</strong></span>
                                                   <span class="contact-email" style="color: #ff435c; text-decoration: underline;">{{$contact->entite->email}}</span>
                                                </div>
                                             </div>
                                             <div class="basic-information">
                                                <h4 style="color: #32ade1;text-decoration: underline;">Informations juridiques</h4>
                                                <div class="birthday-content">
                                                   <span class="contact-title"><strong>Personnalité:</strong></span>
                                                   @if($contact->entite->sous_type === "personne_simple" || $contact->entite->sous_type === "couple")
                                                   <span class="birth-date"><span class="badge badge-success">{{$contact->entite->sous_type}}</span></span>
                                                   @else
                                                   <span class="birth-date"><span class="badge badge-warning">{{$contact->entite->sous_type}}</span></span>
                                                   @endif
                                                </div>
                                                <div class="gender-content">
                                                   <span class="contact-title"><strong>Ajout le:</strong></span>
                                                   <span class="gender">{{date('d-m-Y',strtotime($contact->entite->creation_le))}}</span>
                                                </div>
                                                @if($contact->entite->sous_type != "personne_simple" && $contact->entite->sous_type != "couple")
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Forme juridique:</strong></span>
                                                   <span class="mail-address">{{$contact->entite->forme_juridique}}</span>
                                                </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Numéro SIRET:</strong></span>
                                                   <span class="mail-address">{{$contact->entite->numero_siret}}</span>
                                                </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Numéro TVA:</strong></span>
                                                   <span class="mail-address">{{$contact->entite->numero_tva}}</span>
                                                </div>
                                                <div class="address-content">
                                                   <span class="contact-title"><strong>Numéro RCS:</strong></span>
                                                   <span class="mail-address">{{$contact->entite->numero_rcs}}</span>
                                                </div>
                                                @endif
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
            </div>
            <div class="col-lg-6">
               <div class="panel panel-danger lobipanel-basic">
                  <div class="panel-heading">Individus associés.</div>
                  <div class="panel-body">
                     <div class="table-responsive" style="overflow-x: inherit !important;">
                        <table  id="entite_individu" class=" table student-data-table  m-t-20 table-hover"  style="width:100%">
                           <thead>
                              <tr>
                                 <th>@lang('Civilite')</th>
                                 <th>@lang('Nom et prenom')</th>
                                 <th>@lang('Email')</th>
                                 <th>@lang('Action')</th>
                              </tr>
                           </thead>
                           <tbody>
                              {{-- @foreach($contact->entite->individus as $one)
                              <tr>
                                 <td style="border-top: 4px solid #b8c7ca;">
                                    <span class="badge badge-pink">{{$one->civilite}}</span>                                                
                                 </td>
                                 <td style="border-top: 4px solid #b8c7ca;">{{$one->nom}} {{$one->prenom}}</td>
                                 <td style="border-top: 4px solid #b8c7ca; color: #32ade1; text-decoration: underline;"><strong>{{$one->email}}</strong> </td>
                                 <td style="border-top: 4px solid #b8c7ca;">
                                    <span><a class="show1" href="{{route('contact.individu.show', CryptId($one->id))}}" title="@lang('Détails')"><i class="large material-icons color-info">visibility</i></a></span>
                                    <span><a href="{{route('contact.entite.dissociate', [CryptId($contact->entite->id), CryptId($one->id)])}}" class="dissociate_individu" data-toggle="tooltip" title="@lang('Dissocier')"><i class="large material-icons color-danger">clear</i></a></span>
                                 </td>
                              </tr>
                              @endforeach --}}
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include("components.contact.entite_edit")
@include("components.contact.attache_individu")
@stop
@section('js-content')
@if (session('ok') && session('ok') === "Entité ajoutée !")
<script>
   $(window).on('load',function(){
        $('#entite_attache_individu').modal('show');
    });
</script>
@endif
<script>
   $(document).ready(function() {
            $('#entite_individu').DataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                }
            } );
        } );
</script>
<script>
   $(document).ready(function() {
       ($('#type').val() === "fournisseur") ? $('#sect1').show() : $('#sect1').hide();
       $('#type').change(function(e){
           ($('#type').val() === "fournisseur") ? $('#sect1').show() : $('#sect1').hide();
       });
       if ($('#sous_type').val() === "personne_simple" || $('#sous_type').val() === "couple")
           $('#sect2').hide();
       else
           $('#sect2').show();
       $('#sous_type').change(function(e){
           if ($('#sous_type').val() === "personne_simple" || $('#sous_type').val() === "couple")
               $('#sect2').hide();
           else
               $('#sect2').show();
       });
       if ($('#type').val() === "acquereur" || $('#type').val() === "mandant" || $('#type').val() === "autre")
           $('#sect3').show();
       else{
           $('#sect3').hide();
           $('#sect2').show();
           $('#sous_type').val("personne_morale");
       }
       $('#type').change(function(e){
           if ($('#type').val() === "acquereur" || $('#type').val() === "mandant" || $('#type').val() === "autre")
           $('#sect3').show();
       else{
           $('#sect3').hide();
           $('#sect2').show();
           $('#sous_type').val("personne_morale");
       }
       });
   });
</script>
<script>
   $("#code_postal").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='code_postal']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
            var postcodes = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                    if ($.inArray(item.properties.city, postcodes) == -1) {
                        postcodes.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 city: item.properties.city,
                                 value: item.properties.postcode
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi la ville
    select: function(event, ui) {
        $('#ville').val(ui.item.city);
    }
   });
   $("#ville").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='ville']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                var cities = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                    if ($.inArray(item.properties.postcode, cities) == -1) {
                        cities.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 postcode: item.properties.postcode,
                                 value: item.properties.city
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi le CP
    select: function(event, ui) {
        $('#code_postal').val(ui.item.postcode);
    }
   });
   $("#adresse").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='code_postal']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                response($.map(data.features, function (item) {
                    return { label: item.properties.name, value: item.properties.name};
                }));
            }
        });
    }
   });
</script>
<script>
   $('a.dissociate_individu').click(function(b) {
   b.preventDefault();       
   let that = $(this);
   var route = that.attr('href');
   var reload = 1;
   var warning = 'L\'individu sera dissociée de l\'entite, continuer ?';
   processAjaxSwal(route, warning, reload);
   })
</script>
<!--ajax individu association-->
<script>
$(document).ready(function() {
   $('#ajax_individus').hide();
   $('#individu_tps').on('change', function(e){
      if($('#individu_tps').is(':checked')){
         $('#ajax_individus').show();
         $('#mvc55').hide()
      }
      else {
         $('#ajax_individus').hide();
         $('#mvc55').show();
      }
   });
});
$("#_code_postal").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='_code_postal']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
            var postcodes = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                    if ($.inArray(item.properties.city, postcodes) == -1) {
                        postcodes.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 city: item.properties.city,
                                 value: item.properties.postcode
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi la ville
    select: function(event, ui) {
        $('#_ville').val(ui.item.city);
    }
   });
   $("#_ville").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='_ville']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                var cities = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                    if ($.inArray(item.properties.postcode, cities) == -1) {
                        cities.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 postcode: item.properties.postcode,
                                 value: item.properties.city
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi le CP
    select: function(event, ui) {
        $('#_code_postal').val(ui.item.postcode);
    }
   });
   $("#_adresse").autocomplete({
    source: function (request, response) {
        $.ajax({
         beforeSend :  function () {},
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='_code_postal']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                response($.map(data.features, function (item) {
                    return { label: item.properties.name, value: item.properties.name};
                }));
            }
        });
    }
   });
$('#individus_check').on('click', function(e){
   e.preventDefault();
   var form = $('#form_vfc12');
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
         "_nom":{required: !0},
         "_prenom":{required: !0},
         "_date_naissance":{},
         "_adresse":{required: !0},
         "_code_postal":{required: !0, digits: !0, minlength: 5},
         "_ville":{required: !0},
         "_email":{required: !0, email: !0},
         "_telephone":{required: !0, digits: !0, minlength: 10}
      },
      messages: {
         "_nom":"il faut saisir un nom !",
         "_prenom":"il faut saisir un prénom !",
         "_date_naissance":"il faut saisir une date de naissance correcte !",
         "_adresse":"il faut saisir une adresse !",
         "_code_postal":"il faut saisir un code postal correct !",
         "_ville":"il faut saisir une ville !",
         "_email":"il faut saisir une adresse correcte !",
         "_telephone":"il faut saisir un numéro correct !"
      }
   });
   if (form.valid() === true){
      $.ajax({
         url: ("{{route('contact.individu.storeandattach', Crypt::encrypt($contact->entite->id))}}"),
         type: 'POST',
         data:{
            civilite: $('#_civilite').val(),
            nom: $('#_nom').val(),
            prenom: $('#_prenom').val(),
            date_naissance: $('#_date_naissance').val(),
            lieu_naissance: $('#_lieu_naissance').val(),
            adresse: $('#_adresse').val(),
            code_postal: $('#_code_postal').val(),
            ville: $('#_ville').val(),
            email: $('#_email').val(),
            telephone: $('#_telephone').val()
         }, 
         beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
               xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
               $('.pace').removeClass('pace-inactive');
            }
         },
         success: function(data){
            $('.pace').addClass('pace-inactive');
            var list = $('#lst_indv');
            var content = '<li class="list-group-item"> <strong><span class="badge badge-pink">'+$('#_civilite').val()+'</span> '+$('#_nom').val()+' '+$('#_prenom').val()+'</strong></li>';
            list.append(content);
            form.trigger('reset');
            swal('Effectué','Individu ajouté et attaché à l\'entité !','success');
         },
         error: function(data){
            $('.pace').addClass('pace-inactive');
            console.log(data);
            swal('Echec','Une erreur est survenue vérifiez votre saisie.','error');
         }
      })
   }
});
</script>
<!--fin ajax individus-->
@endsection
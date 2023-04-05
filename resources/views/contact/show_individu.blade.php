@extends('layouts.dashboard')
@extends('components.navbar')
@extends('components.header')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
                <div class="col-lg-6">
                        <div class="panel panel-warning lobipanel-basic">
                           <div class="panel-heading">Fiche individu.</div>
                           <div class="panel-body">
                              <div class="card alert">
                                 <div class="card-body">
                                    <div class="user-profile">
                                       <div class="row">
                                          <div class="col-lg-4">
                                             <div class="col-lg-12">
                                                <div class="user-photo m-b-30">
                                                        <i class="material-icons" style="font-size: 175px;color: #f0f0f0;background: #ab599c;border-radius: 27px;">person</i>
                                                </div>
                                             </div>
                                             <div class="user-work">
                                                <h4 style="color: #32ade1;text-decoration: underline;">Statistiques</h4>
                                                <div class="work-content">
                                                   <p><strong>Entités associées: </strong><span class="badge badge-pink">0</span> </p>
                                                </div>
                                             </div>
                                             <div class="user-skill">
                                                <h4 style="color: #32ade1;text-decoration: underline;">Options</h4>
                                                <a type="button" data-toggle="modal" data-target="#individu_edit" class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                                <a type="button" data-toggle="modal" data-target="#planifiate_usr" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10"><i class="ti-email"></i>Envoyer un email</a>
                                             </div>
                                          </div>
                                          <div class="col-lg-8">
                                             <div class="user-profile-name" style="color: #d68300;">{{$ret->civilite}} {{$ret->nom}} {{$ret->prenom}}</div>
                                             <div class="user-Location"><i class="ti-location-pin"></i> {{$ret->ville}}</div>
                                             <div class="custom-tab user-profile-tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                   <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                   <div role="tabpanel" class="tab-pane active" id="1">
                                                      <div class="contact-information">
                                                            <div class="address-content">
                                                                    <span class="contact-title"><strong>Date de naissance:</strong></span>
                                                                    <span class="gender">{{date('d-m-Y',strtotime($ret->date_naissance))}}</span>
                                                                 </div>
                                                         <div class="phone-content">
                                                            <span class="contact-title"><strong>Téléphone:</strong></span>
                                                            <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$ret->telephone}}</span>
                                                         </div>
                                                         <div class="email-content">
                                                                <span class="contact-title"><strong>Email:</strong></span>
                                                                <span class="contact-email" style="color: #ff435c; text-decoration: underline;">{{$ret->email}}</span>
                                                             </div>
                                                         <div class="address-content">
                                                            <span class="contact-title"><strong>Adresse:</strong></span>
                                                            <span class="mail-address">{{$ret->adresse}}</span>
                                                         </div>
                                                         <div class="website-content">
                                                            <span class="contact-title"><strong>Code postal:</strong></span>
                                                            <span class="contact-website">{{$ret->code_postal}}</span>
                                                         </div>
                                                         <div class="website-content">
                                                            <span class="contact-title"><strong>Ville:</strong></span>
                                                            <span class="contact-website">{{$ret->ville}}</span>
                                                         </div>
                                                         <div class="gender-content">
                                                                <span class="contact-title"><strong>Ajout le:</strong></span>
                                                                <span class="gender">{{date('d-m-Y',strtotime($ret->creation_le))}}</span>
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
                     </div>

                     <div class="col-lg-6">
                            <div class="panel panel-primary lobipanel-basic">
                                    <div class="panel-heading">Entités associés.</div>
                                    <div class="panel-body">
                                            <div class="table-responsive" style="overflow-x: inherit !important;">
                                                    <table  id="individu_entite" class=" table student-data-table  m-t-20 table-hover"  style="width:100%">
                                                            <thead>
                                                               <tr>
                                                                  <th>@lang('Type d\'entité')</th>
                                                                  <th>@lang('Raison sociale')</th>
                                                                  <th>@lang('Code_postal')</th>
                                                                  <th>@lang('Action')</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @foreach($ret->entites as $one)
                                                                 <tr>
                                                                   <td style="border-top: 4px solid #b8c7ca;">
                                                                         <span class="badge badge-danger">{{$one->type}}</span>                                                
                                                                      </td>
                                                                   <td style="border-top: 4px solid #b8c7ca;">{{$one->raison_sociale}}</td>
                                                                   <td style="border-top: 4px solid #b8c7ca; color: #32ade1; text-decoration: underline;"><strong>{{$one->code_postal}}</strong> </td>
                                                                   <td style="border-top: 4px solid #b8c7ca;">
                                                                     <span><a class="show1" href="{{route('contact.entite.show', CryptId($one->id))}}" title="@lang('Détails')"><i class="large material-icons color-info">visibility</i></a></span>
                                                                     <span><a href="{{route('contact.individu.dissociate', [CryptId($ret->id), CryptId($one->id)])}}" class="dissociate_entite" data-toggle="tooltip" title="@lang('Dissocier')"><i class="large material-icons color-danger">clear</i></a></span>
                                                                 </td>
                                                                 </tr>
                                                                   @endforeach
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
@include("components.contact.individu_edit")
@stop
@section('js-content')
<script>
$(document).ready(function() {
    $('#individu_entite').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    } );
} );
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
         $('a.dissociate_entite').click(function(b) {
      b.preventDefault();       
      let that = $(this);
      var route = that.attr('href');
      var reload = 1;
      var warning = 'L\'entité sera dissociée de l\'individu, continuer ?';
      processAjaxSwal(route, warning, reload);
   })
         </script>
@endsection
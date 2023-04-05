@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'un Contact
@endsection
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12">
       <div class="card alert">
          <a href="#" data-toggle="modal"  data-target="#entite_add" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-plus"></i>@lang('Ajouter')</a>
          <div class="card-body">

            <div class="form-validation">
                <form class="form-valide form-horizontal" action="{{ route('prospect.add') }}" method="post">
                   {{ csrf_field() }}
                    
                <div class="col-md-12 col-lg-12 col-sm-12 " style="background:#175081; color:white!important; padding:10px ">
                   <strong>Informations principales                         
                </div>
                <br>
                <br>
                <br>
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px">
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-md-2 col-sm-4 control-label" for="nature">@lang('Statut du contact') <span class="text-danger">*</span></label>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                               <select class="js-select2 form-control" id="nature" name="nature" style="width: 100%;" required>
                                                                 
                                  <option value="Propriétaire">Propriétaire</option>
                                  <option value="Acquereur">Acquereur</option>
                                  <option value="Locataire">Locataire</option>
                                  <option value="Partenaire">Partenaire</option>
                                  
                               </select>
                               @if ($errors->has('nature'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nature')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-3  ">
                        <div class="form-group ">
                            <label class="col-lg-8  col-md-8  col-sm-48 control-label" style="padding-top: 5px;" for="type_contact1">Personne seule <span class="text-danger">*</span></label>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                               <input type="radio" style="height: 22px;" class="form-control" id="type_contact1" name="type_contact" required>
                               @if ($errors->has('type_contact'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('type_contact')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-3  ">
           
                         <div class="form-group ">
                            <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact2">Personne morale <span class="text-danger">*</span></label>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                               <input type="radio" style="height: 22px;" class="form-control"  id="type_contact2" name="type_contact"  required>
                               @if ($errors->has('type_contact'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('type_contact')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-3 div_proprietaire ">
           
                        <div class="form-group ">
                           <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact3">Couple <span class="text-danger">*</span></label>
                           <div class="col-lg-2 col-md-2 col-sm-2">
                              <input type="radio" style="height: 22px;" class="form-control" id="type_contact3" name="type_contact" required>
                              @if ($errors->has('type_contact'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('type_contact')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                   </div>
                   <div class="col-lg-3 col-md-3 col-sm-3  ">
           
                        <div class="form-group ">
                           <label class="col-lg-8 col-md-8 col-sm-8 control-label" style="padding-top: 5px;" for="type_contact4">Groupe <span class="text-danger">*</span></label>
                           <div class="col-lg-2 col-md-2 col-sm-2">
                              <input type="radio" style="height: 22px;" class="form-control" id="type_contact4" name="type_contact" required>
                              @if ($errors->has('type_contact'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('type_contact')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                   </div>
                   
               
                </div>
                <div class="row">
                     <hr>
                    
                     <div class="col-lg-6 col-md-6 col-sm-6">
 
                   
        
                          <div class="form-group div_personne_seule">
                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                             <div class="col-lg-8 col-md-8 col-sm-8">
                                <select class="js-select2 form-control " id="civilite" name="civilite" style="width: 100%;" required>
                                   <option value="{{old('civilite')}}">{{old('civilite')}}</option>
                                   <option value="M">M</option>
                                   <option value="Mme">Mme</option>
                                </select>
                                @if ($errors->has('civilite'))
                                <br>
                                <div class="alert alert-warning ">
                                   <strong>{{$errors->first('civilite')}}</strong> 
                                </div>
                                @endif
                             </div>
                          </div>
        
                          <div class="form-group div_personne_seule">
                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span class="text-danger">*</span></label>
                             <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="text" class="form-control " value="{{old('nom')}}" id="nom" name="nom"  required>
                                @if ($errors->has('val-lastname'))
                                <br>
                                <div class="alert alert-warning ">
                                   <strong>{{$errors->first('nom')}}</strong> 
                                </div>
                                @endif
                             </div>
                          </div>
        
                          <div class="form-group div_personne_seule">
                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom <span class="text-danger">*</span></label>
                             <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="text"  class="form-control" value="{{old('prenom')}}" id="prenom" name="prenom"  required>
                                @if ($errors->has('val-firstname'))
                                <br>
                                <div class="alert alert-warning ">
                                   <strong>{{$errors->first('prenom')}}</strong> 
                                </div>
                                @endif
                             </div>
                          </div>
                          
                          <div class="form-group div_personne_morale">
                            <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="forme_juridique">Forme juridique<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <select class="js-select2 form-control" id="forme_juridique" name="forme_juridique" style="width: 100%;" required>
                                  <option value="{{old('forme_juridique')}}">{{old('forme_juridique')}}</option>
                                  
                                  <option value="Propriétaire">Propriétaire</option>
                                  <option value="Acquereur">Acquereur</option>
                                  <option value="Locataire">Locataire</option>
                                  <option value="Partenaire">Partenaire</option>
                                  
                               </select>
                               @if ($errors->has('forme_juridique'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('forme_juridique')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                          
                          <div class="form-group div_personne_morale">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="raison_sociale">Raison sociale <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text"  class="form-control" value="{{old('raison_sociale')}}" id="raison_sociale" name="raison_sociale"  required>
                               @if ($errors->has('raison_sociale'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('raison_sociale')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                        <div id="source_div">
                            <div class="form-group div_partenaire"  >
                             <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="metier">Métier</label>
                             <div class="col-lg-8">
                                     <select class="selectpicker col-lg-6" id="metier" name="metier" data-live-search="true" data-style="btn-warning btn-rounded">
                                        
                                      <option value="Collaborateur">Collaborateur </option>
                                      <option value="Fournisseur">Fournisseur </option>
                                      <option value="Diagnostiqueur">Diagnostiqueur </option>
                                      <option value="Promoteur">Promoteur </option>
                                     
                                      <option value="Autre">Autre</option>
                                        
                                     </select>
                                </div>
                             </div>
                        </div>
                  
                        
                        <div id="source_div">
                            <div class="form-group row" >
                             <label  class="col-lg-4 col-md-4 col-sm-4 control-label" for="source_id">Source du contact</label>
                             <div class="col-lg-8">
                                     <select class="selectpicker col-lg-6" id="source_id" name="source_id" data-live-search="true" data-style="btn-warning btn-rounded">
                                        
                                      <option value="Réseaux sociaux">Réseaux sociaux</option>
                                      <option value="Bouche à oreille">Bouche à oreille</option>
                                      <option value="Internet">Internet</option>
                                      <option value="Autre">Autre</option>
                                        
                                     </select>
                                </div>
                             </div>
                        </div>
                        
                         
 
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6">       
                       
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email_perso">Email <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control" id="val-email_perso" value="{{old('email')}}" name="email"  required>
                               @if ($errors->has('email'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('email')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         
                         <div class="form-group row">
                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_portable">Téléphone portable </label>
                             <div class="col-lg-8 col-md-8 col-sm-8">
                                <input type="text" class="form-control " value="{{old('telephone_portable')}}" id="telephone_portable"  name="telephone_portable"  >
                                @if ($errors->has('telephone_portable'))
                                <br>
                                <div class="alert alert-warning ">
                                   <strong>{{$errors->first('telephone_portable')}}</strong> 
                                </div>
                                @endif     
                             </div>
                         </div>
 
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone_fixe">Téléphone fixe </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control " value="{{old('telephone_fixe')}}" id="telephone_fixe" name="telephone_fixe"  >
                               @if ($errors->has('telephone_fixe'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('telephone_fixe')}}</strong> 
                               </div>
                               @endif     
                            </div>
 
                        </div>
                         
                                       
                         <div class="form-group div_personne_morale ">
                            <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_siret">Numéro siret</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" id="numero_siret" class="form-control " value="{{old('numero_siret')}}" name="numero_siret" >
                               @if ($errors->has('telephone'))
                               <br>
                               <div class="alert alert-warning ">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>{{$errors->first('telephone')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                         <div class="form-group div_personne_morale ">
                            <label class="col-lg-4 col-md-4 col-sm-4  control-label" for="numero_tva">Numéro TVA</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" id="numero_tva" class="form-control " value="{{old('numero_tva')}}" name="numero_tva" >
                               @if ($errors->has('numero_tva'))
                               <br>
                               <div class="alert alert-warning ">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>{{$errors->first('numero_tva')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
                          
                         
                         
                     </div>
                 </div>
                 
                 <div class="col-md-12 col-lg-12 col-sm-12 " style="background:#175081; color:white!important; padding:10px ">
                    <strong>Informations complémentaires (utiles pour générer des documents et des statistiques)  </strong>                  
                 </div>
                   
                 <br>
                 <br>
                 <br>
                   
                 <div class="row">
                    
                   
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse">Adresse </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control " value="{{old('adresse')}}" id="adresse" name="adresse"  >
                               @if ($errors->has('adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('adresse')}}</strong> 
                               </div>
                               @endif   
                            </div>
                         </div>
       
                       
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal">Code postal </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control" value="{{old('code_postal')}}" id="code_postal"  name="code_postal"  >
                               @if ($errors->has('code_postal'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('code_postal')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="ville">Ville </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control" value="{{old('ville')}}" id="ville" name="ville"  >
                               @if ($errors->has('ville'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('ville')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
                         
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="pays">Pays </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('pays') ? ' is-invalid' : '' }}" value="{{old('pays')}}" id="pays" name="pays" placeholder="Entez une lettre et choisissez.." >
                               @if ($errors->has('pays'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('pays')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
       
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                       
                      
                        
                        
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="note">Note</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                              <textarea name="note" id="note" class="form-control" cols="30" rows="5"> {{old('note')}}</textarea>
                               @if ($errors->has('note'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('note')}}</strong> 
                               </div>
                               @endif
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                
                   <div class="form-group row" style="text-align: center; margin-top: 50px;">
                      <div class="col-lg-8 ml-auto">
                         <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
                      </div>
                   </div>
                </form>
             </div>
            

          </div>
        </div>
    </div>
</div>
@include("components.contact.entite_add")
@stop
@section('js-content')
<script>
    $(document).ready(function() {
             $('#entitelist').DataTable( {
                 "language": {
                     "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                 }
             } );
         } );
    </script>
    
    
    <script>
        $(document).ready(function() {
            $(".div_proprietaire").show();
            $(".div_partenaire").hide();
                    
            $('#nature').change(function(e){
                let nature = e.currentTarget.value ;
                if( nature != "Partenaire"){
                    $(".div_proprietaire").show();
                    $(".div_partenaire").hide();
                }else{
                    $(".div_proprietaire").hide();
                    $(".div_partenaire").show();
                }
            });
        
            $("input[type='radio']").click(function(e){
                var radioValue = $("input[name='type_contact'][value='Couple']:checked").val();
                let type_contact= e.currentTarget.value ;
                
                console.log(radioValue);
            });
            
            div_personne_seule
        
        
        
        
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
        
        
        
        {{-- Auto complète adresses --}}
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
                function autocomplete(inp, arr) {
                  /*the autocomplete function takes two arguments,
                  the text field element and an array of possible autocompleted values:*/
                  var currentFocus;
                  /*execute a function when someone writes in the text field:*/
                  inp.addEventListener("input", function(e) {
                      var a, b, i, val = this.value;
                      /*close any already open lists of autocompleted values*/
                      closeAllLists();
                      if (!val) { return false;}
                      currentFocus = -1;
                      /*create a DIV element that will contain the items (values):*/
                      a = document.createElement("DIV");
                      a.setAttribute("id", this.id + "autocomplete-list");
                      a.setAttribute("class", "autocomplete-items");
                      /*append the DIV element as a child of the autocomplete container:*/
                      this.parentNode.appendChild(a);
                      /*for each item in the array...*/
                      for (i = 0; i < arr.length; i++) {
                        /*check if the item starts with the same letters as the text field value:*/
                        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                          /*create a DIV element for each matching element:*/
                          b = document.createElement("DIV");
                          /*make the matching letters bold:*/
                          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                          b.innerHTML += arr[i].substr(val.length);
                          /*insert a input field that will hold the current array item's value:*/
                          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                          /*execute a function when someone clicks on the item value (DIV element):*/
                          b.addEventListener("click", function(e) {
                              /*insert the value for the autocomplete text field:*/
                              inp.value = this.getElementsByTagName("input")[0].value;
                              /*close the list of autocompleted values,
                              (or any other open lists of autocompleted values:*/
                              closeAllLists();
                          });
                          a.appendChild(b);
                        }
                      }
                  });
                  /*execute a function presses a key on the keyboard:*/
                  inp.addEventListener("keydown", function(e) {
                      var x = document.getElementById(this.id + "autocomplete-list");
                      if (x) x = x.getElementsByTagName("div");
                      if (e.keyCode == 40) {
                        /*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
                        currentFocus++;
                        /*and and make the current item more visible:*/
                        addActive(x);
                      } else if (e.keyCode == 38) { //up
                        /*If the arrow UP key is pressed,
                        decrease the currentFocus variable:*/
                        currentFocus--;
                        /*and and make the current item more visible:*/
                        addActive(x);
                      } else if (e.keyCode == 13) {
                        /*If the ENTER key is pressed, prevent the form from being submitted,*/
                        e.preventDefault();
                        if (currentFocus > -1) {
                          /*and simulate a click on the "active" item:*/
                          if (x) x[currentFocus].click();
                        }
                      }
                  });
                  function addActive(x) {
                    /*a function to classify an item as "active":*/
                    if (!x) return false;
                    /*start by removing the "active" class on all items:*/
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    /*add class "autocomplete-active":*/
                    x[currentFocus].classList.add("autocomplete-active");
                  }
                  function removeActive(x) {
                    /*a function to remove the "active" class from all autocomplete items:*/
                    for (var i = 0; i < x.length; i++) {
                      x[i].classList.remove("autocomplete-active");
                    }
                  }
                  function closeAllLists(elmnt) {
                    /*close all autocomplete lists in the document,
                    except the one passed as an argument:*/
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                      if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                      }
                    }
                  }
                  /*execute a function when someone clicks in the document:*/
                  document.addEventListener("click", function (e) {
                      closeAllLists(e.target);
                      });
                }
                
                /*An array containing all the country names in the world:*/
                // var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
                
                var countries = ["Afghanistan","Afrique du Sud","Albanie","Algérie","Allemagne","Andorre","Angola","Anguilla","Arabie Saoudite","Argentine","Arménie","Australie","Autriche","Azerbaidjan","Bahamas","Bangladesh","Barbade","Bahrein","Belgique","Bélize","Bénin","Biélorussie","Bolivie","Botswana","Bhoutan","Boznie-Herzégovine","Brésil","Brunei","Bulgarie","Burkina Faso","Burundi","Cambodge","Cameroun","Canada","Cap-Vert","Chili","Chine","Chypre","Colombie","Comores","République du Congo","République Démocratique du Congo","Corée du Nord","Corée du Sud","Costa Rica","Côte d’Ivoire","Croatie","Cuba","Danemark","Djibouti","Dominique","Egypte","Emirats Arabes Unis","Equateur","Erythrée","Espagne","Estonie","Etats-Unis d’Amérique","Ethiopie","Fidji","Finlande","France","Gabon","Gambie","Géorgie","Ghana","Grèce","Grenade","Guatémala","Guinée","Guinée Bissau","Guinée Equatoriale","Guyana","Haïti","Honduras","Hongrie","Inde","Indonésie","Iran","Iraq","Irlande","Islande","Israël","italie","Jamaïque","Japon","Jordanie","Kazakhstan","Kenya","Kirghizistan","Kiribati","Koweït","Laos","Lesotho","Lettonie","Liban","Liberia","Liechtenstein","Lituanie","Luxembourg","Lybie","Macédoine","Madagascar","Malaisie","Malawi","Maldives","Mali","Malte","Maroc","Marshall","Maurice","Mauritanie","Mexique","Micronésie","Moldavie","Monaco","Mongolie","Mozambique","Namibie","Nauru","Nepal","Nicaragua","Niger","Nigéria","Nioué","Norvège","Nouvelle Zélande","Oman","Ouganda","Ouzbékistan","Pakistan","Palau","Palestine","Panama","Papouasie Nouvelle Guinée","Paraguay","Pays-Bas","Pérou","Philippines","Pologne","Portugal","Qatar","République centrafricaine","République Dominicaine","République Tchèque","Roumanie","Royaume Uni","Russie","Rwanda","Saint-Christophe-et-Niévès","Sainte-Lucie","Saint-Marin","Saint-Vincent-et-les Grenadines","Iles Salomon","Salvador","Samoa Occidentales","Sao Tomé et Principe","Sénégal","Serbie","Seychelles","Sierra Léone","Singapour","Slovaquie","Slovénie","Somalie","Soudan","Sri Lanka","Suède","Suisse","Suriname","Swaziland","Syrie","Tadjikistan","Taiwan","Tanzanie","Tchad","Thailande","Timor Oriental","Togo","Tonga","Trinité et Tobago","Tunisie","Turkménistan","Turquie","Tuvalu","Ukraine","Uruguay","Vanuatu","Vatican","Vénézuela","Vietnam","Yemen","Zambie","Zimbabwe"]
                /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
                autocomplete(document.getElementById("pays"), countries);
             </script>
             
@endsection
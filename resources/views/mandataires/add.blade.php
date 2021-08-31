@extends('layouts.app')
@section('content')
@section ('page_title')
Ajout d'un mandataire
@endsection
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      @if (session('ok'))
      <div class="alert alert-success alert-dismissible fade in">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong> {{ session('ok') }}</strong>
      </div>
      @endif      
      <div class="card">
         <div class="col-lg-12">
            <a href="{{route('mandataire.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('Liste des mandataires')</a>
         </div>
         <div class="card-body">
            <div class="form-validation">
               <form class="form-valide form-horizontal" action="{{ route('mandataire.add') }}" method="post">
                  {{ csrf_field() }}

                <div class="row">
                    <hr>
                    <hr>
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="statut">Statut <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <select class="js-select2 form-control {{$errors->has('statut') ? 'is-invalid' : ''}}" id="statut" name="statut" style="width: 100%;" data-placeholder="Choose one.." required>
                                  <option value="{{old('statut')}}">{{old('statut')}}</option>
                                  <option value="independant">indépendant</option>
                                  <option value="auto-entrepreneur">auto Entrepreneur</option>
                                  <option value="portage-salarial">portage Salarial</option>
                               </select>
                               @if ($errors->has('statut'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('statut')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="civilite">@lang('Civilité') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <select class="js-select2 form-control {{$errors->has('civilite') ? 'is-invalid' : ''}}" id="civilite" name="civilite" style="width: 100%;" data-placeholder="Choose one.." required>
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
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="nom">Nom <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{$errors->has('nom') ? 'is-invalid' : ''}}" value="{{old('nom')}}" id="nom" name="nom" placeholder="Nom.." required>
                               @if ($errors->has('val-lastname'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('nom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prenom">Prénom <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text"  class="form-control {{ $errors->has('prenom') ? ' is-invalid' : '' }}" value="{{old('prenom')}}" id="prenom" name="prenom" placeholder="Prénom.." required>
                               @if ($errors->has('val-firstname'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('prenom')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email">Email pro<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="val-email" value="{{old('email')}}" name="email" placeholder="Email.." required>
                               @if ($errors->has('email'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('email')}}</strong> 
                               </div>
                               @endif
                            </div>
                         </div>

                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="val-email_perso">Email perso<span class="text-danger">*</span></label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('email_perso') ? ' is-invalid' : '' }}" id="val-email_perso" value="{{old('email_perso')}}" name="email_perso" placeholder="Email.." required>
                              @if ($errors->has('email_perso'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('email_perso')}}</strong> 
                              </div>
                              @endif
                           </div>
                        </div>
                         <div class="form-group row">
                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="siret">Numéro SIRET </label>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                 <input type="text" class="form-control {{ $errors->has('siret') ? ' is-invalid' : '' }}" value="{{old('siret')}}" id="siret" name="siret" placeholder="Ex: 2561452136582"  >
                                 @if ($errors->has('siret'))
                                    <br>
                                    <div class="alert alert-warning ">
                                       <strong>{{$errors->first('siret')}}</strong> 
                                    </div>
                                 @endif     
                              </div>
                        </div>
                        <div class="form-group row">
                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="numero_tva">Numéro TVA intracommunautaire </label>
                              <div class="col-lg-8 col-md-8 col-sm-8">
                                 <input type="text" class="form-control {{ $errors->has('numero_tva') ? ' is-invalid' : '' }}" value="{{old('numero_tva')}}" id="numero_tva" name="numero_tva"  >
                                 @if ($errors->has('numero_tva'))
                                    <br>
                                    <div class="alert alert-warning ">
                                       <strong>{{$errors->first('numero_tva')}}</strong> 
                                    </div>
                                 @endif     
                              </div>
                        </div>
                       

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="adresse">Adresse </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('adresse') ? ' is-invalid' : '' }}" value="{{old('adresse')}}" id="adresse" name="adresse" placeholder="N° et Rue.." >
                               @if ($errors->has('adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('adresse')}}</strong> 
                               </div>
                               @endif   
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" value="" for="compl_adresse">Complément d'adresse</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" id="compl_adresse" class="form-control {{ $errors->has('compl_adresse') ? ' is-invalid' : '' }}" value="{{old('compl_adresse')}}" name="compl_adresse" placeholder="Complément d'adresse..">
                               @if ($errors->has('compl_adresse'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('compl_adresse')}}</strong> 
                               </div>
                               @endif 
                            </div>
                         </div>
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_postal">Code postal</label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('code_postal') ? ' is-invalid' : '' }}" value="{{old('code_postal')}}" id="code_postal" name="code_postal" placeholder="Ex: 75001.." >
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
                               <input type="text" class="form-control {{ $errors->has('ville') ? ' is-invalid' : '' }}" value="{{old('ville')}}" id="ville" name="ville" placeholder="EX: Paris.." >
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
       
                         <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone1">Téléphone pro  </label>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                               <input type="text" class="form-control {{ $errors->has('telephone1') ? ' is-invalid' : '' }}" value="{{old('telephone1')}}" id="telephone1" name="telephone1" placeholder="Ex: 0600000000.." >
                               @if ($errors->has('telephone1'))
                               <br>
                               <div class="alert alert-warning ">
                                  <strong>{{$errors->first('telephone1')}}</strong> 
                               </div>
                               @endif     
                            </div>
                         </div>

                         <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="telephone2">Téléphone perso </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('telephone2') ? ' is-invalid' : '' }}" value="{{old('telephone2')}}" id="telephone2" name="telephone2" placeholder="Ex: 0600000000.." >
                              @if ($errors->has('telephone2'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('telephone2')}}</strong> 
                              </div>
                              @endif     
                           </div>

                        </div>
                        
                        <div class="form-group row">
                           <span class="text-danger"> <strong>  (4 premières lettres du NOM et 1ere lettre du prénom ) </strong></span> 

                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_client">WINFIC Code client <span>*</span> </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('code_client') ? ' is-invalid' : '' }}" value="{{old('code_client')}}" id="code_client" name="code_client" required placeholder="" >
                              @if ($errors->has('code_client'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('code_client')}}</strong> 
                              </div>
                              @endif     
                           </div>

                        </div>
                        <div class="form-group row">
                           <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="code_analytic">WINFIC Code analytique  <span>*</span> </label>
                           <div class="col-lg-8 col-md-8 col-sm-8">
                              <input type="text" class="form-control {{ $errors->has('code_analytic') ? ' is-invalid' : '' }}" value="{{old('code_analytic')}}" id="code_analytic" name="code_analytic" required placeholder="" >
                              @if ($errors->has('code_analytic'))
                              <br>
                              <div class="alert alert-warning ">
                                 <strong>{{$errors->first('code_analytic')}}</strong> 
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


@stop
@section('js-content') 

<script>
 $('#nom').keyup(function(){
        $(this).val($(this).val().toUpperCase());
 });
 $('#ville').keyup(function(){
        $(this).val($(this).val().toUpperCase());
 });

 $('#prenom').on('focusout',function(){
      //   $(this).val( $(this).val().chartAt(0).toUpperCase());
      var prenom = $(this).val(); 
      tab  = prenom.split(" ");
      var prenoms = "";
      tab.forEach(element => {

         first = ""+element.substring(0,1);
         first=first.toUpperCase();

         second = element.substring(1,);

         prenoms+= first+second+" ";
      });
      $(this).val(prenoms);
      // console.log(tab);
      
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
   var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
   
   /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
   autocomplete(document.getElementById("pays"), countries);
</script>

@endsection
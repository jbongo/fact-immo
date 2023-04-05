
    <br>
    <br>
    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Particularités ')</h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-minus"></i>&nbsp;</button>
        </div>        
    </div>
    <hr>
    <div class="row" >
        <div class="col-md-12 col-lg-12">
            <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="particularite_particularite">@lang('Particularités') </label>
                    <div class="col-lg-6">
                        <select class="js-select2 form-control" id="particularite_particularite" name="particularite_particularite" style="width: 100%;">
                            <option value="Non défini">@lang('Non défini') </option>
                            <option value="Investissement">@lang('Investissement') </option>
                            <option value="Prestige">@lang('Prestige') </option>
                            <option value="Autre">@lang('Autre') </option>
                        </select>  
                    </div>
            </div>
                            
        </div>

    </div>

        <div class="row">
            <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                    <h4> @lang('Agencement Intérieur ')</h4>                          
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                    <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_agi" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
            </div>        
        </div>
        <hr>

        <div class="row" id="div_agencement_interieur">

                <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_chambre_agencement_interieur">@lang('Nombre de chambres') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_chambre_agencement_interieur" name="nb_chambre_agencement_interieur" placeholder="" > 
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4   col-form-label" for="nb_salle_bain_agencement_interieur">@lang('Nombre de salles de bain') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control "  id="nb_salle_bain_agencement_interieur" name="nb_salle_bain_agencement_interieur" placeholder="" > 
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_salle_eau_agencement_interieur">@lang('Nombre de salles d\'eau') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_salle_eau_agencement_interieur" name="nb_salle_eau_agencement_interieur" placeholder="" > 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_wc_agencement_interieur">@lang('Nombre de WC') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_wc_agencement_interieur" name="nb_wc_agencement_interieur" placeholder="" > 
                            </div>
                        </div>

                    {{-- div pour afficher ou masquer ce bloc--}}
                     <div id="agencement_interieur_plus"> 

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_lot_agencement_interieur">@lang('Nombre de lots') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_lot_agencement_interieur" name="nb_lot_agencement_interieur" placeholder="" > 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_couchage_agencement_interieur">@lang('Nombre de couchages') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_couchage_agencement_interieur" name="nb_couchage_agencement_interieur" placeholder="" > 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4   col-form-label" for="nb_niveau_agencement_interieur">@lang('Nombre de niveaux') </label>
                            <div class="col-lg-6 col-md-6">
                            <input type="number" min="0" class="form-control "  id="nb_niveau_agencement_interieur" name="nb_niveau_agencement_interieur" placeholder="" > 
                            </div>
                        </div>


                        <div class=" form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">@lang('Grenier / combles') </label>
                            <div class="col-lg-6 col-md-6">
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="grenier_comble_agencement_interieur" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="grenier_comble_agencement_interieur" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="grenier_comble_agencement_interieur">@lang('Non')</label>
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">@lang('Buanderie') </label>
                            <div class="col-lg-6 col-md-6">
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="buanderie_agencement_interieur" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="buanderie_agencement_interieur" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="buanderie_agencement_interieur">@lang('Non')</label>
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">@lang('Meublé') </label>
                            <div class="col-lg-6 col-md-6">
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="meuble_agencement_interieur" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="meuble_agencement_interieur" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="meuble_agencement_interieur">@lang('Non')</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-6">

                    <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="surface_carrez_agencement_interieur">@lang('Surface') </label>
                            <div class="col-lg-6 col-md-6">                           
                                
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_carrez_agencement_interieur">@lang('Carrez (m²)') </label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="number" min="0" class="form-control " value="" id="surface_carrez_agencement_interieur" name="surface_carrez_agencement_interieur" > 
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_habitable_agencement_interieur">@lang('Habitable (m²)') </label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="number" min="0" class="form-control " value="" id="surface_habitable_agencement_interieur" name="surface_habitable_agencement_interieur" > 
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_sejour_agencement_interieur">@lang('Séjour (m²)') </label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="number" min="0" class="form-control " value="" id="surface_sejour_agencement_interieur" name="surface_sejour_agencement_interieur" > 
                                        </div>
                                    </div>                                    
                                </div>
                               
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="cuisine_type_agencement_interieur">@lang('Cuisine') </label>
                                <div class="col-lg-6 col-md-6">                           
                                    
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="cuisine_type_agencement_interieur">@lang('Type') </label>
                                            <div class="col-lg-8 col-md-8">
                                                <select class="js-select2 form-control" id="cuisine_type_agencement_interieur" name="cuisine_type_agencement_interieur" style="width: 100%;">
                    
                                                    <option value="Non défini">@lang('Non défini') </option>
                                                    <option value="Américaine">@lang('Américaine') </option>
                                                    <option value="Kitchnette">@lang('Kitchenette') </option>
                                                    <option value="Séparée">@lang('Séparée') </option>
                                                    <option value="Sans">@lang('Sans') </option>
                                                </select>  
                                                
                                            </div>
                                        </div>                                 
                                    </div>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="cuisine_etat_agencement_interieur">@lang('Etat') </label>
                                            <div class="col-lg-8 col-md-8">
                                                <select class="js-select2 form-control" id="cuisine_etat_agencement_interieur" name="cuisine_etat_agencement_interieur" style="width: 100%;">
                    
                                                    <option value="Non défini">@lang('Non défini') </option>
                                                    <option value="Sémi-équipée">@lang('Sémi-équipée') </option>
                                                    <option value="Equipée">@lang('Equipée') </option>                                                    
                                                </select>  
                                                
                                            </div>
                                        </div>                                 
                                    </div>
             
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="situation_exposition_agencement_interieur">@lang('Situation') </label>
                                <div class="col-lg-6 col-md-6">                           
                                    
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="situation_exposition_agencement_interieur"> @lang('Exposition') </label>
                                            <div class="col-lg-8 col-md-8">
                                                    <select class="js-select2 form-control" id="situation_exposition_agencement_interieur" name="situation_exposition_agencement_interieur" style="width: 100%;"  >
                                                            <option value="Non définie">@lang('Non définie') </option>
                                                            <option value="Nord">@lang('Nord') </option>
                                                            <option value="Nord-Est">@lang('Nord-Est') </option>                   
                                                            <option value="Est">@lang('Est') </option>                   
                                                            <option value="Sud-Est">@lang('Sud-Est') </option>                   
                                                            <option value="Sud">@lang('Sud') </option>                   
                                                            <option value="Sud-Ouest">@lang('Sud-Ouest') </option>                   
                                                            <option value="Ouest">@lang('Ouest') </option>                   
                                                            <option value="Nord-Ouest">@lang('Nord-Ouest') </option>                   
                                                            <option value="Nord-Sud">@lang('Nord-Sud') </option>                   
                                                            <option value="Est-Ouest">@lang('Est-Ouest') </option>                             
                                                    </select>
                                            </div>
                                        </div>                           
                                    </div>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="situation_vue_agencement_interieur">@lang('Vue')</label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="text" class="form-control " id="situation_vue_agencement_interieur" name="situation_vue_agencement_interieur"  >
                                            </div>
                                        </div>                                    
                                    </div>
       
                                </div>
                            </div>
                            <br>
                </div>

                <hr>
                    <h4><span class="btn btn-warning" id="agencement_interieur_btn_plus" > <a> @lang('afficher plus')</a></span></h4>
                <hr>
        </div>

<br>

    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Agencement Extérieur ') </h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_age" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>
    <hr>
    <hr>




    
    <div class="row" id="div_agencement_exterieur">
            <div class="col-md-6 col-lg-6">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="mitoyennete_agencement_exterieur">@lang('Mitoyenneté') </label>
                        <div class="col-lg-8 col-md-8">
                            <select class="js-select2 form-control" id="mitoyennete_agencement_exterieur" name="mitoyennete_agencement_exterieur" style="width: 100%;">

                                <option value="Non précisé">@lang('Non précisé') </option>
                                <option value="Indépendant">@lang('Indépendant') </option>
                                <option value="1 côté">@lang('1 côté') </option>                                                    
                                <option value="2 côtés">@lang('2 côtés') </option>                                                    
                                <option value="3 côtés">@lang('3 côtés') </option>                                                    
                                <option value="4 côtés">@lang('4 côtés') </option>                                                    
                                                                                
                            </select>  
                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="etages_agencement_exterieur">@lang('Etages') </label>
                        <div class="col-lg-8 col-md-8">
                            <input type="number" min="0" class="form-control " value="" id="etages_agencement_exterieur" name="etages_agencement_exterieur" > 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="terrasse_agencement_exterieur">@lang('Terrasse') </label>
                        <div class="col-lg-8 col-md-8">                    
                            <div class="row">
                                <div class=" form-group row">
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="terrasse_agencement_exterieur" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="terrasse_agencement_exterieur" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="terrasse_agencement_exterieur">@lang('Non')</label>
                                </div>                                    
                                    
                                </div>
                                {{-- Affiche ou masque la zone --}}
                                <div id="terrasse_oui_agencement_exterieur">                          
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="nombre_terrasse_agencement_exterieur">@lang('Nombre') </label>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="number" min="0" class="form-control " value="" id="nombre_terrasse_agencement_exterieur" name="nombre_terrasse_agencement_exterieur" placeholder=""> 
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_terrasse_agencement_exterieur">@lang('Surface (m²)') </label>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="number" min="0" class="form-control " value="" id="surface_terrasse_agencement_exterieur" name="surface_terrasse_agencement_exterieur" placeholder=""> 
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            </div>                           
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="plain_pied_agencement_exterieur">@lang('Plain pied') </label>
                        <div class="col-lg-6 col-md-6">                  
                            <div class="row">
                                <div class=" form-group row">
                                    <div class="col-lg-10 col-md-10">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="plain_pied_agencement_exterieur" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="plain_pied_agencement_exterieur" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="plain_pied_agencement_exterieur">@lang('Non')</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="sous_sol_agencement_exterieur">@lang('Sous sol') </label>
                        <div class="col-lg-8 col-md-8">
                            <select class="js-select2 form-control" id="sous_sol_agencement_exterieur" name="sous_sol_agencement_exterieur" style="width: 100%;">

                                <option value="Non précisé">@lang('Non précisé') </option>
                                <option value="Sans">@lang('Sans') </option>
                                <option value="Avec">@lang('Avec') </option>                                                    
                                <option value="Avec et amenagé">@lang('Avec et amenagé') </option>                                                                                          
                            </select> 
                        </div>
                    </div> 
                    
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_jardin_agencement_exterieur">@lang('Jardin') </label>
                        <div class="col-lg-6 col-md-6">                           
                            
                            <div class="row">                                         
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-form-label" for="surface_jardin_agencement_exterieur">@lang('Surface (m²)') </label>
                                    <div class="col-lg-8 col-md-8">
                                        <input type="number" min="0" class="form-control " value="" id="surface_jardin_agencement_exterieur" name="surface_jardin_agencement_exterieur" placeholder=""> 
                                    </div>
                                </div>                                    
                            </div>
                            <div class="row">
                                <div class=" form-group row">
                                    <label class="col-lg-4 col-md-4 col-form-label">@lang('Privatif') </label>
                                    <div class="col-lg-8 col-md-8">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="privatif_jardin_agencement_exterieur" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="privatif_jardin_agencement_exterieur" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="privatif_jardin_agencement_exterieur">@lang('Non')</label>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                        </div>
                    </div>
                {{-- div pour afficher ou masquer ce bloc--}}
                <div id="agencement_exterieur_plus"> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="type_cave_agencement_exterieur">@lang('Cave') </label>
                        <div class="col-lg-8 col-md-8">                    
                            <div class="row">
                                <div class=" form-group row">
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="type_cave_agencement_exterieur" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="type_cave_agencement_exterieur" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="type_cave_agencement_exterieur">@lang('Non')</label>
                                </div>                                    
                                    
                                </div>
                                {{-- Affiche ou masque la zone --}}
                                <div id="type_cave_oui_agencement_exterieur"> 

                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_cave_agencement_exterieur">@lang('Surface (m²)') </label>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="number" min="0" class="form-control " value="" id="surface_cave_agencement_exterieur" name="surface_cave_agencement_exterieur" placeholder=""> 
                                        </div>
                                    </div>                                    
                                </div>
                                </div>
                            </div>                           
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="balcon_agencement_exterieur">@lang('Balcon') </label>
                        <div class="col-lg-8 col-md-8">                    
                            <div class="row">
                                <div class=" form-group row">
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="balcon_agencement_exterieur" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="balcon_agencement_exterieur" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="balcon_agencement_exterieur">@lang('Non')</label>
                                </div>                                    
                                    
                                </div>
                                 {{-- Affiche ou masque la zone --}}
                                <div id="balcon_oui_agencement_exterieur"> 
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="nb_balcon_agencement_exterieur">@lang('Nombre') </label>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="number" min="0" class="form-control " value="" id="nb_balcon_agencement_exterieur" name="nb_balcon_agencement_exterieur" placeholder=""> 
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="surface_balcon_agencement_exterieur">@lang('Surface (m²)') </label>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="number" min="0" class="form-control " value="" id="surface_balcon_agencement_exterieur" name="surface_balcon_agencement_exterieur" placeholder=""> 
                                        </div>
                                    </div>                                    
                                </div>
                                </div>
                            </div>                           
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="loggia_agencement_exterieur">@lang('Loggia') </label>
                        <div class="col-lg-6 col-md-6">                    
                            <div class="row">
                                <div class=" form-group row">
                                    <div class="col-lg-10 col-md-10">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="loggia_agencement_exterieur" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="loggia_agencement_exterieur" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="loggia_agencement_exterieur">@lang('Non')</label>
                                    </div>
                                </div>
                            </div>
                            {{-- Affiche ou masque la zone --}}
                            <div id="loggia_oui_agencement_exterieur"> 
                            <div class="row">                                         
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-form-label" for="surface_loggia_agencement_exterieur">@lang('Surface (m²)') </label>
                                    <div class="col-lg-8 col-md-8">
                                        <input type="number" min="0" class="form-control " value="" id="surface_loggia_agencement_exterieur" name="surface_loggia_agencement_exterieur" placeholder=""> 
                                    </div>
                                </div>                                    
                            </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="veranda_agencement_exterieur">@lang('Véranda') </label>
                        <div class="col-lg-6 col-md-6">                  
                            <div class="row">
                                <div class=" form-group row">
                                    <div class="col-lg-10 col-md-10">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="veranda_agencement_exterieur" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="veranda_agencement_exterieur" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="veranda_agencement_exterieur">@lang('Non')</label>
                                    </div>
                                </div>
                            </div>
                            {{-- Affiche ou masque la zone --}}
                            <div id="veranda_oui_agencement_exterieur">
                            <div class="row">                                         
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-form-label" for="surface_veranda_agencement_exterieur">@lang('Surface (m²)') </label>
                                    <div class="col-lg-8 col-md-8">
                                        <input type="number" min="0" class="form-control " value="" id="surface_veranda_agencement_exterieur" name="surface_veranda_agencement_exterieur" placeholder=""> 
                                    </div>
                                </div>                                    
                            </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="nombre_garage_agencement_exterieur">@lang('Garage') </label>
                    <div class="col-lg-6 col-md-6">                           
                        
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nombre_garage_agencement_exterieur">@lang('Nombre') </label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " value="" id="nombre_garage_agencement_exterieur" name="nombre_garage_agencement_exterieur" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="surface_garage_agencement_exterieur">@lang('Surface (m²)') </label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " value="" id="surface_garage_agencement_exterieur" name="surface_garage_agencement_exterieur" > 
                                </div>
                            </div>                                    
                        </div>                       
                        <hr>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="parking_interieur_agencement_exterieur">@lang('Parkings') </label>
                    <div class="col-lg-6 col-md-6">                           
                        
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="parking_interieur_agencement_exterieur">@lang('Intérieurs') </label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " value="" id="parking_interieur_agencement_exterieur" name="parking_interieur_agencement_exterieur" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="parking_exterieur_agencement_exterieur">@lang('Extérieurs') </label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " value="" id="parking_exterieur_agencement_exterieur" name="parking_exterieur_agencement_exterieur" > 
                                </div>
                            </div>                                    
                        </div>                       
                        <hr>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="statut_piscine_agencement_exterieur">@lang('Piscine') </label>
                    <div class="col-lg-6 col-md-6">                           
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="statut_piscine_agencement_exterieur">@lang('Statut') </label>
                                <div class="col-lg-8 col-md-8">
                                    <select class="js-select2 form-control" id="statut_piscine_agencement_exterieur" name="statut_piscine_agencement_exterieur" style="width: 100%;">
        
                                        <option value="Non défini">@lang('Non défini') </option>
                                        <option value="Privative">@lang('Privative') </option>
                                        <option value="Collective">@lang('Collective') </option>                                                    
                                        <option value="Collective surveillée">@lang('Collective surveillée') </option>                                                    
                                    </select>  
                                    
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                                  
                                <div class="form-group row">
                                    <label class="col-lg-4 col-md-4 col-form-label" for="dimension_piscine_agencement_exterieur">@lang('Dimensions') </label>
                                    <div class="col-lg-8 col-md-8">
                                        <input type="text"  class="form-control " value="" id="dimension_piscine_agencement_exterieur" name="dimension_piscine_agencement_exterieur" > 
                                    </div>
                                </div>                                                                      
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="volume_piscine_agencement_exterieur">@lang('Volume') (m<sup>3</sup>) </label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " value="" id="volume_piscine_agencement_exterieur" name="volume_piscine_agencement_exterieur" > 
                                </div>
                            </div>                                    
                        </div>
                            
                        <hr>
                    </div>
                </div>
                <br>
            </div>
            
            <hr>
            <h4><span class="btn btn-warning" id="agencement_exterieur_btn_plus" > <a> @lang('afficher plus')</a></span></h4>
            <hr>
    </div>
    
    

    <br>

    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Terrain') </h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_terr" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>
    <hr>


    <div class="row" id="div_terrain">

            <div class="col-md-6 col-lg-6">
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4   col-form-label" for="surface_terrain">@lang('Surface terrain') </label>
                        <div class="col-lg-6 col-md-6">
                        <input type="number" min="0" class="form-control "  id="surface_terrain" name="surface_terrain" placeholder="" > 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="constructible_terrain">@lang('Constructible') </label>
                        <div class="col-lg-6 col-md-6">                           
                            
                            <div class="row">
                                <div class=" form-group row">                                   
                                    <div class="col-lg-10 col-md-10">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="constructible_terrain" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="constructible_terrain" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="constructible_terrain">@lang('Non')</label>
                                    </div>
                                </div>
                            </div>
                            {{-- Affiche ou masque la zone --}}
                            <div id="constructible_oui_terrain">
                            <div class="row">                                         
                                <div class="form-group row">
                                    <label class="col-lg-5 col-md-5 col-form-label" for="surface_constructible_terrain">@lang('Surface (m²)') </label>
                                    <div class="col-lg-7 col-md-7">
                                        <input type="number" min="0" class="form-control " value="" id="surface_constructible_terrain" name="surface_constructible_terrain" > 
                                    </div>
                                </div>                                    
                            </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="topographie_terrain">@lang('Topographie') </label>
                        <div class="col-lg-8 col-md-8">
                            <select class="js-select2 form-control" id="topographie_terrain" name="topographie_terrain" style="width: 100%;">

                                <option value="Non défini">@lang('Non défini') </option>
                                <option value="Plat">@lang('Plat') </option>
                                <option value="En pente">@lang('En pente') </option>                                                    
                                <option value="A aménager">@lang('A amenager') </option>                                                    
                            </select>  
                            
                        </div>
                    </div>     
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="emprise_au_sol_terrain">@lang('Emprise au sol')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="emprise_au_sol_terrain" name="emprise_au_sol_terrain"  >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="emprise_au_sol_residuelle_terrain">@lang('Emprise au sol Résiduelle')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="emprise_au_sol_residuelle_terrain" name="emprise_au_sol_residuelle_terrain"  >
                        </div>
                    </div>
                 {{-- div pour afficher ou masquer ce bloc--}}
                 <div id="terrain_div1_plus"> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="shon_terrain">@lang('SHON')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="shon_terrain" name="shon_terrain"  >
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="ces_terrain">@lang('CES')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="ces_terrain" name="ces_terrain"  >
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="pos_terrain">@lang('POS')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="pos_terrain" name="pos_terrain"  >
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="codification_plu_terrain">@lang('Codification PLU')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="codification_plu_terrain" name="codification_plu_terrain"  >
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="droit_de_passage_terrain">@lang('Droit de passage')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="droit_de_passage_terrain" name="droit_de_passage_terrain"  >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="reference_cadastrale_terrain">@lang('Référence cadastrale')</label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" class="form-control "  id="reference_cadastrale_terrain" name="reference_cadastrale_terrain"  >
                        </div>
                    </div>
                 </div>


            </div>

            <div class="col-md-6 col-lg-6">

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="piscinable_terrain">@lang('Piscinable') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="piscinable_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="piscinable_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="piscinable_terrain">@lang('Non')</label>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="arbore_terrain">@lang('Arboré') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="arbore_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="arbore_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="arbore_terrain">@lang('Non')</label>
                    </div>
                </div><hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="viabilise_terrain">@lang('Viabilisé') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="viabilise_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="viabilise_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="viabilise_terrain">@lang('Non')</label>
                    </div>
                </div> <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Cloturé') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="cloture_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="cloture_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="cloture_terrain">@lang('Non')</label>
                    </div>
                </div>     
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Divisible') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="divisible_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="divisible_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="divisible_terrain">@lang('Non')</label>
                    </div>
                </div>     <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Possibilité de tout à l\'égout') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="possiblite_egout_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="possiblite_egout_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="possiblite_egout_terrain">@lang('Non')</label>
                    </div>
                </div>     
                <hr>
            {{-- div pour afficher ou masquer ce bloc--}}
            <div id="terrain_div2_plus"> 
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Informations Copropriété') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="info_copopriete_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="info_copopriete_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="info_copopriete_terrain">@lang('Non')</label>
                    </div>
                </div>     
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Accès') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="acces_terrain" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="acces_terrain" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="acces_terrain">@lang('Non')</label>
                    </div>
                </div>     
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="">@lang('Raccordements') </label>
                    <div class="col-lg-6 col-md-6">                           
                        
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Eau') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="raccordement_eau_terrain" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="raccordement_eau_terrain" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="raccordement_eau_terrain">@lang('Non')</label>
                                </div>
                            </div>                                  
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Gaz') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="raccordement_gaz_terrain" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="raccordement_gaz_terrain" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="raccordement_gaz_terrain">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Electricité') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="raccordement_electricite_terrain" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="raccordement_electricite_terrain" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="raccordement_electricite_terrain">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Téléphone') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="raccordement_telephone_terrain" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="raccordement_telephone_terrain" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="raccordement_telephone_terrain">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        
                        
                        <hr>
                    </div>
                </div>
            </div>
            </div>

            <hr>
                <h4><span class="btn btn-warning" id="terrain_btn_plus" > <a> @lang('afficher plus')</a></span></h4>
            <hr>
    </div>

    <br>

    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Équipements') </h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_equip" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>
    <hr>
    <div class="row" id="div_equipement">

            <div class="col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="format_equipement">@lang('Format') </label>
                            <div class="col-lg-8 col-md-8">
                                <select class="js-select2 form-control" id="format_equipement" name="format_equipement" style="width: 100%;">            
                                    <option value="Non précisé">@lang('Non précisé') </option>
                                    <option value="Central">@lang('Central') </option>
                                    <option value="Collectif">@lang('Collectif') </option>                                                    
                                    <option value="Individuel">@lang('Individuel') </option>                                                    
                                </select>                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="type_equipement">@lang('Type') </label>
                            <div class="col-lg-8 col-md-8">
                                <select class="js-select2 form-control" id="type_equipement" name="type_equipement" style="width: 100%;">            
                                    <option value="Non précisé">@lang('Non précisé') </option>
                                    <option value="Air">@lang('Air') </option>
                                    <option value="Cheminée">@lang('Cheminée') </option>
                                    <option value="Convecteur">@lang('Convecteur') </option>
                                    <option value="Poêle">@lang('Poêle') </option>
                                    <option value="Radiateur">@lang('Radiateur') </option>
                                    <option value="Rayonnant">@lang('Rayonnant') </option>
                                    <option value="Sol">@lang('Sol') </option>
                                                                                                 
                                </select>                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="energie_equipement">@lang('Energie') </label>
                            <div class="col-lg-8 col-md-8">
                                <select class="js-select2 form-control" id="energie_equipement" name="energie_equipement" style="width: 100%;">            
                                    <option value="Non défini">@lang('Non défini') </option>
                                    <option value="Aérothermie">@lang('Aérothermie') </option>
                                    <option value="Bois">@lang('Bois') </option>
                                    <option value="Charbon">@lang('Charbon') </option>
                                    <option value="Climatisation">@lang('Climatisation') </option>
                                    <option value="Électrique">@lang('Électrique') </option>
                                    <option value="Fioul">@lang('Fioul') </option>
                                    <option value="Gaz">@lang('Gaz') </option>
                                    <option value="Géothermie">@lang('Géothermie') </option>
                                    <option value="Granules">@lang('Granules') </option>
                                    <option value="Mixte">@lang('Mixte') </option>
                                    <option value="Pompe">@lang('Pompe') </option>
                                    <option value="Sans">@lang('Sans') </option>
                                    <option value="Solaire">@lang('Solaire') </option>
                                                                                      
                                </select>                            
                            </div>
                        </div>
                    </div>
                </div>


            </div> 
            <hr>
            <div class="col-md-6 col-lg-6">
                    
                    <div class="row">
                        <div class=" form-group row">                                   
                            <div class="col-lg-10 col-md-10">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Ascenseur') </label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="ascenseur_equipement" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="ascenseur_equipement" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="ascenseur_equipement">@lang('Non')</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" form-group row">                                   
                            <div class="col-lg-10 col-md-10">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Accès Handicapé') </label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="acces_handicape_equipement" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="acces_handicape_equipement" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="acces_handicape_equipement">@lang('Non')</label>
                            </div>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_vente_maison">@lang('Climatisation') </label>
                        <div class="col-lg-6 col-md-6">                           
                            
                            <div class="row">
                                <div class=" form-group row">                                   
                                    <div class="col-lg-10 col-md-10">
                                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="climatisation_equipement" checked>@lang('Non précisé')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="climatisation_equipement" >@lang('Oui')</label>
                                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="climatisation_equipement">@lang('Non')</label>
                                    </div>
                                </div>

                                {{-- Affiche ou masque cette zone --}}
                                <div id="climatisation_oui_equipement">
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="climatisation_specification_equipement">@lang('Spécifications')</label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="text" class="form-control "  id="climatisation_specification_equipement" name="climatisation_specification_equipement"  >
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>                       
                            <hr>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="eau_alimentation_equipement">@lang('Eau') </label>
                        <div class="col-lg-6 col-md-6">                           
                        
                            <div class="row">
                                <div class=" form-group row">                                   
                                    
                                        <label class="col-lg-5 col-md-5 col-form-label" for="eau_alimentation_equipement">@lang('Alimentation')</label>
                                        <div class="col-lg-7 col-md-7">
                                            <select class="js-select2 form-control" id="eau_alimentation_equipement" name="eau_alimentation_equipement" style="width: 100%;">           
                                                <option value="Non défini">@lang('Non défini') </option>
                                                <option value="Sans">@lang('Sans') </option>
                                                <option value="Individuel">@lang('Individuel') </option>
                                                <option value="Collectif">@lang('Collectif') </option>
                                                <option value="Puit">@lang('Puit') </option>
                                                                                                    
                                            </select>  
                                        </div>
                                    
                                </div>
                            </div>  

                            <div class="row">
                                <div class=" form-group row">                                   
                                    <label class="col-lg-5 col-md-5 col-form-label" for="eau_assainissement_equipement">@lang('Assainissement')</label>
                                    <div class="col-lg-7 col-md-7">
                                        <select class="js-select2 form-control" id="eau_assainissement_equipement" name="eau_assainissement_equipement" style="width: 100%;">           
                                            <option value="Non défini">@lang('Non défini') </option>
                                            <option value="Sans">@lang('Sans') </option>
                                            <option value="Tout à l'égout">@lang('Tout à l\'égout') </option>
                                            <option value="Fosse septique">@lang('Fosse septique') </option>
                                            <option value="Fosse toutes eaux">@lang('Fosse toutes eaux') </option>                                                 
                                            <option value="Micro-station">@lang('Micro-station') </option>                                                 
                                        </select>  
                                    </div>
                                </div>
                            </div>  
                            
                        </div>
                        <hr>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="eau_chaude_distribution_equipement">@lang('Eau chaude') </label>
                        <div class="col-lg-6 col-md-6">                           
                        
                            <div class="row">
                                <div class=" form-group row">                                   
                                    
                                        <label class="col-lg-5 col-md-5 col-form-label" for="eau_chaude_distribution_equipement">@lang('Distribution')</label>
                                        <div class="col-lg-7 col-md-7">
                                            <select class="js-select2 form-control" id="eau_chaude_distribution_equipement" name="eau_chaude_distribution_equipement" style="width: 100%;">           
                                                <option value="Non défini">@lang('Non défini') </option>
                                                <option value="Individuel">@lang('Individuel') </option>
                                                <option value="Collectif">@lang('Collectif') </option>
                                                <option value="Centrale">@lang('Centrale') </option>
                                                                                                    
                                            </select>  
                                        </div>
                                    
                                </div>
                            </div>  

                            <div class="row">
                                <div class=" form-group row">                                   
                                    <label class="col-lg-5 col-md-5 col-form-label" for="eau_chaude_energie_equipement">@lang('Energie')</label>
                                    <div class="col-lg-7 col-md-7">
                                        <select class="js-select2 form-control" id="eau_chaude_energie_equipement" name="eau_chaude_energie_equipement" style="width: 100%;">           
                                            <option value="Non défini">@lang('Non défini') </option>
                                            <option value="Gaz">@lang('Gaz') </option>
                                            <option value="Ballon électrique">@lang('Ballon électrique') </option>
                                            <option value="Fioul">@lang('Fioul') </option>
                                            <option value="Solaire">@lang('Solaire') </option>
                                            <option value="Géothermie">@lang('Géothermie') </option>
                                            <option value="Mixte">@lang('Mixte') </option>
                                            <option value="Sans">@lang('Sans') </option>
                                            <option value="Autre">@lang('Autre') </option>
                                            <option value="Aérothermie">@lang('Aérothermie') </option>                                                 
                                        </select>  
                                    </div>
                                </div>
                            </div>  
                            
                        </div>
                        <hr>
                    </div> 
                {{-- div pour afficher ou masquer ce bloc--}}
                <div id="equipement_div1_plus"> 
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Cheminée') </label>
                        <div class="col-lg-8 col-md-8">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="cheminee_equipement" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="cheminee_equipement" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="cheminee_equipement">@lang('Non')</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Arrosage automatique') </label>
                        <div class="col-lg-8 col-md-8">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="arrosage_automatique_equipement" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="arrosage_automatique_equipement" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="arrosage_automatique_equipement">@lang('Non')</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Barbecue') </label>
                        <div class="col-lg-8 col-md-8">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="barbecue_equipement" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="barbecue_equipement" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="barbecue_equipement">@lang('Non')</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Tennis') </label>
                        <div class="col-lg-8 col-md-8">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="tennis_equipement" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="tennis_equipement" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="tennis_equipement">@lang('Non')</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Local à vélo') </label>
                        <div class="col-lg-8 col-md-8">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="local_a_velo_equipement" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="local_a_velo_equipement" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="local_a_velo_equipement">@lang('Non')</label>
                        </div>
                    </div>
                </div>
            
            </div>

            <div class="col-md-6 col-lg-6">

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Volets électriques') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="volet_electrique_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="volet_electrique_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="volet_electrique_equipement">@lang('Non')</label>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Gardien') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="gardien_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="gardien_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="gardien_equipement">@lang('Non')</label>
                    </div>
                </div><hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Double vitrage') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="double_vitrage_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="double_vitrage_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="double_vitrage_equipement">@lang('Non')</label>
                    </div>
                </div> <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Triple vitrage') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="triple_vitrage_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="triple_vitrage_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="triple_vitrage_equipement">@lang('Non')</label>
                    </div>
                </div>     
                <hr>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Câble') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="cable_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="cable_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="cable_equipement">@lang('Non')</label>
                    </div>
                </div>   
                <hr>

            {{-- div pour afficher ou masquer ce bloc--}}
            <div id="equipement_div2_plus">     
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="">@lang('Sécurité') </label>
                    <div class="col-lg-6 col-md-6">                           
                        
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Porte blindée') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_porte_blinde_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_porte_blinde_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_porte_blinde_equipement">@lang('Non')</label>
                                </div>
                            </div>                                  
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Interphone') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_interphone_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_interphone_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_interphone_equipement">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Visiophone') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_visiophone_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_visiophone_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_visiophone_equipement">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Alarme') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_alarme_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_alarme_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_alarme_equipement">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Digicode') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_digicode_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_digicode_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_digicode_equipement">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-select">@lang('Détecteur de fumée') </label>
                                <div class="col-lg-8 col-md-8">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="securite_detecteur_de_fumee_equipement" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="securite_detecteur_de_fumee_equipement" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="securite_detecteur_de_fumee_equipement">@lang('Non')</label>
                                </div>
                            </div>                                 
                        </div>

                        <hr>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Portail électrique') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="portail_electrique_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="portail_electrique_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="portail_electrique_equipement">@lang('Non')</label>
                    </div>
                </div>    
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-select">@lang('Cuisine d\'été') </label>
                    <div class="col-lg-8 col-md-8">
                        <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="cuisine_ete_equipement" checked>@lang('Non précisé')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="cuisine_ete_equipement" >@lang('Oui')</label>
                        <label class="radio-inline"><input type="radio" value="@lang('Non')" name="cuisine_ete_equipement">@lang('Non')</label>
                    </div>
                </div>    
            </div>               
        </div>
        <hr>
            <h4><span class="btn btn-warning" id="equipement_btn_plus" > <a> @lang('afficher plus')</a></span></h4>
        <hr>
    </div>


    <br>
    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Diagnostics & Compléments') </h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_diag" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>

    <div class="row" id="div_diagnostic">
        <div class="col-md-6 col-lg-6">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="annee_construction_diagnostic">@lang('Année de construction') </label>
                <div class="col-lg-4 col-md-4">
                    <input type="number" min="1800" max="3000" class="form-control " value="" id="annee_construction_diagnostic" name="annee_construction_diagnostic" placeholder=""> 
                </div>
            </div> 
<hr>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="dpe_bien_soumi_diagnostic">@lang('DPE') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-10 col-md-10 col-form-label" for="dpe_bien_soumi_diagnostic">@lang('Ce bien est soumis au DPE') </label>
                            <div class="col-lg-2 col-md-2">
                                <input type="checkbox"   id="dpe_bien_soumi_diagnostic" name="dpe_bien_soumi_diagnostic" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-10 col-md-10 col-form-label" for="dpe_vierge_diagnostic">@lang('DPE vierge pour ce bien') </label>
                            <div class="col-lg-2 col-md-2">
                                <input type="checkbox"  id="dpe_vierge_diagnostic" name="dpe_vierge_diagnostic" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-5 col-md-5 col-form-label" for="dpe_consommation_diagnostic">@lang('Consommation') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="text"  class="form-control " value="" id="dpe_consommation_diagnostic" name="dpe_consommation_diagnostic" placeholder=""> 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-5 col-md-5 col-form-label" for="dpe_ges_diagnostic">@lang('GES') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="text" class="form-control " value="" id="dpe_ges_diagnostic" name="dpe_ges_diagnostic" placeholder=""> 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-5 col-md-5 col-form-label" for="dpe_diagnostic">@lang('Date') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="date" class="form-control " value="" id="dpe_diagnostic" name="dpe_diagnostic" placeholder=""> 
                            </div>
                        </div>                                    
                    </div>
               
                </div>
            </div>
<hr>
            <div class=" form-group row">                                   
                <label class="col-lg-5 col-md-5 col-form-label" for="etat_exterieur_diagnostic">@lang('Etat extérieur')</label>
                <div class="col-lg-7 col-md-7">
                    <select class="js-select2 form-control" id="etat_exterieur_diagnostic" name="etat_exterieur_diagnostic" style="width: 100%;">           
                        <option value="Non défini">@lang('Non défini') </option>
                        <option value="Travaux à prévoir">@lang('Travaux à prévoir') </option>
                        <option value="A rafraichir">@lang('A rafraichir') </option>
                        <option value="Etat moyen">@lang('Etat moyen') </option>
                        <option value="Bon état">@lang('Bon état') </option>
                        <option value="Execellent état">@lang('Execellent état') </option>
                                                                
                    </select>  
                </div>
            </div>

            <div class=" form-group row">                                   
                <label class="col-lg-5 col-md-5 col-form-label" for="etat_interieur_diagnostic">@lang('Etat intérieur')</label>
                <div class="col-lg-7 col-md-7">
                    <select class="js-select2 form-control" id="etat_interieur_diagnostic" name="etat_interieur_diagnostic" style="width: 100%;">           
                        <option value="Non défini">@lang('Non défini') </option>
                        <option value="Gros travaux à prévoir">@lang('Gros travaux à prévoir') </option>
                        <option value="Travaux à prévoir">@lang('Travaux à prévoir') </option>
                        <option value="A rafraichir">@lang('A rafraichir') </option>
                        <option value="Habitable (m²)">@lang('Habitable (m²)') </option>
                        <option value="Etat moyen">@lang('Etat moyen') </option>
                        <option value="Bon état">@lang('Bon état') </option>
                        <option value="Execellent état">@lang('Execellent état') </option>
                        <option value="Neuf">@lang('Neuf') </option>
                        <option value="Refait à neuf">@lang('Refait à neuf') </option>
                                                                
                    </select>  
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-5 col-md-5 col-form-label" for="surface_annexe_diagnostic">@lang('Surfaces annexes') </label>
                <div class="col-lg-7 col-md-7">
                    <input type="number" min="0" class="form-control " value="" id="surface_annexe_diagnostic" name="surface_annexe_diagnostic" placeholder=""> 
                </div>
            </div>
                    
    </div>

    <div class="col-md-6 col-lg-6">

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="etat_parasitaire_diagnostic">@lang('État parasitaire') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                     
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="etat_parasitaire_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="etat_parasitaire_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="etat_parasitaire_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
                {{-- Affiche ou masque la zone --}}
                <div id="etat_parasitaire_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="etat_parasitaire_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="etat_parasitaire_date_diagnostic" name="etat_parasitaire_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="etat_parasitaire_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                           <textarea name="etat_parasitaire_commentaire_diagnostic" class="form-control" id="etat_parasitaire_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
                </div>
                <hr>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="amiante_diagnostic">@lang('Amiante') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="amiante_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="amiante_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="amiante_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
             {{-- Affiche ou masque la zone --}}
             <div id="amiante_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="amiante_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="amiante_date_diagnostic" name="amiante_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="amiante_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="amiante_commentaire_diagnostic" class="form-control" id="amiante_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
             </div>
                <hr>
            </div>
        </div>
    {{-- div pour afficher ou masquer ce bloc--}}
    <div id="diagnostic_plus"> 
        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="electrique_diagnostic">@lang('Électrique') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="electrique_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="electrique_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="electrique_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
            {{-- Affiche ou masque la zone --}}
             <div id="electrique_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="electrique_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="electrique_date_diagnostic" name="electrique_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="electrique_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="electrique_commentaire_diagnostic" class="form-control" id="electrique_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
             </div>
                <hr>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="loi_carrez_diagnostic">@lang('Loi Carrez') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="loi_carrez_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="loi_carrez_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="loi_carrez_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
                {{-- Affiche ou masque la zone --}}
             <div id="loi_carrez_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="loi_carrez_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="loi_carrez_date_diagnostic" name="loi_carrez_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="loi_carrez_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="loi_carrez_commentaire_diagnostic" class="form-control" id="loi_carrez_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   

             </div>

                <hr>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="risque_nat_diagnostic">@lang('Risques nat. et tech') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="risque_nat_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="risque_nat_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="risque_nat_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
            {{-- Affiche ou masque la zone --}}
            <div id="risque_nat_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="risque_nat_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="risque_nat_date_diagnostic" name="risque_nat_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="risque_nat_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="risque_nat_commentaire_diagnostic" class="form-control" id="risque_nat_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
            </div>
                <hr>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="plomb_diagnostic">@lang('Plomb') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="plomb_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="plomb_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="plomb_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
            {{-- Affiche ou masque la zone --}}
            <div id="plomb_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="plomb_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="plomb_date_diagnostic" name="plomb_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="plomb_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="plomb_commentaire_diagnostic" class="form-control" id="" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
            </div>

                <hr>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="gaz_diagnostic">@lang('Gaz') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="gaz_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="gaz_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="gaz_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>
                {{-- Affiche ou masque la zone --}}
            <div id="gaz_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="gaz_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="gaz_date_diagnostic" name="gaz_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="gaz_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="gaz_commentaire_diagnostic" class="form-control" id="gaz_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
            </div>
                <hr>
            </div>


        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="assainissement_diagnostic">@lang('Assainissement') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        
                        <div class="col-lg-10 col-md-10">
                            <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="assainissement_diagnostic" checked>@lang('Non précisé')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="assainissement_diagnostic" >@lang('Oui')</label>
                            <label class="radio-inline"><input type="radio" value="@lang('Non')" name="assainissement_diagnostic">@lang('Non')</label>
                        </div>
                    </div>                                    
                </div>

                {{-- Affiche ou masque la zone --}}
            <div id="assainissement_oui_diagnostic">
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-5 col-md-5 col-form-label" for="assainissement_date_diagnostic">@lang('Date') </label>
                        <div class="col-lg-7 col-md-7">
                            <input type="date" class="form-control " value="" id="assainissement_date_diagnostic" name="assainissement_date_diagnostic" placeholder=""> 
                        </div>
                    </div>                                    
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-12 col-md-12 col-form-label" for="assainissement_commentaire_diagnostic">@lang('Commentaires'): </label>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="assainissement_commentaire_diagnostic" class="form-control" id="assainissement_commentaire_diagnostic" cols="8" rows="3"></textarea>
                        </div>
                    </div>                                    
                </div>   
            </div>
                <hr>
            </div>
        </div>
    </div>

    </div>
    <hr>
        <h4><span class="btn btn-warning" id="diagnostic_btn_plus" > <a> @lang('afficher plus')</a></span></h4>
    <hr>
</div>




<br>

    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Informations Copropriété') </h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_info" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>


    <div class="row" id="div_information">
        <div class="col-md-6 col-lg-6">

            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for="bien_en_copropriete">@lang('Bien en copropriété') </label>
                <div class="col-lg-8 col-md-8">
                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="bien_en_copropriete" checked>@lang('Non précisé')</label>
                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="bien_en_copropriete" >@lang('Oui')</label>
                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="bien_en_copropriete">@lang('Non')</label>
                </div>
            </div> 
<hr>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="numero_lot_info_copropriete">@lang('Lots') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_lot_info_copropriete">@lang('Numéro de lot') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="number" min="0" class="form-control " value="" id="numero_lot_info_copropriete" name="numero_lot_info_copropriete" placeholder=""> 
                            </div>
                        </div>                                   
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="nombre_lot_info_copropriete">@lang('Nombre de lots') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="number" min="0" class="form-control " value="" id="nombre_lot_info_copropriete" name="nombre_lot_info_copropriete" placeholder=""> 
                            </div>
                        </div>                               
                    </div>               
                </div>
            </div>
<hr>
            <div class="form-group row">
                <label class="col-lg-5 col-md-5 col-form-label" for="quote_part_charge_info_copropriete">@lang('Quote part annuelle des charges') </label>
                <div class="col-lg-7 col-md-7">
                    <input type="number" min="0" class="form-control " value="" id="quote_part_charge_info_copropriete" name="quote_part_charge_info_copropriete" placeholder=""> 
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 col-md-5 col-form-label" for="montant_fond_travaux_info_copropriete">@lang('Montant fonds des travaux') </label>
                <div class="col-lg-7 col-md-7">
                    <input type="number" min="0" class="form-control " value="" id="montant_fond_travaux_info_copropriete" name="montant_fond_travaux_info_copropriete" placeholder=""> 
                </div>
            </div>
                    
    </div>

    <div class="col-md-6 col-lg-6">

        <div class="form-group row">   
            <label class="col-lg-4 col-md-4 col-form-label" for="plan_sauvegarde_info_copropriete">@lang('Copropriété soumise à un plan de sauvegarde') </label>
            <div class="col-lg-8 col-md-8">
                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="plan_sauvegarde_info_copropriete" checked>@lang('Non précisé')</label>
                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="plan_sauvegarde_info_copropriete" >@lang('Oui')</label>
                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="plan_sauvegarde_info_copropriete">@lang('Non')</label>
            </div>
        </div> 
        <div class="form-group row">   
            <label class="col-lg-4 col-md-4 col-form-label" for="statut_syndic_info_copropriete">@lang('Statut du syndic') </label>
            <div class="col-lg-8 col-md-8">
                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="statut_syndic_info_copropriete" checked>@lang('Non précisé')</label>
                <label class="radio-inline"><input type="radio" value="@lang('Soumis à une procédure d\'alerte')" name="statut_syndic_info_copropriete" >@lang('Soumis à une procédure d\'alerte')</label>
                <label class="radio-inline"><input type="radio" value="@lang('Soumis à une procédure de redressement')" name="statut_syndic_info_copropriete">@lang('Soumis à une procédure de redressement')</label>
                <label class="radio-inline"><input type="radio" value="@lang('Pas de Procédure en cours')" name="statut_syndic_info_copropriete">@lang('Pas de Procédure en cours')</label>
            </div>
        </div>        

    </div>
</div>


<br>
<br>

    <div class="row">
        <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #617f8e; color: white;">
                <h4> @lang('Dossier & Disponibilité')</h4>                          
        </div>
        <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-20px;">
                <button class="btn btn-dark btn-flat btn-addon" type="button" id="btn_clic_masquer_dossier" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-plus"></i>&nbsp;</button>
        </div>        
    </div>


    <div class="row" id="div_dossier">
        <div class="col-md-12 col-lg-12">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_dispo">@lang('Dossier') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_dispo">@lang('Numéro') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="text"  class="form-control " value="" id="numero_dossier_dispo" name="numero_dossier_dispo"> 
                            </div>
                        </div>                                   
                    </div>

                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="dossier_cree_le_dossier_dispo">@lang('Crée le') </label>
                            <div class="col-lg-7 col-md-7">
                                <input type="date"  class="form-control " value="" id="dossier_cree_le_dossier_dispo" name="dossier_cree_le_dossier_dispo"> 
                            </div>
                        </div>                                   
                    </div>
                </div>
            </div>

            <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-form-label" for="disponibilite_immediate_dossier_dispo">@lang('Disponibilité') </label>
                    <div class="col-lg-6 col-md-6">
                        
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="disponibilite_immediate_dossier_dispo">@lang('Immédiate') </label>
                                <div class="col-lg-7 col-md-7">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="disponibilite_immediate_dossier_dispo" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="disponibilite_immediate_dossier_dispo" >@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="disponibilite_immediate_dossier_dispo">@lang('Non')</label>
                                </div>
                            </div>                                   
                        </div>

                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="disponible_le_dossier_dispo">@lang('Disponible le') </label>
                                <div class="col-lg-7 col-md-7">
                                    <input type="date"  class="form-control " value="" id="disponible_le_dossier_dispo" name="disponible_le_dossier_dispo"> 
                                </div>
                            </div>                                   
                        </div>

                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="liberation_le_dossier_dispo">@lang('Libération le') </label>
                                <div class="col-lg-7 col-md-7">
                                    <input type="date"  class="form-control " value="" id="liberation_le_dossier_dispo" name="liberation_le_dossier_dispo"> 
                                </div>
                            </div>                                   
                        </div>
    
                                      
                    </div>
                </div>
        </div>
    </div>
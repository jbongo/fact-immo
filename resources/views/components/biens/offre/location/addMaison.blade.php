
    <br>
    <br>
    <input type="hidden" class="" value="xxxxxxxxx" name="xxxxxxxxxxxxx">

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Type de maison') <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="js-select2 form-control" id="val-select" name="type_maison_location_maison" style="width: 100%;" required>

                                <option value="Bastide">@lang('Bastide') </option>
                                <option value="Château">@lang('Château') </option>
                                <option value="Ferme">@lang('Ferme') </option>
                                <option value="Maison">@lang('Maison') </option>
                                <option value="Maison de village">@lang('Maison de village') </option>
                                <option value="Mas">@lang('Mas') </option>
                                <option value="Propriété">@lang('Propriété') </option>
                                <option value="Rez de villa">@lang('Rez de villa') </option>
                                <option value="Villa">@lang('Villa') </option>

                            </select>  
                            
                        </div>
            </div>
                            
        </div>

    </div>
    <br>
    <br>
    <hr>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="titre_annonce_location_maison">@lang('Titre de l\'annonce')<span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control " value="{{old('titre_annonce_location_maison')}}" id="titre_annonce_location_maison" name="titre_annonce_location_maison" required  >
                </div>
            </div>

        </div>

        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="description_annonce_location_maison">@lang('Description de l\'annonce') <span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                   
                    <textarea class="form-control"  name="description_annonce_location_maison" id="description_annonce_location_maison" cols="30" rows="10" required></textarea>
                
                </div>
            </div>

        </div>
        <br>

    <div class="row">
        <div class="col-md-6 col-lg-6">

                            {{-- <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="loyer_location_maison">@lang('Loyer') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('loyer_location_maison')}}" id="loyer_location_maison" name="loyer_location_maison" placeholder="@lang('€ [TTC]')" required> 
                                    @if ($errors->has('loyer_location_maison'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('loyer_location_maison')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="duree_bail_location_maison">@lang('Durée bail') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" max="100" class="form-control " value="{{old('duree_bail_location_maison')}}" id="duree_bail_location_maison" name="duree_bail_location_maison" placeholder="@lang('ans')" > 
                                    @if ($errors->has('duree_bail_location_maison'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('duree_bail_location_maison')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="surface_habitable_location_maison">@lang('Surface habitable') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" required class="form-control " value="{{old('surface_habitable_location_maison')}}" id="surface_habitable_location_maison" name="surface_habitable_location_maison" placeholder="@lang('m²')" > 
                                    @if ($errors->has('surface_habitable_location_maison'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('surface_habitable_location_maison')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4   col-form-label" for="nb_piece_location_maison">@lang('Nombre de pièces') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0"  required class="form-control " value="{{old('nb_piece_location_maison')}}" id="nb_piece_location_maison" name="nb_piece_location_maison" placeholder="" > 
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nb_chambres_location_maison">@lang('Nombre de chambres') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('nb_chambres_location_maison')}}" id="nb_chambres_location_maison" name="nb_chambres_location_maison" placeholder="" > 
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nombre_niveau_location_maison">@lang('Nombre de niveaux') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('nombre_niveau_location_maison')}}" id="nombre_niveau_location_maison" name="nombre_niveau_location_maison" placeholder="" > 
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="jardin_location_maison">@lang('Jardin') </label>
                                <div class="col-lg-7 col-md-6">
                                    <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="jardin_location_maison" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="jardin_location_maison">@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="@lang('Non')" name="jardin_location_maison">@lang('Non')</label>
                                    
                                    <div id="jardin_oui_location_maison">

                                   
                                    <hr>
                                    <div class="form-group row">
                                                    <label class="col-lg-6 col-md-6 col-form-label">@lang('Surface (m²)	') <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4 col-md-4">
                                                    <input type="number" min="0" required class="form-control " value="{{old('surface_jardin_location_maison')}}"  name="surface_jardin_location_maison" placeholder="m²" > 
                                                        
                                                    </div>
                                        </div>
                                        <hr>
                                        <div class=" form-group row">
                                            <label class="col-lg-6 col-md-6 col-form-label">@lang('Privatif') </label>
                                            <div class="col-lg-6 col-md-6">
                                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="privatif_jardin_location_maison" checked>@lang('Non précisé')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="privatif_jardin_location_maison" >@lang('Oui')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="privatif_jardin_location_maison">@lang('Non')</label>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" required for="surface_terrain_location_maison">@lang('Surface Terrain') <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                <input type="number" min="0" class="form-control " value="{{old('surface_terrain_location_maison')}}" id="surface_terrain_location_maison" name="surface_terrain_location_maison" placeholder="m²" > 
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="piscine_location_maison">@lang('Piscine') </label>
                                <div class="col-lg-6 col-md-6">
                                    <label class="radio-inline"><input type="radio" value="Non précisé" name="piscine_location_maison" checked>@lang('Non précisé')</label>
                                    <label class="radio-inline"><input type="radio" value="Oui" name="piscine_location_maison">@lang('Oui')</label>
                                    <label class="radio-inline"><input type="radio" value="Non" name="piscine_location_maison">@lang('Non')</label>
                                   
                                    <div id="piscine_oui_location_maison">

                                   
                                    <hr>
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5  col-form-label" >@lang('Statut') </label>
                                            <div class="col-lg-6 col-md-6">
                                                <select class="js-select2 form-control" id="statut_piscine_location_maison" name="statut_piscine_location_maison" style="width: 100%;">

                                                    <option value="Non défini">@lang('Non défini') </option>
                                                    <option value="Privative">@lang('Privative') </option>
                                                    <option value="Collective">@lang('Collective') </option>
                                                    <option value="Collective surveillée">@lang('Collective surveillée') </option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <hr>
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5  col-form-label" >@lang('Nature') </label>
                                            <div class="col-lg-6 col-md-6">
                                                <select class="js-select2 form-control"  name="nature_piscine_location_maison" style="width: 100%;" >

                                                    <option value="Non défini">@lang('Non défini') </option>
                                                    <option value="Coque">@lang('Coque') </option>
                                                    <option value="Traditionnelle">@lang('Traditionnelle') </option>
                                                    <option value="Hors-sol">@lang('Hors-sol') </option>
                                                    <option value="Semi-enterrée">@lang('Semi-enterrée') </option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5 col-form-label">@lang('Volume') </label>
                                            <div class="col-lg-4 col-md-4">
                                                 <input type="number" min="0" class="form-control " value="{{old('volume_piscine_location_maison')}}" id="volume_piscine_location_maison" name="volume_piscine_location_maison" placeholder="" > 
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                    m<sup>3<sup>
                                            </div>
                                            
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5 col-form-label">@lang('Pool House') </label>
                                            <div class="col-lg-7 col-md-7">
                                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="pool_house_piscine_location_maison" checked>@lang('Non précisé')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="pool_house_piscine_location_maison">@lang('Oui')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="pool_house_piscine_location_maison">@lang('Non')</label>
                                                     
                                            </div>
                                        </div>
                                        <hr>
                                      
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5 col-form-label">@lang('Chauffée') </label>
                                            <div class="col-lg-7 col-md-7">
                                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="chauffee_piscine_location_maison" checked>@lang('Non précisé')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="chauffee_piscine_location_maison">@lang('Oui')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="chauffee_piscine_location_maison">@lang('Non')</label>
                                                     
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div class="row">
                                            <label class="col-lg-5 col-md-5 col-form-label">@lang('Couverte') </label>
                                            <div class="col-lg-7 col-md-7">
                                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="couverte_piscine_location_maison" checked>@lang('Non précisé')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="couverte_piscine_location_maison">@lang('Oui')</label>
                                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="couverte_piscine_location_maison">@lang('Non')</label>
                                                     
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                      
                           
        </div>

        
        
        <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="val-pays">@lang('Pays') <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-md-6">
                                <select class="js-select2 form-control" id="val-pays" name="pays_location_maison" style="width: 100%;" data-placeholder="Choose one.." required>

                                    <option value="France">@lang('France') </option>
                                    <option value="Belgique">@lang('Belgique') </option>
                                    <option value="España">@lang('España') </option>                   

                                </select>
                               
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="ville_location_maison">@lang('Ville') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('ville_location_maison')}}" id="ville_location_maison" name="ville_location_maison" required >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_location_maison">@lang('Code postal') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('code_postal_location_maison')}}" id="code_postal_location_maison" name="code_postal_location_maison" placeholder="" required >
                                                              
                                </div>
                        </div>

                        <div class=" row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_maison">@lang('Dossier') </label>
                                <div class="col-lg-6 col-md-6">
                                    
                                    <hr>                                    
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_maison">@lang('N°')<span class="text-danger">*</span></label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="text" required class="form-control" value="{{old('numero_dossier_location_maison')}}" id="numero_dossier_location_maison" name="numero_dossier_location_maison" >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="date_creation_dossier_location_maison">@lang('Créé le')<span class="text-danger">*</span></label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="date" required class="form-control " value="{{old('date_creation_dossier_location_maison')}}" id="date_creation_dossier_location_maison" name="date_creation_dossier_location_maison" >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr>
                                </div>
                        </div>
                        <div class="form-group row" id="div_meuble_location_maison">
                            <label class="col-lg-4 col-md-4 col-form-label" for="meuble_location_maison">@lang('Meublé') </label>
                            <div class="col-lg-7 col-md-6">
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="meuble_location_maison" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="meuble_location_maison">@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="meuble_location_maison">@lang('Non')</label>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nb_garage_location_maison">@lang('Nombre de garage') </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="number" class="form-control " value="{{old('nb_garage_location_maison')}}" id="nb_garage_location_maison" name="nb_garage_location_maison"  >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="exposition_location_maison">@lang('Situation') </label>
                                <div class="col-lg-6 col-md-6">
                                   <hr>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="exposition_situation_location_maison"> @lang('Exposition') </label>
                                            <div class="col-lg-6 col-md-6">
                                                    <select class="js-select2 form-control" id="exposition_situation_location_maison" name="exposition_situation_location_maison" style="width: 100%;"  >
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
                                            <label class="col-lg-4 col-md-4 col-form-label" for="vue_situation_location_maison">@lang('Vue')</label>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" class="form-control " value="{{old('vue_situation_location_maison')}}" id="vue_situation_location_maison" name="vue_situation_location_maison"  >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr>

                                </div>
                        </div>

        </div>
    </div> 
     
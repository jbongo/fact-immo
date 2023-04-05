
    <br>
    <br>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="val-select">@lang('Type d\'appartement') <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="js-select2 form-control" id="val-select" name="type_appartement_location_appart" style="width: 100%;" required>

                                <option value="Appartement">@lang('Appartement') </option>
                                <option value="Duplex">@lang('Duplex') </option>
                                <option value="Immeuble">@lang('Immeuble') </option>
                                <option value="Loft">@lang('Loft') </option>
                                <option value="Rez de jardin">@lang('Rez de jardin') </option>
                                <option value="Studio">@lang('Studio') </option>
                                <option value="Triplex">@lang('Triplex') </option>
                               
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
                <label class="col-lg-4 col-md-4 col-form-label" for="titre_annonce_location_appart">@lang('Titre de l\'annonce')<span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control " value="{{old('titre_annonce_location_appart')}}" id="titre_annonce_location_appart" name="titre_annonce_location_appart" required  >
                </div>
            </div>

        </div>

        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="description_annonce_location_appart">@lang('Description de l\'annonce') <span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                   
                    <textarea class="form-control"  name="description_annonce_location_appart" id="description_annonce_location_appart" cols="30" rows="10" required></textarea>
                
                </div>
            </div>

        </div>
        <br>

    <div class="row">
        <div class="col-md-6 col-lg-6">

                            
                            {{-- <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="loyer_location_appart">@lang('Loyer') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('loyer_location_appart')}}" id="loyer_location_appart" name="loyer_location_appart" placeholder="@lang('€ [TTC]')" required> 
                                    @if ($errors->has('loyer_location_appart'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('loyer_location_appart')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="duree_bail_location_appart">@lang('Durée bail') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" max="100" class="form-control " value="{{old('duree_bail_location_appart')}}" id="duree_bail_location_appart" name="duree_bail_location_appart" placeholder="@lang('ans')" > 
                                    @if ($errors->has('duree_bail_location_appart'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('duree_bail_location_appart')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>


                           

                            <div class="form-group row" id="div_surface_habitable_location_appart">
                                <label class="col-lg-4 col-md-4 col-form-label" for="surface_habitable_location_appart">@lang('Surface habitable') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" required class="form-control" value="{{old('surface_habitable_location_appart')}}" id="surface_habitable_location_appart" name="surface_habitable_location_appart" placeholder="@lang('m²')" > 
                                    @if ($errors->has('surface_habitable_location_appart'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('surface_habitable_location_appart')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="form-group row" id="div_nb_piece_location_appart">
                                <label class="col-lg-4 col-md-4   col-form-label" for="nb_piece_location_appart">@lang('Nombre de pièces')<span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" required class="form-control " value="{{old('nb_piece_location_appart')}}" id="nb_piece_location_appart" name="nb_piece_location_appart" placeholder="" > 
                                </div>
                            </div>
                            
                            <div class="form-group row" id="div_nb_chambres_location_appart">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nb_chambres_location_appart">@lang('Nombre de chambres') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('nb_chambres_location_appart')}}" id="nb_chambres_location_appart" name="nb_chambres_location_appart" placeholder="" > 
                                </div>
                            </div> 

                            <div class="form-group row" id="div_nombre_niveau_location_appart">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nombre_niveau_location_appart">@lang('Nombre de niveaux') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('nombre_niveau_location_appart')}}" nb_chambres_location_appart name="nombre_niveau_location_appart" placeholder="" > 
                                    
                                </div>
                            </div>
                  
                         
                      
                           
        </div>

        
        
        <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="val-pays">@lang('Pays') <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-md-6">
                                <select class="js-select2 form-control" id="val-pays" name="pays_location_appart" style="width: 100%;" data-placeholder="Choose one.." required>

                                    <option value="France">@lang('France') </option>
                                    <option value="Belgique">@lang('Belgique') </option>
                                    <option value="España">@lang('España') </option>                   

                                </select>
                               
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="ville_location_appart">@lang('Ville') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('ville_location_appart')}}" id="ville_location_appart" name="ville_location_appart" required >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_location_appart">@lang('Code postal') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('code_postal_location_appart')}}" id="code_postal_location_appart" name="code_postal_location_appart" placeholder="" required >
                                                              
                                </div>
                        </div>

                        <div class=" row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_appart">@lang('Dossier')  </label>
                                <div class="col-lg-6 col-md-6">
                                    
                                    <hr>                                    
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_appart">@lang('N°')<span class="text-danger">*</span></label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="text" required class="form-control" value="{{old('numero_dossier_location_appart')}}" id="numero_dossier_location_appart" name="numero_dossier_location_appart" >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="row" id="div_date_creation_dossier_location_appart">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="date_creation_dossier_location_appart">@lang('Créé le')<span class="text-danger">*</span></label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="date" required class="form-control " value="{{old('date_creation_dossier_location_appart')}}" id="date_creation_dossier_location_appart" name="date_creation_dossier_location_appart" >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr>
                                </div>
                        </div>
                        <div class="form-group row" id="div_meuble_location_appart">
                            <label class="col-lg-4 col-md-4 col-form-label" for="meuble_location_appart">@lang('Meublé') </label>
                            <div class="col-lg-7 col-md-6">
                                <label class="radio-inline"><input type="radio" value="@lang('Non précisé')" name="meuble_location_appart" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" name="meuble_location_appart">@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Non')" name="meuble_location_appart">@lang('Non')</label>
                            </div>
                        </div>

                        <div class="form-group row" id="div_nb_garage_location_appart">
                                <label class="col-lg-4 col-md-4 col-form-label" for="nb_garage_location_appart">@lang('Nombre de garage') </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="number" class="form-control " value="{{old('nb_garage_location_appart')}}" id="nb_garage_location_appart" name="nb_garage_location_appart"  >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row" id="div_exposition_situation_location_appart">
                                <label class="col-lg-4 col-md-4 col-form-label" for="exposition_location_appart">@lang('Situation') </label>
                                <div class="col-lg-6 col-md-6">
                                   <hr>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="exposition_situation_location_appart"> @lang('Exposition') </label>
                                            <div class="col-lg-6 col-md-6">
                                                    <select class="js-select2 form-control" id="exposition_situation_location_appart" name="exposition_situation_location_appart" style="width: 100%;"  >
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
                                            <label class="col-lg-4 col-md-4 col-form-label" for="vue_situation_location_appart">@lang('Vue')</label>
                                            <div class="col-lg-6 col-md-6">
                                                <input type="text" class="form-control " value="{{old('vue_situation_location_appart')}}" id="vue_situation_location_appart" name="vue_situation_location_appart"  >
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr>

                                </div>
                        </div>

        </div>
    </div> 
     
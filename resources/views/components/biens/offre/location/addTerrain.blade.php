
    <br>
    <br>
    <input type="hidden" class="" value="xxxxxxxxx" name="xxxxxxxxxxxxx">

        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="titre_annonce_location_terrain">@lang('Titre de l\'annonce')<span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control " value="{{old('titre_annonce_location_terrain')}}" id="titre_annonce_location_terrain" name="titre_annonce_location_terrain" required  >
                </div>
            </div>

        </div>

        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="description_annonce_location_terrain">@lang('Description de l\'annonce') <span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                   
                    <textarea class="form-control"  name="description_annonce_location_terrain" id="description_annonce_location_terrain" cols="30" rows="10" required></textarea>
                
                </div>
            </div>

        </div>
        <br>

    <div class="row">
        <div class="col-md-6 col-lg-6">
                            {{-- <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="loyer_location_terrain">@lang('Loyer') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('loyer_location_terrain')}}" id="loyer_location_terrain" name="loyer_location_terrain" placeholder="@lang('€ [TTC]')" required> 
                                    @if ($errors->has('loyer_location_terrain'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('loyer_location_terrain')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                            
                            <div class="form-group row" id="div_duree_bail_location_terrain">
                                <label class="col-lg-4 col-md-4 col-form-label" for="duree_bail_location_terrain">@lang('Durée bail') </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" max="100" class="form-control " value="{{old('duree_bail_location_terrain')}}" id="duree_bail_location_terrain" name="duree_bail_location_terrain" placeholder="@lang('ans')" > 
                                    @if ($errors->has('duree_bail_location_terrain'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('duree_bail_location_terrain')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>        

                           

                            <div class="form-group row" id="div_surface_habitable_location_terrain">
                                <label class="col-lg-4 col-md-4 col-form-label" for="surface_habitable_location_terrain">@lang('Surface Terrain')<span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" required class="form-control " value="{{old('surface_habitable_location_terrain')}}" id="surface_habitable_location_terrain" name="surface_habitable_location_terrain" placeholder="@lang('m²')"> 
                                    @if ($errors->has('surface_habitable_location_terrain'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('surface_habitable_location_terrain')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            

                           
        </div>

        
        
        <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="val-pays">@lang('Pays') <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-md-6">
                                <select class="js-select2 form-control" id="val-pays" name="pays_location_terrain" style="width: 100%;" data-placeholder="Choose one.." required>

                                    <option value="France">@lang('France') </option>
                                    <option value="Belgique">@lang('Belgique') </option>
                                    <option value="España">@lang('España') </option>                   

                                </select>
                               
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="ville_location_terrain">@lang('Ville') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('ville_location_terrain')}}" id="ville_location_terrain" name="ville_location_terrain" required >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_location_terrain">@lang('Code postal') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('code_postal_location_terrain')}}" id="code_postal_location_terrain" name="code_postal_location_terrain" placeholder="" required >
                                                              
                                </div>
                        </div>
                        <div class=" row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_terrain">@lang('Dossier') </label>
                            <div class="col-lg-6 col-md-6">
                                
                                <hr>                                    
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_location_terrain">@lang('N°')<span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="text" required class="form-control" value="{{old('numero_dossier_location_terrain')}}" id="numero_dossier_location_terrain" name="numero_dossier_location_terrain" >
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="date_creation_dossier_location_terrain">@lang('Créé le')<span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="date" required class="form-control " value="{{old('date_creation_dossier_location_terrain')}}" id="date_creation_dossier_location_terrain" name="date_creation_dossier_location_terrain" >
                                        </div>
                                    </div>                                    
                                </div>
                                <hr>
                            </div>
                    </div>

        </div>
    </div> 
     
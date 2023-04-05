
    <br>
    <br>
  
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="titre_annonce_vente_terrain">@lang('Titre de l\'annonce')<span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control " value="{{old('titre_annonce_vente_terrain')}}" id="titre_annonce_vente_terrain" name="titre_annonce_vente_terrain" required  >
                </div>
            </div>

        </div>

        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="description_annonce_vente_terrain">@lang('Description de l\'annonce') <span class="text-danger">*</span> </label>
                <div class="col-lg-6 col-md-6">
                   
                    <textarea class="form-control"  name="description_annonce_vente_terrain" id="description_annonce_vente_terrain" cols="30" rows="10" required></textarea>
                
                </div>
            </div>

        </div>
        <br>

    <div class="row">
        <div class="col-md-6 col-lg-6">

                            
                            {{-- <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_vente_terrain">@lang('Prix') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">                           
                                 
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_vente_terrain">@lang('public') </label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="number" min="0" class="form-control " value="{{old('prix_public_vente_terrain')}}" id="prix_public_vente_terrain" name="prix_public_vente_terrain" placeholder="@lang('€')" required> 
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="row">                                         
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_net_vendeur_vente_terrain">@lang('net vendeur') </label>
                                            <div class="col-lg-8 col-md-8">
                                                <input type="number" min="0" class="form-control " value="{{old('prix_net_vendeur_vente_terrain')}}" id="prix_net_vendeur_vente_terrain" name="prix_net_vendeur_vente_terrain" placeholder="@lang('€')" required> 
                                            </div>
                                        </div>                                    
                                    </div>
                                    <hr>
                                </div>
                            </div> --}}


                           

                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="surface_habitable_vente_terrain">@lang('Surface Terrain') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                <input type="number" min="0" required class="form-control " value="{{old('surface_habitable_vente_terrain')}}" id="surface_habitable_vente_terrain" name="surface_habitable_vente_terrain" placeholder="@lang('m²')" > 
                                    @if ($errors->has('surface_habitable_vente_terrain'))
                                        <br>
                                        <div class="alert alert-warning ">
                                            <strong>{{$errors->first('surface_habitable_vente_terrain')}}</strong> 
                                        </div>
                                    @endif
                                </div>
                            </div>
                            

                           
                  
                         
                      
                           
        </div>

        
        
        <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="val-pays">@lang('Pays') <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-md-6">
                                <select class="js-select2 form-control" id="val-pays" name="pays_vente_terrain" style="width: 100%;" data-placeholder="Choose one.." required>

                                    <option value="France">@lang('France') </option>
                                    <option value="Belgique">@lang('Belgique') </option>
                                    <option value="España">@lang('España') </option>                   

                                </select>
                               
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="ville_vente_terrain">@lang('Ville') <span class="text-danger">*</span></label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('ville_vente_terrain')}}" id="ville_vente_terrain" name="ville_vente_terrain" required >
                                    
                                
                                </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_vente_terrain">@lang('Code postal') <span class="text-danger">*</span> </label>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" class="form-control " value="{{old('code_postal_vente_terrain')}}" id="code_postal_vente_terrain" name="code_postal_vente_terrain" placeholder="" required >
                                                              
                                </div>
                        </div>
                        <div class="row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_vente_terrain">@lang('Dossier')  </label>
                            <div class="col-lg-6 col-md-6">
                                
                                <hr>                                    
                                <div class="row">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_vente_terrain">@lang('N°')  <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="text" required class="form-control" value="{{old('numero_dossier_vente_terrain')}}" id="numero_dossier_vente_terrain" name="numero_dossier_vente_terrain" >
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row" id="div_date_creation_dossier_vente_terrain">                                         
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-form-label" for="date_creation_dossier_vente_terrain">@lang('Créé le') <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8">
                                            <input type="date" required class="form-control " value="{{old('date_creation_dossier_vente_terrain') }}" id="date_creation_dossier_vente_terrain" name="date_creation_dossier_vente_terrain" >
                                        </div>
                                    </div>                                    
                                </div>
                                <hr>
                            </div>
                    </div>

                           
                       
        </div>
    </div> 
     
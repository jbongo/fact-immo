<div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="media">
                    <div class="p-5 bg-dark media-left media-middle">
                        <i class="ti-info-alt f-s-28 color-white"></i>
                    </div>
                    <div class="p-10 media-body">
                        <h4 class="color-warning m-r-10">@lang('Section cadastrale') </h4>
                        
                        <div class="progress progress-sm m-t-10 m-b-0">
                            <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
  
<div class="row">
    <div class="col-md-6 col-lg-6">

        <div class="form-group row">
            <label class="col-lg-4 col-form-label" for="section_secteur"  >@lang('Section')  <span class="text-danger">*</span> </label>
            <div class="col-lg-6">
                <input type="text" required  class="form-control " value="" id="section_secteur" name="section_secteur"  >
            </div>
        </div>

    </div>

    <div class="col-md-6 col-lg-6">
             
        <div class="form-group row">
            <label class="col-lg-4 col-form-label" for="parcelle_secteur" >@lang('Parcelle')  <span class="text-danger">*</span> </label>
            <div class="col-lg-6">
                <input type="number" requiredgit  min="0"  class="form-control " value="" id="parcelle_secteur" name="parcelle_secteur"  >
            </div>
        </div>
    </div>
</div>



<a href="#" id="add_section" class="btn btn-dark btn-flat btn-addon m-b-10 m-l-5"><i class="ti-save "></i>@lang('Ajouter')</a>
<br>
<hr>

<div id="liste_section">
    <div class="table-responsive" style="overflow-x: inherit !important;">
        <table  id="" class=" table"  style="width:70%">
            <thead>
                <tr>
                    <th>@lang('Section')</th>                                        
                    <th>@lang('Parcelle')</th>                                        
                    
                </tr>
            </thead>
            <tbody id="section_tab">
            
            </tbody>
        </table>
    </div>
</div>
  
  
  
  
  
  
  
  
  
  
  
  
  <div class="row">
    <div class="col-lg-12">
        <div class="card p-0">
            <div class="media">
                <div class="p-5 bg-info media-left media-middle">
                    <i class="ti-info-alt f-s-28 color-white"></i>
                </div>
                <div class="p-10 media-body">
                    <h4 class="color-warning m-r-10">@lang('Secteur du bien ') </h4>
                    
                    <div class="progress progress-sm m-t-10 m-b-0">
                        <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>


    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="pays_annonce_secteur">@lang('Pays de l\'annonce') </label>
                        <div class="col-lg-6">
                            <select class="js-select2 form-control" id="pays_annonce_secteur" name="pays_annonce_secteur" style="width: 100%;" >

                                <option value="France">@lang('France') </option>
                                <option value="Belgique">@lang('Belgique') </option>
                                <option value="España">@lang('España') </option>
                                

                            </select>  
                            
                        </div>
            </div>
                            
        </div>

    </div>
    <br>
 
        {{-- <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_public_secteur">@lang('Code postal public') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="code_postal_public_secteur" name="code_postal_public_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="ville_publique_secteur">@lang('Ville publique') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="ville_publique_secteur" name="ville_publique_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="code_postal_prive_secteur">@lang('Code postal privé') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="code_postal_prive_secteur" name="code_postal_prive_secteur"  >
                </div>
            </div>

        </div> --}}
        {{-- <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="ville_prive_secteur">@lang('Ville privée') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="ville_prive_secteur" name="ville_prive_secteur"  >
                </div>
            </div>

        </div> --}}
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="adresse_bien_secteur">@lang('Adresse du bien') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="adresse_bien_secteur" name="adresse_bien_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="complement_adresse_secteur">@lang('Complément d\'adresse') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="complement_adresse_secteur" name="complement_adresse_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="quartier_secteur">@lang('Quartier') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="quartier_secteur" name="quartier_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="secteur_secteur">@lang('Secteur') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="secteur_secteur" name="secteur_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="immeuble_batiment_secteur">@lang('Immeuble/Bâtiment') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="immeuble_batiment_secteur" name="immeuble_batiment_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="transport_a_proximite_secteur">@lang('Transports à proximité') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="transport_a_proximite_secteur" name="transport_a_proximite_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="proximite_secteur">@lang('Proximité') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="proximite_secteur" name="proximite_secteur"  >
                </div>
            </div>

        </div>
        <div class="row">

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="environnement_secteur">@lang('Environnement') </label>
                <div class="col-lg-6 col-md-6">
                    <input type="text" class="form-control "  id="environnement_secteur" name="environnement_secteur"  >
                </div>
            </div>

        </div>
        
<div class="row">
    <div class="col-lg-12">
        <div class="card p-0">
            <div class="media">
                <div class="p-5 bg-info media-left media-middle">
                    <i class="ti-info-alt f-s-28 color-white"></i>
                </div>
                <div class="p-10 media-body">
                    <h4 class="color-warning m-r-10">@lang('Ajoutez une nouvelle pièce et détaillez sa composition ') </h4>
                    
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
                                    <label class="col-lg-4 col-form-label" for="piece_composition">@lang('Pièce') </label>
                                    <div class="col-lg-6">
                                        <select class="js-select2 form-control" id="piece_composition" name="piece_composition" style="width: 100%;"  >                                                                                                                   
                                           
                                            <option value="Accueil">@lang('Accueil') </option>
                                            <option value="Annexe">@lang('Annexe') </option>
                                            <option value="Balcon">@lang('Balcon') </option>
                                            <option value="Buanderie">@lang('Buanderie') </option>
                                            <option value="Bureau">@lang('Bureau') </option>
                                            <option value="Cave">@lang('Cave') </option>
                                            <option value="Cellier">@lang('Cellier') </option>
                                            <option value="Chambre">@lang('Chambre') </option>
                                            <option value="Chambre froide">@lang('Chambre froide') </option>
                                            <option value="Cuisine">@lang('Cuisine.') </option>
                                            <option value="Dépôt">@lang('Dépôt') </option>
                                            <option value="Dressing">@lang('Dressing') </option>
                                            <option value="Entrée">@lang('Entrée') </option>
                                            <option value="Entrepot">@lang('Mlle') </option>
                                            <option value="Espace bien-être">@lang('Espace bien-être') </option>
                                            <option value="Garage">@lang('Garage') </option>
                                            <option value="Jardin">@lang('Jardin') </option>
                                            <option value="Loggia">@lang('Loggia') </option>
                                            <option value="Mezzanine">@lang('Mezzanine') </option>
                                            <option value="Parking">@lang('Parking') </option>
                                            <option value="Pièce à vivre">@lang('Pièce à vivre') </option>
                                            <option value="Piscine">@lang('Piscine') </option>
                                            <option value="Réserve">@lang('Réserve') </option>
                                            <option value="Salle d'eau">@lang('Salle d\'eau') </option>
                                            <option value="Salle de bain">@lang('Salle de bain') </option>
                                            <option value="Salon/Séjour">@lang('Salon/Séjour') </option>
                                            <option value="Suite">@lang('Suite') </option>
                                            <option value="Terrain">@lang('Terrain') </option>
                                            <option value="Terrasse">@lang('Terrasse') </option>
                                            <option value="Véranda">@lang('Véranda') </option>
                                            <option value="Vestiare">@lang('Vestiare') </option>
                                            <option value="WC">@lang('WC') </option>
                                            
                                            
                                        </select>
                                        
                                        
                                    </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="detail_piece_composition">@lang('Détail de la pièce')</label>
                            <div class="col-lg-6">
                            <textarea class="form-control" id="detail_piece_composition" name="detail_piece_composition"  rows="4" placeholder="" ></textarea>
  
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="surface_composition">@lang('Surface (m²)') </label>
                                <div class="col-lg-6">
                                <input type="text"  class="form-control " value="" id="surface_composition" name="surface_composition"  >
                                
                            </div>
                        </div>

    </div>


    
    <div class="col-md-6 col-lg-6">

         
                    <div class="form-group">
                        <label class="col-lg-4 col-form-label" for="note_composition">@lang('Note') </label>
                        <div class="col-lg-8">
                            <textarea class="form-control" id="note_composition" name="note_composition"  rows="4" placeholder="" ></textarea>
                            <span class="help-block">
                            <small></small>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="note_publique_composition" id="note_publique_composition" value="public">
                                    <label class="form-check-label" for="note_publique_composition">@lang('Publique')</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="note_prive_composition" type="checkbox" id="note_privee_composition" value="privée">
                                    <label class="form-check-label" for="note_privee_composition">@lang('Privée')</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="note_inter_agence_composition" type="checkbox" id="note_inter_agence_composition" value="Inter-agence" >
                                    <label class="form-check-label" for="note_inter_agence_composition">@lang('Inter-agence')</label>
                                </div>
                            </div>

                        </div>
                        
                          
                         <hr>
                        
                    </div>
           
                    
                    <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="etage_composition">@lang('Etage') </label>
                            <div class="col-lg-6">
                                <input type="number" min="0" max="200" class="form-control " value="" id="etage_composition" name="etage_composition"  >
                               
                            
                            </div>
                    </div>

                    


    </div>
</div>



<a id="add_piece"  class="btn btn-dark btn-flat btn-addon m-b-10 m-l-5"><i class="ti-save "></i>@lang('Ajouter')</a>
<br>
<hr>
<div class="row">
    <div class="col-lg-12">
        <div class="p-10 media-body">
            <h4 class="color-dark m-r-10">@lang('Liste des pièces déjà enregistrées ') </h4>
            
            <div class="progress progress-sm m-t-10 m-b-0">
                <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
<br>

    <div id="liste_piece" class="table-responsive" style="overflow-x: inherit !important;">
        <table  id="" class=" table"  style="width:70%">
            <thead>
                <tr>
                    <th>@lang('Pièce')</th>                                        
                    <th>@lang('Détail')</th>                                        
                    <th>@lang('Surface')</th>
                    <th>@lang('Note')</th>
                    <th>@lang('Etage')</th>
                </tr>
            </thead>
            <tbody id="composition_tab">
        
          </tbody>
        </table>
    </div>


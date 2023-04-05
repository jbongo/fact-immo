<div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="media">
                    <div class="p-5 bg-dark media-left media-middle">
                        <i class="ti-info-alt f-s-28 color-white"></i>
                    </div>
                    <div class="p-10 media-body">
                        <h4 class="color-dark m-r-10">@lang('Informations financières ') </h4>
                        
                        <div class="progress progress-sm m-t-10 m-b-0">
                            <div class="progress-bar boxshadow-none  bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            {{-- VENTE --}}
            <div class=" row div_prix_vente" >
                <label class="col-lg-2 col-md-2 col-form-label" for="prix_net_info_fin">@lang('Prix') </label>
                <div class="col-lg-10 col-md-10">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_net_info_fin">@lang('Prix net vendeur (€)') <span class="text-danger">*</span> </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" required min="0" class="form-control " id="prix_net_info_fin" name="prix_net_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_info_fin">@lang('Public (€)') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" required class="form-control "  id="prix_public_info_fin" name="prix_public_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
      
                    <div class="row">
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_acquereur_info_fin">@lang('Honoraires charge Acquéreur') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_acquereur_info_fin_non" name="honoraire_acquereur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_acquereur_info_fin_oui"  name="honoraire_acquereur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_honoraire_acquereur_info_fin">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_acquereur_info_fin">@lang('Part Acquéreur (TTC) €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_acquereur_info_fin" name="part_acquereur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_prix_info_fin">@lang('Taux Prix Public %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="taux_prix_info_fin" name="taux_prix_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div> 
                    </div>

                    <div class="row">
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_vendeur_info_fin">@lang('Honoraires charge Vendeur') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_vendeur_info_fin_non" name="honoraire_vendeur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_vendeur_info_fin_oui" name="honoraire_vendeur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_honoraire_vendeur_info_fin">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_vendeur_info_fin">@lang('Part Vendeur (TTC) €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_vendeur_info_fin" name="part_vendeur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_net_info_fin">@lang('Taux Net Vendeur %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0"  class="form-control "  id="taux_net_info_fin" name="taux_net_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div>  
                    </div>

                </div>
            </div>
          {{-- LOCATION --}}
          <div class="div_prix_location">                        
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="loyer">@lang('Loyer (€)') <span class="text-danger">*</span> </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" required min="0" class="form-control " id="loyer" name="loyer" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="complement_loyer">@lang('Complément Loyer €') <span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" required class="form-control "  id="complement_loyer" name="complement_loyer" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
      
                    <div class="row"  >
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_acquereur_info_fin">@lang('Part Locataire') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_acquereur_info_fin_non" name="honoraire_acquereur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_acquereur_info_fin_oui"  name="honoraire_acquereur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_part_locataire">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_acquereur_info_fin">@lang('Montant €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_acquereur_info_fin" name="part_acquereur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_prix_info_fin">@lang('Pourcentage %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="taux_prix_info_fin" name="taux_prix_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div> 
                    </div>

                    <div class="row" >
                        <div class="form-group row">   
                            <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_vendeur_info_fin">@lang('Part Propriétaire') </label>
                            <div class="col-lg-8 col-md-8">
                                <label class="radio-inline"><input type="radio" checked value="@lang('Non')" id="honoraire_vendeur_info_fin_non" name="honoraire_vendeur_info_fin" >@lang('Non')</label>
                                <label class="radio-inline"><input type="radio" value="@lang('Oui')" id="honoraire_vendeur_info_fin_oui" name="honoraire_vendeur_info_fin" >@lang('Oui')</label>
                            </div>
                        </div>
                        <div class="row" id="div_part_proprietaire">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="part_vendeur_info_fin">@lang('Montant €') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0" class="form-control "  id="part_vendeur_info_fin" name="part_vendeur_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="taux_net_info_fin">@lang('Pourcentage %') </label>
                                <div class="col-lg-4 col-md-4">
                                    <input type="number" min="0"  class="form-control "  id="taux_net_info_fin" name="taux_net_info_fin" placeholder="@lang('%')" > 
                                </div>
                            </div>                                       
                        </div>  
                    </div>

                </div>
            </div>
    </div>
    <br>
    <hr>
        
    <div class="row">
        <div class="col-md-6 col-lg-6">

                            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="estimation_valeur_info_fin">@lang('Estimation') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="estimation_valeur_info_fin">@lang('Valeur') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('estimation_valeur_info_fin')}}" id="estimation_valeur_info_fin" name="estimation_valeur_info_fin" placeholder="@lang('€')" > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="estimation_date_info_fin">@lang('date') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="date"  class="form-control "  id="estimation_date_info_fin" name="estimation_date_info_fin" placeholder="" > 
                            </div>
                        </div>                                    
                    </div>                    
                    <hr>

                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="viager_valeur_info_fin">@lang('Viager') </label>
                <div class="col-lg-6 col-md-6">                           
                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="viager_valeur_info_fin">@lang('Prix du bouquet') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('viager_valeur_info_fin')}}" id="viager_valeur_info_fin" name="viager_valeur_info_fin"  > 
                            </div>
                        </div>                                    
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="viager_rente_mensuelle_info_fin">@lang('Rente Mensuelle') </label>
                            <div class="col-lg-8 col-md-8">
                                <input type="number" min="0" class="form-control " value="{{old('viager_rente_mensuelle_info_fin')}}" id="viager_rente_mensuelle_info_fin" name="viager_rente_mensuelle_info_fin" > 
                            </div>
                        </div>                                    
                    </div>                    
                    <hr>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="travaux_a_prevoir_info_fin">@lang('Travaux à prévoir') </label>
                <div class="col-lg-6 col-md-6">
                <input type="text"  class="form-control " id="travaux_a_prevoir_info_fin" name="travaux_a_prevoir_info_fin"  > 
                    
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="depot_garanti_info_fin">@lang('Dépôt de garantie') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="depot_garanti_info_fin" name="depot_garanti_info_fin" placeholder="@lang('€')" > 
                   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="taxe_habitation_info_fin">@lang('Taxe d\'habitation') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="taxe_habitation_info_fin" name="taxe_habitation_info_fin" placeholder="@lang('€')" > 
                    
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Taxe foncière') </label>
                <div class="col-lg-6 col-md-6">
                <input type="number" min="0" class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin" placeholder="@lang('€')" > 
                    
                </div>
            </div>

        </div>

        <div class="col-md-6 col-lg-6">

            <div class="row div_prix_vente">
                    <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Charges Mensuelles')  </label>
                    <div class="col-lg-6 col-md-6">
                                                      
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                                <div class="col-lg-8 col-md-8">
                                    <textarea class="form-control"  name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin" cols="30" rows="3" ></textarea>
                                </div>
                            </div>                                    
                        </div>
                        <hr>
                    </div>
            </div>

            <div class="row div_prix_location">
                    <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Charges Locatives')  </label>
                    <div class="col-lg-6 col-md-6">                                                      
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="@lang('€')" > 
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">                                         
                            <div class="form-group row">
                                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                                <div class="col-lg-6 col-md-6">
                                    <textarea class="form-control"  name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin" cols="30" rows="3" ></textarea>
                                </div>
                            </div>                                    
                        </div>
                        <hr>
                    </div>
                   
                  
                    <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Durée du bail (mois)')  </label>
                        <div class="col-lg-8 col-md-8">
                            <input type="number" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="mois" > 
                        </div>
                    </div>
                    
            </div>

        </div>
    </div> 
     
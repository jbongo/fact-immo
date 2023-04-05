<div id="bloc_prix">

    <form action="{{route('bien.update',$bien->id)}}" id="prix" method="post">
        @csrf

        <input type="text" name="type_update" hidden value="prix" >

<div class="row">
    <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
            <h4> <strong>@lang('Informations')</strong> @lang('complémentaires & prix')</h4>                          
    </div>
    <div class="col-md-1 col-lg-1 col-sm-1">
        <a  class="btn btn-dark" id="btn_update_infos_prix" style="height: 39px;margin-left:-10px;margin-bottom:10px;">
            <i class="material-icons">mode_edit</i>
        </a>         
    </div>        
</div>
<br>
<br>
<div class="row">
    <div class="col-md-6 col-lg-6 col-lg-offset-2 col-md-offset-2">
        <button id="btn_enregistrer_prix" class="btn btn-dark btn-flat btn-addon btn-lg "  style="position: fixed;bottom: 10px; z-index:1 ;" type="submit"><i class="ti-save"></i>@lang('Enregistrer')</button>
    </div>
</div>

<div class="row">
    <div class="col-md-11 col-lg-11 col-sm-11">
        <div class="form-group row">
            <label class="col-lg-2 col-md-2 col-form-label" for="prix_net_info_fin">@lang('Prix') </label>
            <div class="col-lg-10 col-md-10">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="prix_net_info_fin">@lang('Prix net vendeur (€)') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="number" value="{{$bien->bienprix->prix_prive}}" min="0" class="form-control " id="prix_net_info_fin" name="prix_prive" placeholder="@lang('€')" > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->prix_prive}}
                        </div>
                    </div>                                    
                </div>
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="prix_public_info_fin">@lang('Public (€)') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="number" value="{{$bien->bienprix->prix_public}}" min="0" class="form-control "  id="prix_public_info_fin" name="prix_public" placeholder="@lang('€')" > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->prix_public}}
                        </div>
                    </div>                                    
                </div>
    
                <div class="row">
                    <div class="form-group row">   
                        <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_acquereur_info_fin">@lang('Honoraires charge Acquéreur') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            @php  $honoraire_acquer = $bien->bienprix->honoraire_acquereur @endphp
                            <label class="radio-inline"><input type="radio" @if($honoraire_acquer == "Non") checked  @endif  value="@lang('Non')" name="honoraire_acquereur_info_fin" checked>@lang('Non')</label>
                            <label class="radio-inline"><input type="radio" @if($honoraire_acquer == "Oui") checked  @endif  value="@lang('Oui')" name="honoraire_acquereur_info_fin" >@lang('Oui')</label>
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->honoraire_acquereur}}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="form-group row">   
                        <label class="col-lg-4 col-md-4 col-form-label" for="honoraire_vendeur_info_fin">@lang('Honoraires charge Vendeur') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                @php  $honoraire_ven = $bien->bienprix->honoraire_vendeur @endphp
                            <label class="radio-inline"><input type="radio" @if($honoraire_ven == "Non") checked  @endif value="@lang('Non')" name="honoraire_vendeur_info_fin" checked>@lang('Non')</label>
                            <label class="radio-inline"><input type="radio" @if($honoraire_ven == "Oui") checked  @endif value="@lang('Oui')" name="honoraire_vendeur_info_fin" >@lang('Oui')</label>
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->honoraire_vendeur}}
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
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="number" value="{{$bien->bienprix->estimation_valeur}}"  min="0" class="form-control "  id="estimation_valeur_info_fin" name="estimation_valeur_info_fin" placeholder="@lang('€')" > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->estimation_valeur}}
                        </div>
                    </div>                                    
                </div>
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="estimation_date_info_fin">@lang('date') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="date" value="{{$bien->bienprix->estimation_date}}" class="form-control "  id="estimation_date_info_fin" name="estimation_date_info_fin" placeholder="" > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->estimation_date}}
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
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="number" value="{{$bien->bienprix->viager_prix_bouquet}}" min="0" class="form-control "  id="viager_valeur_info_fin" name="viager_valeur_info_fin"  > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->viager_prix_bouquet}}
                        </div>
                    </div>                                    
                </div>
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="viager_rente_mensuelle_info_fin">@lang('Rente Mensuelle') </label>
                        <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                            <input type="number" value="{{$bien->bienprix->viager_rente_mensuelle}}" min="0" class="form-control " id="viager_rente_mensuelle_info_fin" name="viager_rente_mensuelle_info_fin" > 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                            {{$bien->bienprix->viager_rente_mensuelle}}
                        </div>
                    </div>                                    
                </div>                    
                <hr>

            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="travaux_a_prevoir_info_fin">@lang('Travaux à prévoir') </label>
            <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
            <input type="text" value="{{$bien->bienprix->travaux_a_prevoir}}"  class="form-control " id="travaux_a_prevoir_info_fin" name="travaux_a_prevoir_info_fin"  > 
                
            </div>
            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                {{$bien->bienprix->travaux_a_prevoir}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="depot_garanti_info_fin">@lang('Dépôt de garantie') </label>
            <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
            <input type="number" value="{{$bien->bienprix->depot_garanti}}" min="0" class="form-control " id="depot_garanti_info_fin" name="depot_garanti_info_fin" placeholder="@lang('€')" > 
                
            </div>
            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                {{$bien->bienprix->depot_garanti}}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="taxe_habitation_info_fin">@lang('Taxe d\'habitation') </label>
            <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
            <input type="number" value="{{$bien->bienprix->taxe_habitation}}" min="0" class="form-control " id="taxe_habitation_info_fin" name="taxe_habitation_info_fin" placeholder="@lang('€')" > 
                
            </div>
            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                {{$bien->bienprix->taxe_habitation}}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Taxe foncière') </label>
            <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
            <input type="number" value="{{$bien->bienprix->taxe_fonciere}}" min="0" class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin" placeholder="@lang('€')" > 
                
            </div>
            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                {{$bien->bienprix->taxe_fonciere}}
            </div>
        </div>

    </div>
   
    
    <div class="col-md-6 col-lg-6">

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="taxe_fonciere_info_fin">@lang('Montant foncier total') </label>
            <div class="col-lg-6 col-md-6 hide_champ_infos_prix">
            <input type="number" value="{{$bien->bienprix->taxe_fonciere}}" min="0" class="form-control " id="taxe_fonciere_info_fin" name="taxe_fonciere_info_fin" placeholder="@lang('€')" > 
                
            </div>
            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                {{$bien->bienprix->taxe_fonciere}}
            </div>
        </div>

        <div class="form-group row">
                <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Charges Mensuelles')  </label>
                <div class="col-lg-6 col-md-6">
                                                    
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_total_info_fin">@lang('Total')</label>
                            <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                <input type="number" value="{{$bien->bienprix->charge_mensuelle_total}}" min="0" class="form-control " id="charge_mensuelle_total_info_fin" name="charge_mensuelle_total_info_fin" placeholder="@lang('€')" > 
                            </div>
                            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                {{$bien->bienprix->charge_mensuelle_total}}
                            </div>   
                        </div>   
                                                      
                    </div>
                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="charge_mensuelle_info_info_fin">@lang('Informations')</label>
                            <div class="col-lg-8 col-md-8 hide_champ_infos_prix">
                                    <textarea class="form-control"  name="charge_mensuelle_info_info_fin" id="charge_mensuelle_info_info_fin" cols="30" rows="3" >{{$bien->bienprix->charge_mensuelle_info}}</textarea>

                            </div>
                            <div class="col-lg-6 col-md-6 show_champ_infos_prix">
                                {{$bien->bienprix->charge_mensuelle_info}}
                            </div>
                        </div>                                    
                    </div>
                    <hr>
                </div>
        </div>

    </div>
</div> 

<br>
<br>
<hr>
<div class="row">
    <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
            <h4> <strong>@lang('Dossier')</strong> @lang('& Disponibilité')</h4>                          
    </div>
    <div class="col-md-1 col-lg-1 col-sm-1">
        <a  class="btn btn-dark" id="btn_update_dossier_dispo" style="height: 39px;margin-left:-10px;margin-bottom:10px;">
            <i class="material-icons">mode_edit</i>
        </a>         
    </div>        
</div>
<br>
<br>
<div class="row" id="div_dossier">
    <div class="col-md-12 col-lg-12">

        <div class="form-group row">
            <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_dispo">@lang('Dossier') </label>
            <div class="col-lg-6 col-md-6">                           
                
                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="numero_dossier_dispo">@lang('Numéro') </label>
                        <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                            <input type="text" value="{{$bien->biendetail->dossier_dispo_numero}}"  class="form-control "  id="numero_dossier_dispo" name="numero_dossier_dispo"> 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                {{$bien->biendetail->dossier_dispo_numero}}
                        </div>
                    </div>                                   
                </div>

                <div class="row">                                         
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label" for="dossier_cree_le_dossier_dispo">@lang('Crée le') </label>
                        <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                            <input type="date" value="{{$bien->biendetail->dossier_dispo_dossier_cree_le}}"  class="form-control "  id="dossier_cree_le_dossier_dispo" name="dossier_cree_le_dossier_dispo"> 
                        </div>
                        <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                {{$bien->biendetail->dossier_dispo_dossier_cree_le}}
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
                            <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                @php  $disponibilite_immed = $bien->biendetail->dossier_dispo_disponibilite_immediate @endphp
                                <label class="radio-inline"><input type="radio" @if($disponibilite_immed == "Non précisé") checked  @endif value="@lang('Non précisé')" name="disponibilite_immediate_dossier_dispo" checked>@lang('Non précisé')</label>
                                <label class="radio-inline"><input type="radio" @if($disponibilite_immed == "Oui") checked  @endif value="@lang('Oui')" name="disponibilite_immediate_dossier_dispo" >@lang('Oui')</label>
                                <label class="radio-inline"><input type="radio" @if($disponibilite_immed == "Non") checked  @endif value="@lang('Non')" name="disponibilite_immediate_dossier_dispo">@lang('Non')</label>
                            </div>
                            <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{$bien->biendetail->dossier_dispo_disponibilite_immediate}}
                            </div>
                        </div>                                   
                    </div>

                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="disponible_le_dossier_dispo">@lang('Disponible le') </label>
                            <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                <input type="date" value="{{$bien->biendetail->dossier_dispo_disponible_le}}"  class="form-control "  id="disponible_le_dossier_dispo" name="disponible_le_dossier_dispo"> 
                            </div>
                            <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{$bien->biendetail->dossier_dispo_disponible_le}}
                            </div>
                        </div>                                   
                    </div>

                    <div class="row">                                         
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label" for="liberation_le_dossier_dispo">@lang('Libération le') </label>
                            <div class="col-lg-7 col-md-7 hide_champ_dossier_dispo">
                                <input type="date"  value="{{$bien->biendetail->dossier_dispo_liberation_le}}" class="form-control "  id="liberation_le_dossier_dispo" name="liberation_le_dossier_dispo"> 
                            </div>
                            <div class="col-lg-6 col-md-6 show_champ_dossier_dispo">
                                    {{$bien->biendetail->dossier_dispo_liberation_le}}
                            </div>
                        </div>                                   
                    </div>
                                   
                </div>
            </div>
    </div>
</div>

    </form>
</div>
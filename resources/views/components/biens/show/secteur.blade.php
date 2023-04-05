<div id="bloc_secteur">

    <form action="{{route('bien.update',$bien->biensecteur->id)}}" id="secteur" method="post">
        @csrf

        <input type="text" name="type_update" hidden value="secteur" >

<div class="row">
    <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
            <h4> <strong>@lang('Secteur')</strong></h4>                          
    </div>
    <div class="col-md-1 col-lg-1 col-sm-1">
        <a  class="btn btn-dark" id="btn_update_secteur" style="height: 39px;margin-left:-10px;margin-bottom:10px;">
            <i class="material-icons">mode_edit</i>
        </a>         
    </div>        
</div>

<hr>
<div class="row">
    <div class="col-md-6 col-lg-6 col-lg-offset-2 col-md-offset-2">
        <button id="btn_enregistrer_secteur" class="btn btn-dark btn-flat btn-addon btn-lg "  style="position: fixed;bottom: 10px; z-index:1 ;" type="submit"><i class="ti-save"></i>@lang('Enregistrer')</button>
    </div>
</div>

<div class="row">
<div class="col-md-12 col-lg-12">
    <div class="form-group row">
        <label class="col-lg-4 col-md-6 col-form-label" for="pays_annonce_secteur">@lang('Pays de l\'annonce') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <select class="js-select2 form-control" id="pays_annonce_secteur" name="pays_annonce_secteur" style="width: 100%;" >
                @if($bien->biensecteur->pays_annonce)
                <option value="{{$bien->biensecteur->pays_annonce}}">{{$bien->biensecteur->pays_annonce}} </option>
                @endif
                <option value="France">@lang('France') </option>
                <option value="Belgique">@lang('Belgique') </option>
                <option value="España">@lang('España') </option>
                
            </select>  
            
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->pays_annonce}}
        </div>
    </div>
                    
</div>

</div>
<br>

<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="adresse_bien_secteur">@lang('Adresse du bien') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->adresse_bien}}" class="form-control "  id="adresse_bien_secteur" name="adresse_bien_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->adresse_bien}}
        </div>
    </div>

</div>
<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="complement_adresse_secteur">@lang('Complément d\'adresse') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->complement_adresse}}" class="form-control "  id="complement_adresse_secteur" name="complement_adresse_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->complement_adresse}}
        </div>
    </div>

</div>
<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="quartier_secteur">@lang('Quartier') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->quartier}}" class="form-control "  id="quartier_secteur" name="quartier_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->quartier}}
        </div>
    </div>

</div>
<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="secteur_secteur">@lang('Secteur') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->secteur}}" class="form-control "  id="secteur_secteur" name="secteur_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->secteur}}
        </div>
    </div>

</div>
<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="immeuble_batiment_secteur">@lang('Immeuble/Bâtiment') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->immeuble_batiment}}" class="form-control "  id="immeuble_batiment_secteur" name="immeuble_batiment_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->immeuble_batiment}}
        </div>
    </div>

</div>
<div class="row">

    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="transport_a_proximite_secteur">@lang('Transports à proximité') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->transport_a_proximite}}" class="form-control "  id="transport_a_proximite_secteur" name="transport_a_proximite_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->transport_a_proximite}}
        </div>
    </div>

</div>
<div class="row">
    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="proximite_secteur">@lang('Proximité') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->proximite}}" class="form-control "  id="proximite_secteur" name="proximite_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->proximite}}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group row">
        <label class="col-lg-4 col-md-4 col-form-label" for="environnement_secteur">@lang('Environnement') </label>
        <div class="col-lg-6 col-md-6 hide_champ_secteur">
            <input type="text" value="{{$bien->biensecteur->environnement}}" class="form-control "  id="environnement_secteur" name="environnement_secteur"  >
        </div>
        <div class="col-lg-6 col-md-6 show_champ_secteur">
            {{$bien->biensecteur->environnement}}
        </div>
    </div>
</div>
    </form>
</div>
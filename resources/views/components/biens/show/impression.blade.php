<div class="row">
    <div class="col-md-11 col-lg-11 col-sm-11 "style="background: #5c96b3; color: white;">
            <h4> <strong>@lang('Impressions')</strong> @lang('de fiches')</h4>                     
    </div>
    <div class="col-md-1 col-lg-1 col-sm-1">
        <a  class="btn btn-dark" style="height: 39px;margin-left:-10px;margin-bottom:10px;">
            <i class="material-icons">print</i>
        </a>         
    </div>        
</div>
<br>
<br>
<br>

<div class="row">
    <div class="col-sm-4 col-md-4 col-lg-4">
        <p><strong>@lang('Fiche Visite')</strong></p>
        <br>
        <a class="btn btn-success" id="" > <img src="{{asset('images/fiche_visite.png')}}" width="250px" height="300px" alt="fiche visite stylimmo"></a>
        <p>
            <a target="_blank" href="{{route('imprimeFiche',[$bien->id,'visite','print'])}}"  class="btn btn-danger btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-printer"></i>Imprimer</a>
            <a  href="{{route('imprimeFiche',[$bien->id,'visite','download'])}}" class="btn btn-dark btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-download"></i>Télécharger</a>
        </p>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        <p><strong>@lang('Fiche Privée')</strong></p>
        <br>
        <a class="btn btn-danger" id="" > <img src="{{asset('images/fiche_privee.png')}}" width="250px" height="300px" alt="fiche visite stylimmo"></a>
        <p>
            <a target="_blank" href="{{route('imprimeFiche',[$bien->id,'privee','print'])}}"  class="btn btn-danger btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-printer"></i>Imprimer</a>
            <a href="{{route('imprimeFiche',[$bien->id,'privee','download'])}}"  class="btn btn-dark btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-download"></i>Télécharger</a>
        </p>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
            <p><strong>@lang('Fiche agence')</strong></p>
            <br>
            <a class="btn btn-pink" id="" > <img src="{{asset('images/fiche_privee.png')}}" width="250px" height="300px" alt="fiche visite stylimmo"></a>
            <p>
                <a target="_blank" href="{{route('imprimeFiche',[$bien->id,'privee','print'])}}"  class="btn btn-danger btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-printer"></i>Imprimer</a>
                <a href="{{route('imprimeFiche',[$bien->id,'privee','download'])}}"  class="btn btn-dark btn-flat btn-addon m-t-10 m-b-10 m-l-5 "><i class="ti-download"></i>Télécharger</a>
            </p>
        </div>
</div>
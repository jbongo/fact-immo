@extends('layouts.app')

@section('content')
@section ('page_title')
Ajouter les photos
@endsection
<div id="main-content">
    <div class="card alert">
        <div class="card-header">
            <h4></h4>
            <div class="card-header-right-icon">
                
            </div>
        </div>
        <div class="card-body">
       
            <div class="row" id="add-photo">
                <div class="col-lg-12" id=>
                    <h2 class="page-heading"><span>@lang("Photos de l'article") </span></h2>
            
                    <form method="post" id="form-photo" action = "{{route('picture.store',$product_id)}}"
                            enctype="multipart/form-data" class="dropzone" id="fileupload">
                        {{ csrf_field() }}
                        <div class="dz-message">
                            <div class="col-xs-8">
                                <div class="message">
                                    <p>@lang('Déplacez les photos ici ou cliquez pour uploader')</p>
                                </div>
                            </div>
                        </div>
                        <div class="fallback">
                            <input type="file" name="file" multiple>
                            
                        </div>
                        
                    </form>
            
                </div>
            </div>
            <br><br><br><br>
            <div class="row">
                        <div class="col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4">
                        <button  id="ajouter-photo" style="width:160px" name="ajouterSeul" class="btn btn-lg btn-success"> @lang('TERMINER')</button>
                        </div>
                    </div>
        </div>
    </div>
</div>     
@endsection

@section('js-content')

@endsection
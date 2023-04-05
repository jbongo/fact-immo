<div id="photos">
    
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 "style="background:#811767; color:white">
        <h4> <strong>@lang('Gestion des photos')</strong> @lang('pour ce bien')</h4>                          
    </div>
    
    <div class="col-md-12 col-lg-12 col-sm-12 ">
            <br>
        <h5> @lang('Choisissez la position des photos que vous voulez pour ce bien')</h5>                          
    </div>
    
</div>

<br>
<hr>


<div class="row">
    <div class="col-md-10 col-lg-10 col-sm-10 "style="background: #5c96b3; color: white;">
        <h4> <strong>@lang('Photos visibles')</strong> @lang(' sur votre site et dans vos exports')</h4>                          
    </div>
    <div class="col-md-2 col-lg-2 col-sm-2" style="background:green; color:white">
       <h4> @lang('VISIBLE')</h4>        
    </div>        
</div>

<hr>

<div class="row" >
    <div class="col-md-12 col-lg-12" id="liste_photo_visible" >          
           
      
            <ul id="sortable_visible">
                @foreach($liste_photos as $photosbien )
                    @if($photosbien->visibilite == "visible")
                        <div class="col-lg-3 col-md-3" id="{{$photosbien->id}}"> 
                            <div style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                <li ><span class="badge badge-info "></span><p><img src="{{asset('/images/photos_bien/'.$photosbien->filename)}}" alt="aaa" width="100%" height="120px"></p></li>
                                <p style="border: 3px solid green; text-align:center">
                                    <a href="{{route('photoDelete',$photosbien->id)}}" class="delete" data-toggle="tooltip" title="@lang('Supprimer cette photo')"><i class="material-icons">delete_forever</i> </a>
                                <a href="{{route('bien.getPhoto',$photosbien->id)}}" title="@lang('Télécharger cette photo')" ><i class="material-icons">file_download</i> </a>
                                    <a title="@lang('Déplacer cette photo')" ><i class="large material-icons">zoom_out_map</i> </a>
                                </p>                                
                            </div>
                        </div>
                    @endif 
                @endforeach
                
            </ul>    
            <div class="col-lg-2 col-md-2 " id="clic_add_photo_visible" style=" border: 1px solid grey; cursor: cell;" >
                <p><img src="{{asset('/images/img_upload.png')}}" alt="" width="100%" height="200px"></p>
            </div> 
                 
    </div>
    {{-- Ajout des photos visibles --}}
    <div id="div_add_photo_visible">

        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2 ">
                <h2 class="page-heading">@lang('Photos visibles ')</h2>
        
                <form method="post" action="{{ route('savetof',["visible",$bien_id_crypt]) }}"
                        enctype="multipart/form-data" class="dropzone" id="fileupload">
                    {{ csrf_field() }}
                    <div class="dz-message">
                        <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
                            <div class="message">
                                <p>@lang('Déplacez les fichiers ici ou cliquez pour uploader')</p>
                            </div>
                        </div>
                    </div>
                    <div class="fallback">
                        <input type="file" name="file" multiple>               
                    </div>         
                </form>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
           
            <button id="refresh_div_visible" style="width:160px" name="ajouterSeul" class="btn btn-lg btn-success" > @lang('Terminer') </button>
            </div>
        </div>
    </div>
    
    <br>
    <br>     
        
    <button class="btn btn-danger" id="btn_save_visible" type="submit"><i class="large material-icons large">save</i> @lang('Sauvegarder')</button>


</div>
<hr>
<br>



<br>

<div class="row">
    <div class="col-md-10 col-lg-10 col-sm-10 "style="background: #5c96b3; color: white;">
        <h4> <strong>@lang('Photos non visibles')</strong> </h4>                          
    </div>
    <div class="col-md-2 col-lg-2 col-sm-2" style="background:red; color:white">
        <h4> @lang('NON VISIBLE')</h4>        
    </div>        
</div>
<hr>

<br>

<div class="row" >
    <div class="col-md-12 col-lg-12" id="liste_photo_invisible" >          
            
        
            <ul id="sortable_invisible">
                @foreach($liste_photos as $photosbien )
                    @if($photosbien->visibilite == "invisible")
                        <div class="col-lg-3 col-md-3" id="{{$photosbien->id}}"> 
                            <div style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                <li ><span class="badge badge-info "></span><p><img src="{{asset('/images/photos_bien/'.$photosbien->filename)}}" alt="aaa" width="100%" height="120px"></p></li>
                                <p style="border: 3px solid green; text-align:center">
                                    <a href="{{route('photoDelete',$photosbien->id)}}" class="delete" data-toggle="tooltip" title="@lang('Supprimer cette photo')"><i class="material-icons">delete_forever</i> </a>
                                <a href="{{route('bien.getPhoto',$photosbien->id)}}" title="@lang('Télécharger cette photo')" ><i class="material-icons">file_download</i> </a>
                                    <a title="@lang('Déplacer cette photo')" ><i class="large material-icons">zoom_out_map</i> </a>
                                </p>                                
                            </div>
                        </div>
                    @endif 
                @endforeach
                
            </ul>    
            <div class="col-lg-2 col-md-2 " id="clic_add_photo_invisible" style=" border: 1px solid grey; cursor: cell;" >
                <p><img src="{{asset('/images/img_upload.png')}}" alt="" width="100%" height="200px"></p>
            </div> 
                    
    </div>
    {{-- Ajout des photos non visibles --}}
    <div id="div_add_photo_invisible">

        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2 ">
                <h2 class="page-heading">@lang('Photos non visibles ')</h2>
        
                <form method="post" action="{{ route('savetof',["invisible",$bien_id_crypt]) }}"
                        enctype="multipart/form-data" class="dropzone" id="fileupload">
                    {{ csrf_field() }}
                    <div class="dz-message">
                        <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
                            <div class="message">
                                <p>@lang('Déplacez les fichiers ici ou cliquez pour uploader')</p>
                            </div>
                        </div>
                    </div>
                    <div class="fallback">
                        <input type="file" name="file" multiple>               
                    </div>         
                </form>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8  col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
            
            <button id="refresh_div_invisible" style="width:160px" name="ajouterSeul" class="btn btn-lg btn-success" > @lang('Terminer') </button>
            </div>
        </div>
    </div>
    
    <br>
    <br>     
        
    <button class="btn btn-danger" id="btn_save_invisible" type="submit"><i class="large material-icons large">save</i> @lang('Sauvegarder')</button>


</div>

</div>
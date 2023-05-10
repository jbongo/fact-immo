@extends('layouts.app')
@section('content')
@section('page_title')
    Diffusion programmée
@endsection
<style>
    .btn-blue{
        background-color:#03a9f5;
        color: white; 
    }
    
    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    .linetop{
        border-top: 1px dotted;
    }

</style>

<div class="row">

    <div class="col-lg-6 col-md-6">
            <div class="card alert nestable-cart">
                <div class="card-header">
                    <p>
                        <h4><strong style="color:blueviolet;">@lang('Annonces')</strong><a href="#"> </a></h4>
                        <br>
                        <a type="button" data-toggle="modal" data-target="#add-category" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-pencil-alt"></i>@lang('Ajouter une annonce')</a>
                        <a type="button" data-toggle="modal" data-target="#offrelist" class="btn btn-warning btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-eye"></i>@lang('Liste des annonces')</a>

                </div>
            </div>
    </div>

    <div class="col-lg-6">
        
    </div>
</div>
        
    
    <div class="row"> 
       
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
            <div class="card alert">
                <!-- table -->
            {{-- <a href="{{route('bien.add')}}" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-home"></i>@lang('Ajouter un bien')</a> --}}
               
                <div class="card-body">
                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('#')</th>                                        
                                        <th>@lang('')</th>                
                                        <th>@lang('')</th>                
                                        <th>@lang('')</th>                
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($biens as $bien)
                                    {{-- @foreach($bien->passerelles as) --}}
                                    <tr>
                                    
                                        <td width="20%">

                                        @foreach($bien->photosbiens as $photos)
                                            @if($photos->visibilite == "visible" && $photos->image_position == 1)
                                                <img src="{{asset("images/photos_bien/".$photos->filename)}}" width="200px" height="150px" alt="">  
                                                @break
                                            @endif
                                        @endforeach
                                       

                                        </td>
                                        <td  width="20%">
                                       
                                            <h4>
                                                <b> {{$bien->type_bien}}</b>  
                                                @if($bien->type_bien != "terrain")
                                                - {{$bien->nombre_piece}} @lang('pièces') 
                                                @endif
                                                - {{$bien->surface_habitable}} @lang('m²')
                                            </h4>
                                            
                                            <h5> {{$bien->ville}} ({{$bien->code_postal}})</h5><br><br>
                                            <h6> @lang('Passerelles associées') : <span class="text-danger"> 5</span> </h6>
                                            <h6> @lang('Nombre de diffusions') : <span class="text-success"> 15</span></h6>
                                        </td>
                                                        
                                        <td>
                                            <h4><b> <span style="color:blue">{{$bien->prix_public}} @lang('€')</b> </span> </h4>
                                            <h6>@lang('Ajouté le '){{$bien->created_at->format("d/m/Y")}} </h6>
                                            </h5>                                            

                                        </td>                              
                                        <td>                                             
                                            <a type="button" target="_blank"  href="{{route('annonce.index',Crypt::encrypt($bien->id))}}" class="btn btn-success btn-rounded  m-l-10 m-b-10" type="button"><span class="badge"> {{count($bien->annonces)}}</span> @lang('Annonces') </a>
                                        <a type="button" href="{{route('diffusion_prog.add',Crypt::encrypt($bien->id))}}" id="{{$bien->id}}"  class="btn btn-blue btn-rounded btn-addon  m-l-10 m-b-10 amodal" type="button"><i class="ti-settings"></i>@lang('Programmer une diffusion') </a>
                                            <a href="{{route('diffusion_prog.show',['all',$bien->id])}}" target="_blank" id="{{$bien->id}}"  class="btn btn-warning btn-rounded btn-addon  m-l-10 m-b-10" type="button"><i class="ti-eye"></i>@lang('Voir les diffusions') </a>
                                        </td>
                                       
                                    </tr>
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                <!-- end table -->
            </div>
        </div>

    </div>

    
<!-- BEGIN MODAL AJOUTER ANNONCE -->

<div class="modal fade none-border" id="add-category" style="display: block; margin:auto; width:50%; ">
    <div class="modal-dialog2">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Création d'annonce </strong></h4>
            </div>
        <form action="" >
            <div class="modal-body">
            
                    @csrf
                    <center> <h4 class="text-success">@lang('Sélectionnez le bien')</h4> </center>  
                    <div class="form-group row" id="">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="selectpicker col-lg-12  col-md-12 col-sm-12" id="bien_id" name="bien_id" data-live-search="true" data-style="btn-default btn-rounded" required>
                                @foreach($biens as $bien)
                                @php
                                    $bien__id = Crypt::encrypt($bien->id);
                                @endphp
                                    <option value="{{$bien__id}}" data-tokens="{{$bien->titre_annonce}} {{$bien->description_annonce}}"> {{$bien->titre_annonce}} - {{$bien->surface_terrain}} m² </option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <br><br><br><br>
                    <br><br><br><br>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('Fermer')</button>
                <button type="submit" id="select_bien"  class="btn btn-success waves-effect waves-light save-category">@lang('Valider')</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- END MODAL --> 




<!-- BEGIN MODAL PROGRAMMER DIFFUSION -->

<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-diffusion" data-backdrop="static">
    <div class="modal-dialog2" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>@lang('Associer des passerelles au bien') </strong></h4>
            </div>

            <form id="form_prog" action="#" method="POST">
                @csrf
            <div class="modal-body"> 
            <center> <h4 class="text-success">@lang('AVEC ABONNEMENT')</h4> </center>  
            <div id="avec-abon"></div>

            <hr>
            <br>
            <center> <h4 class="text-success">@lang('SANS ABONNEMENT')</h4> </center>  
            
                <div id="sans-abon"></div>

            <hr>
            <br>
            <center> <h4 class="text-success">@lang('INSTITUTIONNELLE ET PARTENAIRE')</h4> </center>  
            <div id="insti"></div>


            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect valider" >@lang('Suivant') <i class="ti-arrow-right "></i></button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('Annuler')</button>
            </div>  
        </form>
        </div>
    </div>
</div>
<!-- END MODAL -->     
@endsection

@section('js-content')
<script>

$( "#select_bien" ).click(function(e) {
e.preventDefault() ;
    var bien_id =  $( "#bien_id option:selected" ).attr("value");
    console.log(bien_id);
    
    var url = "/annonce/create/"+bien_id ;
    console.log(url);
    
    $(location).attr('href','{{url("/annonce/create/")}}/'+bien_id);
    
  });


  $('.amodal').on('click',function(){
    
    var id = $(this).attr('id') ;
    $("#sans-abon").html("");
    $("#avec-abon").html("");
    $("#insti").html("");

    $(".valider").attr("id",id);

    
    $.ajax({
        url: '/get-passerelles/'+id,
        type: 'GET',
        dataType: 'text',
        success: function(data, statut){
            var passerelles = JSON.parse(data);
            
            var check = "";
            
            for(var i = 0; i < passerelles.length -1; i++){

                if(passerelles[i].type == "Avec abonnement"){
                    $("#sans-abon").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]"   id= "'+id+'_'+passerelles[i].id+'"></div></div>');
                }else if(passerelles[i].type == "Sans abonnement"){
                    $("#avec-abon").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]"   id= "'+id+'_'+passerelles[i].id+'"></div></div>');                    
                }else if(passerelles[i].type == "Institutionnelle et partenaire"){
                    $("#insti").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]"   id= "'+id+'_'+passerelles[i].id+'"></div></div>');                    
                }
            }
        },
        error: function(resultat,statut,erreur){
            console.log(resultat+'le statut'+statut);
            
        }

    });

});

$('.valider').click(function(e){
    e.preventDefault();
    
   var bien_id =  $(this).attr('id') ;

    var data = Array();
// console.log($('.passerelles'));
//     for( var i = 0; i < $('.passerelles').length ; i++){
//         data.push([$('.passerelles')[i].id.charAt(2),$('.passerelles')[i].checked]);
//     }

    for( var i = 0; i < $('.passerelles').length ; i++){
        if($('.passerelles')[i].checked == true){
            data.push($('.passerelles')[i].id.charAt(2));
        }
      
    }
// console.log(JSON.stringify(data));

if(data.length > 0){
    
    $(location).attr('href','{{url("/diffusion/prog/date_annonce/")}}/'+JSON.stringify(data)+'/'+bien_id);

    
    // $.ajaxSetup({
    //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    // })
    // $.ajax({
    //     type:"GET",
    //     url: '/diffusion/prog/date_annonce',
    //     data: {"passerelles" : JSON.stringify(data),"bien_id":bien_id},    
    //     success: function (data) {
    //     console.log(data);
    //     //  location.reload();
    //     },
    //     error: function(error){
    //         console.log(error);
    //     }
    //   });

}



    

    // console.log(data);

});

</script>
@endsection
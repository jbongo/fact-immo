@extends('layouts.app')
@section('content')
@section('page_title')
    Diffusion automatique
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
                                        <button data-toggle="modal" id="{{$bien->id}}" data-target="#add-category" class="btn  btn-blue btn-flat btn-addon btn-md m-b-10 m-l-5 amodal " style="background-color: #5b7c8a" type="button"><i class="ti-pencil"></i>@lang('Passerelles')</button>
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

    
    <!-- BEGIN MODAL -->

<!-- Modal Add Category -->
<div class="modal fade none-border" id="add-category" style="display: block; margin:auto; width:50%; " >
    <div class="modal-dialog2" >
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>@lang('Cochez les passerelles pour ce bien') </strong></h4>
            </div>

            <form action="#" method="POST">
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
                <input type="submit" class="btn btn-success waves-effect valider"  id="" value="@lang('Valider')" />
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
            var passerelles_all = passerelles[0];
            var pass_bien = passerelles[1];
  
            // on reccupère dans un tab uniquememt les id des passerelles sur lesquelles le bien est diffusé
            var passerelles_bien = Array();
            pass_bien.forEach(data => {                
                passerelles_bien.push(data.passerelle_id);
            });

            
            var check = "";
            
            for(var i = 0; i <= passerelles_all.length -1; i++){

                if( ($.inArray(passerelles_all[i].id, passerelles_bien)) != -1 ){
                    check = "checked";
                }
                else{
                    check ="";
                }

                if(passerelles_all[i].type == "Avec abonnement"){
                    $("#avec-abon").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles_all[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]" '+check+'  id= "'+id+'_'+passerelles_all[i].id+'"></div></div>');                    
                }else if(passerelles_all[i].type == "Sans abonnement"){
                    $("#sans-abon").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles_all[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]" '+check+'  id= "'+id+'_'+passerelles_all[i].id+'"></div></div>');
                }else if(passerelles_all[i].type == "Institutionnelle et partenaire"){
                    $("#insti").append('<div class="form-group row linetop"><div class="col-lg-8"><img src="{{asset("images/passerelles/")}}/'+passerelles_all[i].logo+'") width="130px" height="90px" alt=""></div><div class="col-lg-4"><input class="form-control passerelles" type="checkbox" name="passerelles[]"  '+check+' id= "'+id+'_'+passerelles_all[i].id+'"></div></div>');                    
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


    for( var i = 0; i < $('.passerelles').length ; i++){
        data.push([$('.passerelles')[i].id.split("_")[1],$('.passerelles')[i].checked]);
        // data.push([$('.passerelles')[i].id.charAt(2),$('.passerelles')[i].checked]);
        
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    $.ajax({
        type:"POST",
        url: '/passerelle/attach/'+bien_id,
        data: {"pass_bien" : JSON.stringify(data)},    
        success: function (data) {
        $('.close').click();
        //  location.reload();
        console.log(data);

        },
        error: function(error){
            console.log(error);
        }
      });



});



    </script>
@endsection
@extends('layouts.app')
@section('content')
@section('page_title')
Liste des diffusions
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
    <div class="col-lg-5 col-md-5">
        <a href="{{route('diffusion_prog.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5"><i class="ti-arrow-left "></i>@lang('Retour')</a>
    </div>
</div>
<div class="row">

    <div class="col-lg-6 col-md-6">
            <div class="card alert nestable-cart">
                <div class="card-header">
                    <p>
                        <h4><strong style="color:blueviolet;">@lang('Diffusions')</strong><a href="#"> </a></h4>
                        <br>
                        <a type="button" href="{{route('diffusion_prog.show',['all',$bien->id])}}" class="btn @if($type=="all") btn-default @endif  btn-rounded  m-l-10 m-b-10" type="button"> <span class="badge">{{$nb_all}}</span> @lang('Toutes les diffusions') </a>
                        <a type="button" href="{{route('diffusion_prog.show',['next',$bien->id])}}" class="btn @if($type=="next") btn-default @endif btn-rounded  m-l-10 m-b-10" type="button"> <span class="badge">{{$nb_next}}</span> @lang('prochaines diffusions') </a>
                        <a type="button" href="{{route('diffusion_prog.show',['now',$bien->id])}}" class="btn @if($type=="now") btn-default @endif btn-rounded  m-l-10 m-b-10" type="button"> <span class="badge">{{$nb_now}}</span> @lang('Diffusions en cour') </a>

                </div>
            </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card alert nestable-cart">
            <div class="card-header">
                <p>
                    <h4><strong style="color:blueviolet;">{{$bien->type_bien}} - {{$bien->prix_public}} €</strong><a href="#"> </a></h4>
                   
                    @php
                        $bien_id = Crypt::encrypt($bien->id);
                    @endphp
                    <br>
                    {{$bien->titre_annonce}} <a href="{{route('bien.show',$bien_id)}}" target="blank" class="btn btn-pink btn-rounded  m-l-5">@lang('Voir détail')</a>
                   
                </p>
            </div>
        </div>
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
                                        <th>@lang('Date de début')</th>                                        
                                        <th>@lang('Date de fin')</th>                
                                        <th>@lang('Annonce')</th>                
                                        <th>@lang('Passerelles')</th>                
                                        <th>@lang('Actions')</th>                
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($diffusions as $diffusion)
                                    {{-- @foreach($bien->passerelles as) --}}
                                    <tr>
                                    
                                        <td width="10%">
                                            <b> <span style="color:blue">{{Carbon\Carbon::parse($diffusion->date_debut)->format("d/m/y")}}</b> </span>    
                                                                 
                                        </td>
                                        <td  width="10%">
                                       
                                            <b> <span style="color:blue">{{Carbon\Carbon::parse($diffusion->date_fin)->format("d/m/y")}}</b> </span>                                   
                                        </td>
                                                        
                                        <td>
                                            <b> <span style="color:blue">{{$diffusion->annonce->identifiant_annonce}}</b> </span> 
                                            @php
                                                $annonce_id = Crypt::encrypt($diffusion->annonce->id);
                                            @endphp
                                            <a href="{{route('annonce.edit',$annonce_id)}}" target="blank" class="btn btn-warning btn-rounded  ">@lang(' détail')</a>
                                            </h5>                                            

                                        </td>   
                                        <td>
                                            @php
                                                $passerelles_id = json_decode($diffusion->passerelles, true);
                                                $passerelles = App\Models\Passerelles::whereIn('id',$passerelles_id)->get();
                                            @endphp

                                            @foreach ($passerelles as $passerelle)
                                                
                                                <img src="{{asset("images/passerelles/".$passerelle->logo)}}" width="60px" alt="">
                                            @endforeach
                                     
                                        </td>                           
                                        <td>                                             
                                        <a type="button" id="{{$diffusion->id}}" class="btn btn-danger btn-rounded  m-l-10 m-b-10 delete" type="button"><i class="ti-trash "></i> @lang('Supprimer') </a>
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

}



    


});

// Supprimer une diffusion
$(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            
            $('[data-toggle="tooltip"]').tooltip()
            $('.delete').click(function(e) {
                let that = $(this);                
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-15',
            buttonsStyling: false,
            })

        swalWithBootstrapButtons({
            title: '@lang('êtes vous sur de vouloir supprimer ?')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: '@lang('Oui')',
            cancelButtonText: '@lang('Non')',
            
        }).then((result) => {
            if (result.value) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: '{{url("diffusion/prog/delete/")}}/'+that.attr('id'),
                        type: 'POST'
                    })
                    .done(function (data) {
                          
                           location.reload();
                    }).error(function (data) {
                           console.log(data);
                        })
                swalWithBootstrapButtons(
                'Archivé!',
                'L\'utilisateur a bien été archivé.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'L\'utlisateur n\'a pas été archivé :)',
                'error'
                )
            }
        })
            })
        })

</script>
@endsection
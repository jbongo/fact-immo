@extends('layouts.app')
@section('content')
    @section ('page_title')
    Archive des affaires
    @endsection

    <div class="row"> 
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
            <div class="card alert">
            @if (Auth()->user()->role == "mandataire")
                <a href="{{route('compromis.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle affaire')</a>
            <br><br>
            @endif
                <!-- table -->
                

                <div class="row"> 
       
                    <div class="col-lg-12">
                           
                        <div class="card alert">
                            <!-- table -->
                          
                            
                            <div class="card-body">
                                    <div class="panel panel-info ">
                                            <div class="panel-body">
                
                                    <div class="table-responsive" >
                                        <table  id="example" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%">
                                            <thead>
                                                {{-- table table-striped table-hover dt-responsive display nowrap --}}
                                                <tr>
                                                    @if (Auth()->user()->role == "admin")
                                                    <th>@lang('Mandataire')</th>
                                                    @endif
                                                    @if(Auth()->user()->role == "mandataire")
                                                    <th>@lang('porte l\'affaire')</th>
                                                    @endif
                                                    <th>@lang('Numero Styl')</th>
                                                    <th>@lang('Mandat')</th>
                                                    <th>@lang('Date vente')</th>
                                                    <th>@lang('Comm')</th>
                                                    {{-- <th>@lang('Date Mandat')</th> --}}
                                                    <th>@lang('Partage')</th>
                
                                                    <th>@lang('Action') </th>
                                                </tr>
                                            </thead>
                                            @php  $grise = ""; @endphp
                                            <tbody>
                                                @foreach ($compromis as $compromi)
                                                <tr>
                                                    @if (Auth()->user()->role == "admin")
                                                    <td  >
                                                    <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->user->nom}}">{{$compromi->user->nom}} {{$compromi->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                                    </td> 
                                                    @endif
                                                    @if(Auth()->user()->role == "mandataire")
                                                    <td >
                                
                                                        @if($compromi->je_porte_affaire == 0  || $compromi->agent_id == Auth()->user()->id)
                                                            <span class="badge badge-danger">Non</span>
                                                            {{-- @php  $grise = "background-color:#EDECE7"; @endphp --}}
                                                        @else
                                                            @php  $grise = ""; @endphp
                                                            <span class="badge badge-success">Oui</span>
                                                        @endif
                
                                                    </td>  
                                                    @endif 
                                                    <td width="" >
                                                        @if($compromi->getFactureStylimmo()!=null)
                                                        <a class="color-info" title="Télécharger la facture stylimmo"  href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($compromi->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromi->getFactureStylimmo()->numero}} <i class="ti-download"></i> </a>
                                                        @else 
                                                            <span class="color-warning">En attente ..</span>                                            
                                                        @endif
                                                    </td>
                                                    <td  style="color: #e05555;{{$grise}}">
                                                        <strong> {{$compromi->numero_mandat}}</strong> 
                                                    </td> 
                                                    <td >
                                                        @php
                                                            $mois = ['','Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
                                                        @endphp 
                                                        @if($compromi->date_vente != null)
                                                            @if(strtotime($compromi->date_vente->format('d-m-Y')) > strtotime(date("d-m-Y")) || $compromi->demande_facture > 0)
                
                                                            <strong> @if($compromi->date_vente != null) {{$mois[ (int)$compromi->date_vente->format("m")]}} - {{$compromi->date_vente->format("Y")}} @endif</strong> 
                                                            @else 
                                                            <strong>  <label title="La date de vente prévue est dépassée. Vous pouvez la modifier dans votre affaire" style="background-color:#FF0633;color:white;visibility:visible;">@if($compromi->date_vente != null) {{$mois[ (int)$compromi->date_vente->format("m")]}} - {{$compromi->date_vente->format("Y")}} @endif !!! &nbsp;&nbsp;</label>  </strong> 
                                                            @endif 
                                                        @endif
                                                    </td>    
                                             
                                                    
                                                    <td  style="{{$grise}}">
                                                        @php
                                                            $com = ($compromi->frais_agence / 1000) . ' K';
                                                        
                                                        @endphp
                                                        {{$com}} €
                                                        {{-- {{number_format($compromi->frais_agence,'2','.',' ')}} €    --}}
                                                    </td>
                                                    {{-- <td  style="{{$grise}}">
                                                   @if($compromi->date_mandat != null) {{$compromi->date_mandat->format('d/m/Y')}} @endif  
                                                    </td> --}}
                                                    <td width="">
                
                                                        @if($compromi->est_partage_agent == 0)
                                                            <span class="badge badge-danger">Non</span>
                                                        @else
                                                            @if(Auth()->user()->role == "admin")
                                                            {{-- <span class="badge badge-success">Oui</span> --}}
                                                            
                                                            @if($compromi->getPartage()!= null && $compromi->partage_reseau == 1) 
                                                                <strong> <a href="{{route('switch_user',Crypt::encrypt($compromi->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$compromi->getPartage()->nom}}">{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a> </strong> 
                                                            @else 
                                                                <strong> <a  data-toggle="tooltip" title="@lang('Agence / Agent externe au réseau STYL\'IMMO') ">{{$compromi->nom_agent}} </a> </strong> 
                                                            @endif
                                                            @else 
                                                                @if($compromi->getPartage() != null)
                                                                    @if ($compromi->getPartage()->id == Auth()->user()->id)
                                                                        <strong> <a >{{$compromi->user->nom}} {{$compromi->user->prenom}}</a> </strong>
                                                                    @else 
                                                                        <strong> <a >{{$compromi->getPartage()->nom}} {{$compromi->getPartage()->prenom}}</a> </strong>
                                                                    @endif
                                                                @else 
                                                                    {{$compromi->nom_agent}}
                
                                                                @endif
                
                                                            @endif
                
                                                        @endif
                
                                                    </td>        
                                                                         
                                                  
                                                    <td width="">
                                                        <a href="{{route('compromis.show',Crypt::encrypt($compromi->id))}}" data-toggle="tooltip" title="@lang('Détails  ')"><i class="large material-icons color-info">visibility</i></a> 
                                                    <span><a data-toggle="modal" id="{{$compromi->id}}" data-mandat="{{$compromi->numero_mandat}}" data-target="#myModal2"  href="{{route('compromis.archive.restaurer',$compromi->id)}}" class="restaurer" data-toggle="tooltip" title="@lang('Restaurer ') {{ $compromi->numero_mandat }}"><i class="large material-icons color-danger">replay</i> </a></span>
                                                    </td>
                                                </tr>
                                        @endforeach
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                
                                </div>
                            <!-- end table -->
                        </div>
                    </div>
                </div>
                


            </div>
        </div>
    </div>
@endsection
@section('js-content')
<script>

// $('.restaurer').on('click',function(e){
//       archive_id = $(this).attr('id');
//    });
   
  

   $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click','a.restaurer',function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

swalWithBootstrapButtons({
    title: 'Confirmez-vous la restauration de cette affaire (Mandat '+that.attr("data-mandat")+' )  ?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: '@lang('Oui')',
    cancelButtonText: '@lang('Non')',
    
}).then((result) => {
    if (result.value) {
        $('[data-toggle="tooltip"]').tooltip('hide')
            $.ajax({                        
                url: that.attr('href'),
                type: 'POST',
                success: function(data){
                document.location.reload();
                },
                error : function(data){
                console.log(data);
                }
            })
            .done(function () {
                    that.parents('tr').remove()
            })

        swalWithBootstrapButtons(
        'Restaurée!',
        'L\'affaire a bien été restaurée.',
        'success'
        )
        
        
    } else if (
        // Read more about handling dismissals
        result.dismiss === swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons(
        'Annulé',
        'L\'affaire n\'a pas été restaurée.',
        
        'error'
        )
    }
})
    })
}) 



































// $('#valider_archive').on('click',function(e){
//  e.preventDefault();

// if($("#motif_archive").val() != ""){

//     $.ajaxSetup({
//                 headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
//             })
//    $.ajax({

//          type: "POST",
//          url: "compromis/archiver/"+archive_id ,
//          data:  $("#form_archive").serialize(),
//          success: function (result) {
//             console.log(result); 
//             document.location.reload();
//          },
//          error: function(error){
//             console.log(error);
            
//          }
//    });
// }


// });
    </script>
@endsection
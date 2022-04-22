
 @extends('layouts.app')
 @section('content')
     @section ('page_title')
     Export Factures fournisseurs 
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
                 <!-- table -->
                
                
                    
                <div class="row">
                    <form action="{{route('winfic.index_fournisseur')}}" method="GET">
                    @csrf
                    <div class="col-md-3 col-lg-3 col-sm-4">
                        <div class="form-group row">
                            <label class="col-lg-12 col-md-12 col-sm-12 control-label" for="date_deb">Date de début </label>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <input type="date"  class="form-control {{ $errors->has('date_deb') ? ' is-invalid' : '' }} champs" value="{{$date_deb}}" id="date_deb" name="date_deb"  >
                                @if ($errors->has('date_deb'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{$errors->first('date_deb')}}</strong> 
                                </div>
                                @endif   
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-lg-3 col-sm-4">
                        <div class="form-group row">
                            <label class="col-lg-12 col-md-12 col-sm-12 control-label" for="date_fin">Date de fin  </label>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <input type="date"  class="form-control {{ $errors->has('date_fin') ? ' is-invalid' : '' }} champs " value="{{$date_fin}}" id="date_fin" name="date_fin"  >
                                @if ($errors->has('date_fin'))
                                <br>
                                <div class="alert alert-warning ">
                                    <strong>{{$errors->first('date_fin')}}</strong> 
                                </div>
                                @endif   
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 col-lg-2 col-sm-2">
                        <div class="form-group row">
                            <label class="col-lg-12 col-md-12 col-sm-12 control-label"> .</label> <br>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                          
                                <input type="submit" class="btn btn-lg btn-danger" value="Sélectionner">                                   
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-12 col-md-12 col-sm-12 control-label"> .</label> <br>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                          
                                {{-- <a href="{{route('merge_facture', [$date_deb, $date_fin])}}" target="_blank" class="btn btn-lg btn-danger btn-flat btn-addon  m-b-10 m-l-5 "><i class="ti-download"></i>Factures PDF</a> --}}
                            <a href="{{route('winfic.index')}}"  class="btn btn-md btn-default btn-flat btn-addon  m-b-10 m-l-5 " ><i class="ti-angle-double-left"></i>Exports Ventes</a>

                            
                            </div>
                        </div>
                    </div>
                    
                                
                        
                     
                     </form>
                     
                     
                    
                     
                </div>

                <div class="row">               
               
                    
                    <div class="col-md-6 col-lg-6 col-sm-6"></div>
                    <div style="display:flex; flex-direction:row; justify-content:center;">
                       <span style="font-size:17px; color:rgb(17, 72, 72); margin-right:10px">Factures déjà exportées:</span>  <span style="font-size:20px; color:rgb(184, 5, 53);font-weight:bold;"> {{$nbFacturesExporte}}</span>
                    </div>
                    
                </div>
                
               
               <div class="row">
                
                <form action="#" method="post">
                    @csrf
                    <label style="font-weight: bold;">Saisir les codes pièces de départ :</label>
                    @foreach ($mois_factures as $mois)
                        <label for="{{$mois}}">{{$mois}}</label> <input style="width: 50px;" type="number" min="1" class="control-form champs mois" name="{{$mois}}" id="{{$mois}}" required>  <span style="font-size:25px; color:blue"> |</span>
                    @endforeach
                    
                    
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label for="selection">Tout Sélectionner</label>
                            <input type="checkbox" checked class="selection_parent" name="selection" id="selection">
                        
                        
                       
                            
                            <button  id="valider_selection" class="btn btn-lg btn-primary btn-flat btn-addon  m-b-10 m-l-5 "><i class="ti-download"></i>Exporter Fournisseurs</button>
                            
                            
                        </div>
                        <div style="display:flex; flex-direction:row; justify-content:center;">
                            <div class="col-md-5 col-lg-5 col-sm-5">
                                <label for="" style="font-size:17px; font-weight:bold; color:#ff0000">Débit: {{$montant_credit_debit}}</label>
                                
                            </div>
                            
                            <div class="col-md-5 col-lg-5 col-sm-5">
                                <label for="" style="font-size:17px; font-weight:bold; color:#06cd2e">Crédit: {{$montant_credit_debit}}</label>
                            </div>
                         </div>
                    </div>
                    
                    
                    
                </form>
                    
                
               </div>
                     
                    
                <div class="row">
             
             
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" >
                            <table  id="example01" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                <thead>
                                    <tr>
                                       
                                        <th>#</th>
                                        <th>@lang('N° Facture ')</th>
                                        <th>@lang('Date règlement')</th>
                                        <th>@lang('Date facture')</th>
                                        <th>@lang('Facture Stylimmo')</th>
                                    
                                       
                                        <th>@lang('Mandataire')</th>
                                        <th>@lang('Code client')</th>
                                
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                              

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureFournisseurs as $facture)

                                    <tr @if($facture->exporte == true )style="background-color:#e4cb49;" @endif>
                                        <td><input class="selection_child" checked type="checkbox" id="{{$facture->id}}" class="form-control"> <span for="{{$facture->id}}">@if($facture->date_export != null) Epxort le {{$facture->date_export->format('d/m/Y')}} @endif</span></td>
                                    
                                        <td width="" >
                                            <a class="color-info" title="Télécharger la facture" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                               
                                        </td>
                                        
                                        <td width="" >
                                            <label class="color-danger"style="font-weight:bold;" >{{$facture->date_reglement->format('d/m/Y')}}  </label>
                                        </td>
                                        <td width="" >
                                            <label class="color-primary"style="font-weight:bold;" >{{$facture->date_facture->format('d/m/Y')}}  </label>
                                        </td>
                                        
                                        <td width="" >
                                          
                                             @if($facture->compromis != null)
                                               
                                                 <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </a>
                                                 
                                             @endif
                                         
                                         </td>
                                     
                                        <td width="" >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                @endif
                                            </label> 
                                        </td>
                                   
                                        <td width="" >
                                            <label class="color-info"> @if($facture->user != null) {{$facture->user->code_client}}  @endif</label> 
                                        </td>
                                        {{-- <td width="" >
                                            <label class="color-danger"> @if($facture->user != null) {{$facture->user->code_analytic}}  @endif</label> 
                                        </td> --}}
                                        <td  width="" >
                                        {{number_format($facture->montant_ht,'2','.','')}}
                                        </td>
                                        <td  width="" >
                                        {{number_format($facture->montant_ttc,'2','.','')}}
                                        </td>
                                      
                                        
                                    </tr> 
                               
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>



 
    </div>
    </div>
</div>
</div>

<style>
.champ_manquant{

background-color: #9f6e9f;
}
</style>
@endsection

@section('js-content')

    
    {{-- SELECTION DESELECTION --}}
    
    
    <script>
    
        $('.selection_parent').click(function(e){
        
        
            if($('.selection_parent').is(':checked')){
            
                $('.selection_child').prop('checked',true);
            
            }else{
                $('.selection_child').prop('checked',false);
            
            
            }
        
        });
        
        
        
        
        
        
        
        // Export des factures sélectionnées
        
        
        $(function() {
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                })
                $('[data-toggle="tooltip"]').tooltip()
                $('#valider_selection').click(function(e) {
                
                    
             
                    let that = $(this)
                    e.preventDefault()
                    
                    
                    const swalWithBootstrapButtons = swal.mixin({
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false,
                        });
    
            
            vide = false;
                    
              $('.mois').each( function (){
                    
  
              
                    if($(this).val() =="" ) {
                 
                        $(this).addClass('champ_manquant');
                        vide = true;
                        swalWithBootstrapButtons(
                            'Remplissez tous les champs',
                            '',
                            'error'
                        );
                    }else{
                        $(this).removeClass('champ_manquant');
                    }
        
              
              }) 
                    
                    
                    
             
                    
                    
                    
                    
              if(vide == true ) { console.log("vide"); return true ;}
                    
                    
                    
                    
                    
                    
                   
                    swalWithBootstrapButtons({
                        title: 'Voulez-Vous exporter les factures sélectionnées  ?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: '@lang('Oui')',
                        cancelButtonText: '@lang('Non')',
                        
                    }).then((result) => {
                        if (result.value) {
                            $('[data-toggle="tooltip"]').tooltip('hide')
                            
                            
                            datas = Array();       
                    
                            $('.selection_child').map(function(){
                                
                                if( this.checked == true){
                                    datas.push(this.id)
                                    return this.id;
                                }
                              
                            })
                            
                            
                            datas = {
                            'periodes': decodeURIComponent ($('.champs').serialize()),
                            'list_id':datas
                            };
                            // datas = JSON.stringify(datas);
                            

                    
                                $.ajax({                        
                                    url: "{{route('winfic.exporter_ecriture3', [$date_deb, $date_fin])}}",
                                    data: datas,
                                    type: 'POST',
                                    success: function(data){
                                            
                                        console.log(data);
                                        window.location.href = "/winfic/download/";
                                        // setInterval(() => {
                                            
                                        //     location.reload();
                                        // }, 500);
                        
                                    },
                                    error : function(data){
                                    console.log(data);
                                    }
                                })
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Annulation:)',
                    'error'
                    )
                }
            })
                })
            });
            
            
       
        
        </script>
@endsection
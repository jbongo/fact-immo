
 @extends('layouts.app')
 @section('content')
     @section ('page_title')
     Export WINFIC    <a href="{{route('winfic.code_analytic_client')}}" target="_blank" class=" btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-list"></i>liste des Codes clients</a>
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
                        <form action="{{route('winfic.index')}}" method="GET">
                        @csrf
                        <div class="col-md-3 col-lg-3 col-sm-4">
                            <div class="form-group row">
                                <label class="col-lg-12 col-md-12 col-sm-12 control-label" for="date_deb">Date de début </label>
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <input type="date"  class="form-control {{ $errors->has('date_deb') ? ' is-invalid' : '' }}" value="{{$date_deb}}" id="date_deb" name="date_deb"  >
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
                                    <input type="date"  class="form-control {{ $errors->has('date_fin') ? ' is-invalid' : '' }}" value="{{$date_fin}}" id="date_fin" name="date_fin"  >
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
                        
                        <div class="col-md-2 col-lg-2 col-sm-2">
                            <div class="form-group row">
                                <label class="col-lg-12 col-md-12 col-sm-12 control-label"> .</label> <br>
                                <div class="col-lg-10 col-md-10 col-sm-10">
                              
                                    <a href="{{route('winfic.exporter_ecriture', [$date_deb, $date_fin])}}"  class="btn btn-lg btn-warning btn-flat btn-addon  m-b-10 m-l-5 "><i class="ti-download"></i>Exporter ECRITURE.WIN</a>
                                    <a href="{{route('winfic.exporter_ecrana', [$date_deb, $date_fin])}}"  class="btn btn-lg btn-default btn-flat btn-addon  m-b-10 m-l-5 "><i class="ti-download"></i>Exporter ECRANA.WIN</a>
                                
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
                            <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Facture Stylimmo')</th>
                                        <th>@lang('Date facture')</th>
                                        <th>@lang('Mandat')</th>
                                        <th>@lang('Charge')</th>
                                       
                                        <th>@lang('Mandataire')</th>
                                        <th>@lang('Code client')</th>
                                        {{-- <th>@lang('Code analytique')</th> --}}
                                    
                                        {{-- <th>@lang('Type Facture')</th> --}}
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        {{-- @if(auth()->user()->role == "admin") --}}
                                        <th>@lang('Alerte paiement')</th>
                                  

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureStylimmos as $facture)

                                    <tr>
                                        <td width="" >
                                           @if($facture->type != "avoir")
                                                @if($facture->compromis != null)
                                                  
                                                    <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                
                                                @else 
                                                    
                                                    @if($facture->type == "pack_pub" )
                                                        <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_fact_pub', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                    
                                                    @else 
                                                        <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                    @endif
                                                    
                                                @endif
                                            @else 
                                            <a class="color-info" title="Télécharger la facture d'avoir" href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> AV</a>

                                            @endif
                                        </td>
                                        
                                        <td width="" >
                                            <label class="color-danger">{{$facture->date_facture->format('d/m/Y')}}  </label>
                                        </td>
                                        <td width="" >
                                            {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                            @if($facture->compromis != null)
                                                 <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>
                                            @else 
                                                <label class="color-danger">{{$facture->type}}  </label>
                                            @endif
                                        </td>
                                        <td  style="">

                                            @if($facture->compromis != null) 

                                                @if($facture->compromis->charge == "Vendeur")
                                                    <strong>{{ substr($facture->compromis->nom_vendeur,0,20)}}</strong> 
                                                @else
                                                    <strong>{{ substr($facture->compromis->nom_acquereur,0,20)}}</strong> 
                                                @endif   
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
                                        {{-- <td  width="" class="color-info">
                                                {{$facture->created_at->format('d/m/Y')}}
                                        </td> --}}
                                        {{-- @if($facture->type == "stylimmo") --}}
                                        

                                        {{-- @else 
                                        <td width="" style="background-color:#DCD6E1" >
                                            
                                        </td>
                                        @endif --}}
                                        {{--  alert paiement--}}
                                        @php
                                         if($facture->compromis != null){
                                             $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                            $diff_jours = $interval / 86400 ;
                                         }
                                            
                                        
                                        @endphp
                                       
                                        @if($facture->type == "stylimmo" && $facture->a_avoir == false)
                                        <td width="" >

                                            @if($facture->compromis != null)
                                                @if( $facture->encaissee == false && $diff_jours < 3)
                                                    <label  style="color:lime">En attente de paiement</label>
                                                @elseif( $facture->encaissee == false && $diff_jours >=3 && $diff_jours <=6)
                                                    <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                                @elseif($facture->encaissee == false && $diff_jours >6) 
                                                    <label class="danger" style="background-color:#FF0633;color:white;visibility:visible;">Danger !!! &nbsp;&nbsp;</label>
                                                @elseif($facture->encaissee == true)
                                                    <label  style="background-color:#EDECE7">En banque  </label>
                                                @endif
                                            @endif
                                        </td>

                                        @elseif($facture->type == "pack_pub" && $facture->reglee == true) 
                                            
                                        <td width=""  >
                                            <label data-toggle="tooltip" title="Facture pub réglée par le mandataire"  style="color:rgb(255, 4, 0);">Réglée le {{$facture->date_reglement->format('d/m/Y')}} </label>
                                        </td>
                                        
                                        @else 
                                        <td width="" style="background-color:#DCD6E1" >
                                           
                                        </td>
                                        @endif
                                   
                              
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
@endsection

@section('js-content')

@endsection
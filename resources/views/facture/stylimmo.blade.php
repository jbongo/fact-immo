
 
                <!-- table -->
                @if(Auth::user()->role == "admin")
                <div class="row">

                   <form action="{{route('facture.index')}}" method="GET">
                    @csrf
                        <div class="col-md-4">
                            <label>Date de début</label>
                                <input type="date" required name="date_deb" id="date_deb" value="{{$date_deb}}" class="form-control">
                        </div>
                    
                        <div class="col-md-4">
                            <label>Date de fin</label>
                                <input type="date" required name="date_fin" id="date_fin" value="{{$date_fin}}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>.</label>
                        
                            <button id="trier" class="btn btn-danger form-control">Trier</button>
                        </div>
                    
                   </form>
                </div>
                <br><hr>
                @endif
                                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive " >
                            <table  id="example1" class=" table student-data-table   table-striped table-hover dt-responsivexxxxxxxx display    "  style="width:100%"  >
                                <thead class="test">
                                    <tr>
                                       
                                        <th>@lang('Fact Stylimmo')</th>
                                        <th>@lang('Mandat')</th>
                                        @if(auth()->user()->role != "admin")                                        
                                        <th>@lang('Charge')</th>
                                        @else
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        <th>@lang('Partage')</th>
                                  
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                   
                                        <th>@lang('Date de l\'acte')</th>
                                   
                                        <th>@lang('Alerte paiement')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>

                                        <th>@lang('Etat')</th>

                                        @endif
                                        {{-- @endif --}}
                                        {{-- <th>@lang('Télécharger')</th> --}}
                                        <th>@lang('Avoir')</th>

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
                                            {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                            @if($facture->compromis != null)
                                                 <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>
                                            @else 
                                                <label class="color-danger">{{$facture->type}}  </label>
                                            @endif
                                        </td>
                                   
                                        
                                        @if(auth()->user()->role != "admin")
                                        <td  style="">

                                            @if($facture->compromis != null) 

                                                @if($facture->compromis->charge == "Vendeur")
                                                    <strong>{{ substr($facture->compromis->nom_vendeur,0,20)}}</strong> 
                                                @else
                                                    <strong>{{ substr($facture->compromis->nom_acquereur,0,20)}}</strong> 
                                                @endif   
                                            @endif
                                        </td>
                                        @else
                                        <td width="" >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                @endif
                                            </label> 
                                        </td>
                                        @endif
                                        
                                        
                                            
                                        <td width="">
                                            @if($facture->compromis != null) 
                                                @if($facture->compromis->est_partage_agent == 0)
                                                    <span class="badge badge-danger">Non</span>
                                                @else
                                                    @if(Auth()->user()->role == "admin")
                                                    {{-- <span class="badge badge-success">Oui</span> --}}
                                                    
                                                        @if($facture->compromis->getPartage()!= null && $facture->compromis->partage_reseau == 1) 
                                                            <strong> <a href="{{route('switch_user',Crypt::encrypt($facture->compromis->getPartage()->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->compromis->getPartage()->nom}}">{{$facture->compromis->getPartage()->nom}} {{$facture->compromis->getPartage()->prenom}}  <i style="font-size: 17px" class="material-icons color-success">person_pin</i> <span class="color-danger"> ({{100-$facture->compromis->pourcentage_agent}}%)</a> </strong> 
                                                        @else 
                                                            <strong> <a  data-toggle="tooltip" title="@lang('Agence / Agent externe au réseau STYL\'IMMO') ">{{$facture->compromis->nom_agent}} <span class="color-danger"> ({{100-$facture->compromis->pourcentage_agent}}%) </a> </strong> 
                                                        @endif
                                                    @else 
                                                        @if($facture->compromis->getPartage() != null)
                                                            @if ($facture->compromis->getPartage()->id == Auth()->user()->id)
                                                        <strong> <a >{{$facture->compromis->user->nom}} {{$facture->compromis->user->prenom}} <span class="color-danger"> ({{$facture->compromis->pourcentage_agent}}%) </span></a> </strong>
                                                            @else 
                                                                <strong> <a >{{$facture->compromis->getPartage()->nom}} {{$facture->compromis->getPartage()->prenom}}  <span class="color-danger"> ({{100-$facture->compromis->pourcentage_agent}}%) </span></a> </strong>
                                                            @endif
                                                        @else 
                                                            {{$facture->compromis->nom_agent}}
        
                                                        @endif
        
                                                    @endif
        
                                                @endif
                                            @endif
                                        </td>    
                                        
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
                                        <td width="" >
                                            @if($facture->compromis != null)
                                                <label class="color-info">
                                                    {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                                </label> 
                                            @endif
                                        </td>

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
                                    {{-- fin alert paiement --}}
                                        {{-- encaissement seulement par admin --}}
                                        @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            {{-- si c'est une facture d'avoir --}}
                                            @if($facture->type == "avoir")
                                                <label class="color-danger"> Avoir sur {{$facture->facture_avoir()->numero}}</label> 
                                            @else
                                                {{-- Si la facture stylimmo a un avoir --}}
                                                @if($facture->a_avoir == 1 && $facture->avoir() != null)
                                                    <label class="color-primary"> annulée par AV {{$facture->avoir()->numero}}</label> 

                                                @else
                                                    @if($facture->encaissee == 0)
                                                    <button   data-toggle="modal" data-target="#myModal2" class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" onclick="getId({{$facture->id}})"  id="{{$facture->id}}"><i class="ti-wallet"></i>Encaisser</button>
                                                    @else 
                                                    <label class="color-danger"> @if($facture->date_encaissement != null) encaissée le {{$facture->date_encaissement->format('d/m/Y')}} @else encaissée @endif  </label> 
                                                    @endif 
                                                @endif

                                            @endif
                                        </td>
                                        
                                        <td width="" >
                                            @if($facture->encaissee == true && $facture->compromis != null )
                                            <a href="{{route('compromis.etat', Crypt::encrypt($facture->compromis->id))}}"  target="_blank"  class="text-warning " id="visualiser">  <i class="material-icons">remove_red_eye</i> </a>
                                            
                                            {{-- @elseif($facture->type == "pack_pub" && $facture->reglee == true) --}}
                                            
                                            {{-- <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}" target="_blank" title="Confirmez que vous avez bien reçu le virement du mandataire" data-toggle="tooltip"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-help"></i>Confirmer l'encaissement</a> --}}
                                            
                                            @elseif($facture->type == "pack_pub" && $facture->reglee == false && $facture->encaissee == false && $facture->a_avoir != 1 )
                                                
                                            {{-- <a href="{{route('facture.relancer_paiement_facture',$facture->id)}}" target="_blank" title="Relancer le mandataire pour le payement de la facture" data-toggle="tooltip"  class="btn btn-danger  btn-flat btn-addon  m-b-10 m-l-5 relancer " id=""><i class="ti-email"></i>Relancer</a> --}}
                                                
                                            
                                            @endif
                                        </td> 
                                        @endif
                                       {{-- Avoir --}}
                                        <td width="" >

                                            @if($facture->type != "avoir")
                                                @if($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis != null  && auth()->user()->role == "admin") 

                                                    <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"   class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>

                                                @elseif($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis == null  && auth()->user()->role == "admin") 

                                                    <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
                                                @elseif($facture->a_avoir == 1 && $facture->avoir() != null)
                                                    <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->avoir()->id))}}"  class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5 " id=""><i class="ti-download"></i> {{$facture->avoir()->numero}}</a>
                                                @endif
                                            @endif
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
            


          
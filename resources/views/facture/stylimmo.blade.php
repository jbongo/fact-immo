
 
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" >
                            <table  id="example" class=" table table-striped table-hover dt-responsive "  >
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Facture Stylimmo')</th>
                                        <th>@lang('Mandat')</th>
                                        <th>@lang('Charge')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        {{-- <th>@lang('Type Facture')</th> --}}
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        <th>@lang('Date de l\'acte')</th>
                                        {{-- @if(auth()->user()->role == "admin") --}}
                                        <th>@lang('Alerte paiement')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
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
                                            
                                        <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>

                                        </td>
                                        <td width="" >
                                            {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                        <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>

                                        </td>
                                        <td  style="">
                                            @if($compromi->charge == "vendeur")
                                                <strong>{{ substr($facture->compromis->nom_vendeur,0,50)}}</strong> 
                                            @else
                                                <strong>{{ substr($facture->compromis->nom_acquereur,0,50)}}</strong> 
                                            @endif   
                                        </td>
                                        @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                               @endif
                                            </label> 
                                        </td>
                                        @endif
                                        {{-- <td width="" >
                                            <label class="color-info">{{$facture->type}} </label> 
                                        </td> --}}
                                        <td  width="" >
                                        {{number_format($facture->montant_ht,'2','.',' ')}}
                                        </td>
                                        <td  width="" >
                                        {{number_format($facture->montant_ttc,'2','.',' ')}}
                                        </td>
                                        {{-- <td  width="" class="color-info">
                                                {{$facture->created_at->format('d/m/Y')}}
                                        </td> --}}
                                        @if($facture->type == "stylimmo")
                                        <td width="" >
                                            <label class="color-info">
                                                {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                            </label> 
                                        </td>

                                        @else 
                                        <td width="" style="background-color:#DCD6E1" >
                                            
                                        </td>
                                        @endif
                                        {{--  alert paiement--}}
                                        @php
                                            $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                            $diff_jours = $interval / 86400 ;
                                        @endphp
                                       
                                        @if($facture->type == "stylimmo")
                                        <td width="" >
                                            @if( $facture->encaissee == false && $diff_jours < 3)
                                                <label  style="color:lime">En attente de paiement</label>
                                            @elseif( $facture->encaissee == false && $diff_jours >=3 && $diff_jours <=6)
                                                <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                            @elseif($facture->encaissee == false && $diff_jours >6) 
                                                <label class="danger" style="background-color:#FF0633;color:white;visibility:visible;">Danger !!! &nbsp;&nbsp;</label>
                                            @elseif($facture->encaissee == true)
                                                <label  style="background-color:#EDECE7">En banque  </label>
                                            @endif
                                        </td>

                                        @else 
                                        <td width="" style="background-color:#DCD6E1" >
                                           
                                        </td>
                                        @endif
                                    {{-- fin alert paiement --}}
                                        {{-- encaissement seulement par admin --}}
                                        @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            @if($facture->encaissee == 0)
                                            <button   data-toggle="modal" data-target="#myModal2" class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" id="{{$facture->id}}"><i class="ti-wallet"></i>Encaisser</button>
                                            @else 
                                            <label class="color-danger"> @if($facture->date_encaissement != null) encaissée le {{$facture->date_encaissement->format('d/m/Y')}} @else encaissée @endif  </label> 
                                            @endif 
                                        </td>
                                        @endif
                                        {{-- <td width="" >
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="telecharger"><i class="ti-download"></i>Télécharger</a>
                                        </td>  --}}
                                       {{-- Avoir --}}
                                        <td width="" >
                                            @if($facture->a_avoir == 0)
                                                <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
                                            @else
                                                <a href="{{route('facture.avoir.show', Crypt::encrypt($facture->id))}}"  class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5 " id=""><i class="ti-file"></i>Voir facture</a>
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
            


          
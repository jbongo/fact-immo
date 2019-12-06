
 
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Numéro Facture')</th>
                                        <th>@lang('Numéro Mandat')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        <th>@lang('Type Facture')</th>
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        <th>@lang('Date de l\'acte')</th>
                                        {{-- @if(auth()->user()->role == "admin") --}}
                                        <th>@lang('Alerte payement')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
                                        @endif
                                        {{-- @endif --}}
                                        <th>@lang('Télécharger')</th>
                                        <th>@lang('Avoir')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureEmises as $facture)

                                    <tr>
                                        <td width="" >
                                            <label class="color-info">{{$facture->numero}} </label> 
                                        </td>
                                        <td width="" >
                                            <label class="color-info">{{$facture->compromis->numero_mandat}} </label> 
                                        </td>
                                        @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                {{$facture->user->nom}} {{$facture->user->prenom}} 
                                               @endif
                                            </label> 
                                        </td>
                                        @endif
                                        <td width="" >
                                            <label class="color-info">{{$facture->type}} </label> 
                                        </td>
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
                                        {{--  alert payement--}}
                                        @php
                                            $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                            $diff_jours = $interval / 86400 ;
                                        @endphp
                                       
                                        @if($facture->type == "stylimmo")
                                        <td width="" >
                                            @if( $facture->encaissee == false && $diff_jours < 3)
                                                <label  style="color:lime">En attente de payement</label>
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
                                    {{-- fin alert payement --}}
                                        {{-- encaissement seulement par admin --}}
                                        @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            @if($facture->encaissee == 0)
                                            <a href="{{route('facture.encaisser_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" id="ajouter"><i class="ti-download"></i>Encaisser</a>
                                            @else 
                                            <label class="color-danger">Encaissée </label> 
                                            @endif 
                                        </td>
                                        @endif
                                        <td width="" >
                                            <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>
                                        </td> 
                                       {{-- Avoir --}}
                                        <td width="" >
                                            @if($facture->a_avoir == 0)
                                                <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info btn-flat btn-xs m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
                                            @else
                                                <a href="{{route('facture.avoir.show', Crypt::encrypt($facture->id))}}"  class="btn btn-danger btn-flat btn-xs m-b-10 m-l-5 " id=""><i class="ti-file"></i>Voir facture</a>
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
            
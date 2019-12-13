
 
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example1" class=" table student-data-table  m-t-20 "  style="width:100%">
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
                                        <th>@lang('Alerte payement')</th>

                                        {{-- @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
                                        @endif --}}

                                        <th>@lang('Facture')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureHonoraires as $facture)

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
                                        {{number_format($facture->montant_ht,2,'.',' ')}}
                                        </td>
                                        <td  width="" >
                                        {{number_format($facture->montant_ttc,2,'.',' ')}}
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
                                            $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                            $today = date_create(date('Y-m-d'));
                                            $interval = date_diff($today, $datevente);
                                        @endphp
                                        @if($facture->type == "stylimmo")
                                        <td width="" >
                                            @if( $facture->encaissee == false && $interval->days < 3)
                                                <label  style="color:lime">En attente de payement</label>
                                            @elseif( $facture->encaissee == false && $interval->days >=3 && $interval->days <=6)
                                                <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                            @elseif($facture->encaissee == false && $interval->days >6) 
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
                                        {{-- @if(auth()->user()->role == "admin")
                                        <td width="" >
                                            @if($facture->encaissee == 0)
                                            <a href="{{route('facture.encaisser_facture_stylimmo', Crypt::encrypt($facture->id))}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" id="ajouter"><i class="ti-download"></i>Encaisser</a>
                                            @else 
                                            <label class="color-danger">Encaissée </label> 
                                            @endif 
                                        </td>
                                        @endif --}}
                                        <td width="" >
                                            @if(auth::user()->role=="admin")
                                            {{-- @if ($facture->compromis->je_porte_affaire == 0  || $facture->compromis->agent_id == auth::user()->id || ($facture->compromis->je_porte_affaire == 1 && $facture->compromis->est_partage_agent == 1) ) --}}
                                                @if ($facture->type == "partage" )
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                @elseif($facture->type == "parrainage")
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                
                                                @elseif($facture->type == "parrainage_partage")
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage_partage',$facture->compromis->id)}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                @else 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    
                                                @endif
                                            @else
                                                <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>

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
            